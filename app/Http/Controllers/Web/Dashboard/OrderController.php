<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\Order\UpdateOrderRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'can:manage_orders']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Order::with(['user', 'child', 'items.product']);

            // Filter by status
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // Filter by payment status
            if ($request->filled('payment_status')) {
                $query->where('payment_status', $request->payment_status);
            }

            // Search by order ID, user name, or child name
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('order_id', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($userQuery) use ($search) {
                          $userQuery->where('name', 'like', "%{$search}%");
                      })
                      ->orWhereHas('child', function ($childQuery) use ($search) {
                          $childQuery->where('name', 'like', "%{$search}%");
                      });
                });
            }

            $orders = $query->orderBy('created_at', 'desc')->paginate(20);

            return view('dashboard.orders.index', compact('orders'));
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to fetch orders');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        try {
            $order->load(['user', 'child', 'items.product', 'payments']);
            return view('dashboard.orders.show', compact('order'));
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to display order');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        try {
            $order->load(['user', 'child', 'items.product']);
            return view('dashboard.orders.edit', compact('order'));
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to load order for editing');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        try {
            $validated = $request->validated();

            // Update order status
            $order->update($validated);

            // If order is completed, set completed_at timestamp
            if ($validated['status'] === 'completed' && $order->status !== 'completed') {
                $order->update(['completed_at' => now()]);
            }

            return redirect()->route('console.orders.show', $order)->with('success', 'Order updated successfully');
        } catch (ValidationException $e) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $e->getMessage());
            return back()->with('error', 'Failed to update order');
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->withInput()->with('error', 'Failed to update order');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        try {
            // Check if order can be deleted (not completed or paid)
            if ($order->status === 'completed' || $order->payment_status === 'paid') {
                return redirect()->back()->with('error', 'Cannot delete completed or paid orders');
            }

            $order->delete();

            return redirect()->route('console.orders.index')->with('success', 'Order deleted successfully');
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to delete order');
        }
    }

    /**
     * Update order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        try {
            $request->validate([
                'status' => 'required|string|in:pending,processing,shipped,completed,cancelled'
            ]);

            $oldStatus = $order->status;
            $order->update(['status' => $request->status]);

            // If order is completed, set completed_at timestamp
            if ($request->status === 'completed' && $oldStatus !== 'completed') {
                $order->update(['completed_at' => now()]);
            }

            return redirect()->back()->with('success', "Order status updated to {$request->status}");
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to update order status');
        }
    }

    /**
     * Update payment status.
     */
    public function updatePaymentStatus(Request $request, Order $order)
    {
        try {
            $request->validate([
                'payment_status' => 'required|string|in:unpaid,paid,partially_paid'
            ]);

            $order->update(['payment_status' => $request->payment_status]);

            return redirect()->back()->with('success', "Payment status updated to {$request->payment_status}");
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to update payment status');
        }
    }

    /**
     * Export orders.
     */
    public function export(Request $request)
    {
        try {
            $query = Order::with(['user', 'child', 'items.product']);

            // Apply filters
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('payment_status')) {
                $query->where('payment_status', $request->payment_status);
            }

            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            // Search filter
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('order_id', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($userQuery) use ($search) {
                          $userQuery->where('name', 'like', "%{$search}%");
                      })
                      ->orWhereHas('child', function ($childQuery) use ($search) {
                          $childQuery->where('name', 'like', "%{$search}%");
                      });
                });
            }

            $orders = $query->orderBy('created_at', 'desc')->get();

            // Generate CSV
            $filename = 'orders_' . date('Y-m-d_H-i-s') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Cache-Control' => 'no-cache, must-revalidate',
                'Pragma' => 'no-cache',
            ];

            $callback = function () use ($orders) {
                $file = fopen('php://output', 'w');

                // Add BOM for UTF-8
                fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

                // CSV headers
                fputcsv($file, [
                    'Order ID',
                    'Customer Name',
                    'Customer Email',
                    'Child Name',
                    'Items Count',
                    'Subtotal',
                    'Discount Amount',
                    'Total Amount',
                    'Order Status',
                    'Payment Status',
                    'Order Date',
                    'Completed Date',
                    'Notes'
                ]);

                // CSV data
                foreach ($orders as $order) {
                    fputcsv($file, [
                        $order->order_id,
                        $order->user->name ?? 'N/A',
                        $order->user->email ?? 'N/A',
                        $order->child->name ?? 'N/A',
                        $order->items->count(),
                        number_format($order->subtotal, 2),
                        number_format($order->discount_amount, 2),
                        number_format($order->total_amount, 2),
                        ucfirst($order->status),
                        ucfirst(str_replace('_', ' ', $order->payment_status)),
                        $order->created_at->format('Y-m-d H:i:s'),
                        $order->completed_at ? $order->completed_at->format('Y-m-d H:i:s') : 'N/A',
                        $order->notes ?? 'N/A'
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to export orders');
        }
    }
}
