<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class OrderItemController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:manage_orders']);
    }

    /**
     * Display a listing of the order items.
     */
    public function index(Request $request)
    {
        try {
            $query = OrderItem::with(['order.user', 'order.child', 'product']);

            // Filter by order_id
            if ($request->filled('order_id')) {
                $query->where('order_id', $request->order_id);
            }

            // Search by product name or item_type
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('item_type', 'like', "%{$search}%")
                      ->orWhereHas('product', function ($productQuery) use ($search) {
                          $productQuery->where('name', 'like', "%{$search}%");
                      });
                });
            }

            $orderItems = $query->orderBy('created_at', 'desc')->paginate(20);

            return view('dashboard.order_items.index', compact('orderItems'));
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to fetch order items');
        }
    }

    /**
     * Display the specified order item.
     */
    public function show(OrderItem $orderItem)
    {
        try {
            $orderItem->load(['order.user', 'order.child', 'product']);
            return view('dashboard.order_items.show', compact('orderItem'));
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to display order item');
        }
    }

    /**
     * Show the form for editing the specified order item.
     */
    public function edit(OrderItem $orderItem)
    {
        try {
            $orderItem->load(['order.user', 'order.child', 'product']);
            return view('dashboard.order_items.edit', compact('orderItem'));
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to load order item for editing');
        }
    }

    /**
     * Update the specified order item in storage.
     */
    public function update(Request $request, OrderItem $orderItem)
    {
        try {
            $validated = $request->validate([
                'quantity' => 'required|integer|min:1',
                'unit_price' => 'required|numeric|min:0',
                'total_price' => 'required|numeric|min:0',
                'item_type' => 'required|string|max:100',
            ]);

            $orderItem->update($validated);

            return redirect()->route('console.order_items.show', $orderItem)->with('success', 'Order item updated successfully');
        } catch (ValidationException $e) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $e->getMessage());
            return back()->with('error', 'Failed to update order item');
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->withInput()->with('error', 'Failed to update order item');
        }
    }

    /**
     * Remove the specified order item from storage.
     */
    public function destroy(OrderItem $orderItem)
    {
        try {
            $orderItem->delete();
            return redirect()->route('console.order_items.index')->with('success', 'Order item deleted successfully');
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to delete order item');
        }
    }

    /**
     * Export order items.
     */
    public function export(Request $request)
    {
        try {
            $query = OrderItem::with(['order.user', 'order.child', 'product']);

            // Apply filters
            if ($request->filled('order_id')) {
                $query->where('order_id', $request->order_id);
            }

            if ($request->filled('item_type')) {
                $query->where('item_type', 'like', '%' . $request->item_type . '%');
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('item_type', 'like', "%{$search}%")
                      ->orWhereHas('product', function ($productQuery) use ($search) {
                          $productQuery->where('name', 'like', "%{$search}%");
                      });
                });
            }

            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            $orderItems = $query->orderBy('created_at', 'desc')->get();

            // Generate CSV
            $filename = 'order_items_' . date('Y-m-d_H-i-s') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Cache-Control' => 'no-cache, must-revalidate',
                'Pragma' => 'no-cache',
            ];

            $callback = function () use ($orderItems) {
                $file = fopen('php://output', 'w');

                // Add BOM for UTF-8
                fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

                // CSV headers
                fputcsv($file, [
                    'Order Item ID',
                    'Order ID',
                    'Product Name',
                    'Product ID',
                    'Item Type',
                    'Item ID',
                    'Quantity',
                    'Unit Price',
                    'Total Price',
                    'Customer Name',
                    'Child Name',
                    'Created Date'
                ]);

                // CSV data
                foreach ($orderItems as $item) {
                    fputcsv($file, [
                        $item->order_item_id,
                        $item->order_id,
                        $item->product->name ?? 'N/A',
                        $item->product_id,
                        $item->item_type,
                        $item->item_id,
                        $item->quantity,
                        number_format($item->unit_price, 2),
                        number_format($item->total_price, 2),
                        $item->order->user->name ?? 'N/A',
                        $item->order->child->name ?? 'N/A',
                        $item->created_at->format('Y-m-d H:i:s')
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to export order items');
        }
    }
}
