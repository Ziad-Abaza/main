<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Order;
use App\Models\CoursePurchase;
use App\Models\ChildLevelSubscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class PaymentController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'can:manage_payments']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = Payment::with(['user', 'order', 'purchase', 'subscription']);

            // Filter by payment status
            if ($request->filled('payment_status')) {
                $query->where('payment_status', $request->payment_status);
            }

            // Filter by payment method
            if ($request->filled('payment_method')) {
                $query->where('payment_method', $request->payment_method);
            }

            // Filter by amount range
            if ($request->filled('amount_min')) {
                $query->where('amount', '>=', $request->amount_min);
            }

            if ($request->filled('amount_max')) {
                $query->where('amount', '<=', $request->amount_max);
            }

            // Filter by date range
            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            // Search by transaction ID, user name, or order ID
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('transaction_id', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($userQuery) use ($search) {
                          $userQuery->where('name', 'like', "%{$search}%")
                                   ->orWhere('email', 'like', "%{$search}%");
                      })
                      ->orWhere('order_id', 'like', "%{$search}%")
                      ->orWhere('purchase_id', 'like', "%{$search}%")
                      ->orWhere('subscription_id', 'like', "%{$search}%");
                });
            }

            $payments = $query->orderBy('created_at', 'desc')->paginate(20);

            return view('dashboard.payments.index', compact('payments'));
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to fetch payments');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        try {
            $payment->load(['user', 'order', 'purchase', 'subscription']);
            return view('dashboard.payments.show', compact('payment'));
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to display payment details');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        try {
            $users = User::all();
            $orders = Order::all();
            $purchases = CoursePurchase::all();
            $subscriptions = ChildLevelSubscription::all();

            return view('dashboard.payments.edit', compact('payment', 'users', 'orders', 'purchases', 'subscriptions'));
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to load edit form');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        try {
            $validated = $request->validate([
                'order_id' => 'nullable|exists:orders,order_id',
                'purchase_id' => 'nullable|exists:course_purchases,purchase_id',
                'subscription_id' => 'nullable|exists:child_level_subscriptions,subscription_id',
                'user_id' => 'required|exists:users,user_id',
                'amount' => 'required|numeric|min:0',
                'currency' => 'required|string|max:3',
                'payment_status' => 'required|in:pending,completed,failed,refunded',
                'payment_method' => 'required|string',
                'transaction_id' => 'nullable|string',
                'paid_at' => 'nullable|date',
            ]);

            $payment->update($validated);

            return redirect()->route('console.payments.show', $payment)->with('success', 'Payment updated successfully');
        } catch (ValidationException $e) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $e->getMessage());
            return back()->withErrors($e->errors())->withInput();
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return back()->withInput()->with('error', 'Failed to update payment');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        try {
            $payment->delete();
            return redirect()->route('console.payments.index')->with('success', 'Payment deleted successfully');
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to delete payment');
        }
    }

    /**
     * Update payment status.
     */
    public function updateStatus(Request $request, Payment $payment)
    {
        try {
            $request->validate([
                'payment_status' => 'required|in:pending,completed,failed,refunded'
            ]);

            $payment->update([
                'payment_status' => $request->payment_status,
                'paid_at' => $request->payment_status === 'completed' ? now() : null
            ]);

            return redirect()->back()->with('success', "Payment status updated to {$request->payment_status}");
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to update payment status');
        }
    }

    /**
     * Handle payment gateway callback.
     */
    public function handleCallback(Request $request)
    {
        try {
            Log::channel('payment')->info('Payment callback received', $request->all());

            // Validate callback data
            $request->validate([
                'transaction_id' => 'required|string',
                'payment_status' => 'required|in:pending,completed,failed,refunded',
                'amount' => 'required|numeric',
                'currency' => 'required|string',
            ]);

            // Find payment by transaction ID
            $payment = Payment::where('transaction_id', $request->transaction_id)->first();

            if (!$payment) {
                Log::channel('payment')->error('Payment not found for transaction ID: ' . $request->transaction_id);
                return response()->json(['error' => 'Payment not found'], 404);
            }

            // Update payment with gateway response
            $payment->update([
                'payment_status' => $request->payment_status,
                'payment_gateway_response' => $request->all(),
                'paid_at' => $request->payment_status === 'completed' ? now() : null
            ]);

            // Update related entities based on payment type
            if ($payment->order_id) {
                $order = Order::find($payment->order_id);
                if ($order) {
                    $order->update(['payment_status' => $request->payment_status]);
                }
            }

            if ($payment->purchase_id) {
                $purchase = CoursePurchase::find($payment->purchase_id);
                if ($purchase) {
                    $purchase->update(['payment_status' => $request->payment_status]);
                }
            }

            if ($payment->subscription_id) {
                $subscription = ChildLevelSubscription::find($payment->subscription_id);
                if ($subscription) {
                    $subscription->update(['status' => $request->payment_status === 'completed' ? 'active' : 'inactive']);
                }
            }

            Log::channel('payment')->info('Payment callback processed successfully', [
                'payment_id' => $payment->payment_id,
                'transaction_id' => $request->transaction_id,
                'status' => $request->payment_status
            ]);

            return response()->json(['success' => true, 'message' => 'Payment processed successfully']);

        } catch (ValidationException $e) {
            Log::channel('payment')->error('Payment callback validation failed', $e->errors());
            return response()->json(['error' => 'Invalid callback data'], 400);
        } catch (Throwable $th) {
            Log::channel('payment')->error('Payment callback processing failed: ' . $th->getMessage());
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    /**
     * Export payments.
     */
    public function export(Request $request)
    {
        try {
            $query = Payment::with(['user', 'order', 'purchase', 'subscription']);

            // Apply filters
            if ($request->filled('payment_status')) {
                $query->where('payment_status', $request->payment_status);
            }

            if ($request->filled('payment_method')) {
                $query->where('payment_method', $request->payment_method);
            }

            if ($request->filled('amount_min')) {
                $query->where('amount', '>=', $request->amount_min);
            }

            if ($request->filled('amount_max')) {
                $query->where('amount', '<=', $request->amount_max);
            }

            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('transaction_id', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($userQuery) use ($search) {
                          $userQuery->where('name', 'like', "%{$search}%")
                                   ->orWhere('email', 'like', "%{$search}%");
                      })
                      ->orWhere('order_id', 'like', "%{$search}%")
                      ->orWhere('purchase_id', 'like', "%{$search}%")
                      ->orWhere('subscription_id', 'like', "%{$search}%");
                });
            }

            $payments = $query->orderBy('created_at', 'desc')->get();

            // Generate CSV
            $filename = 'payments_' . date('Y-m-d_H-i-s') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Cache-Control' => 'no-cache, must-revalidate',
                'Pragma' => 'no-cache',
            ];

            $callback = function () use ($payments) {
                $file = fopen('php://output', 'w');

                // Add BOM for UTF-8
                fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

                // CSV headers
                fputcsv($file, [
                    'Payment ID',
                    'Transaction ID',
                    'User Name',
                    'User Email',
                    'Amount',
                    'Currency',
                    'Payment Status',
                    'Payment Method',
                    'Order ID',
                    'Purchase ID',
                    'Subscription ID',
                    'Paid At',
                    'Created Date'
                ]);

                // CSV data
                foreach ($payments as $payment) {
                    fputcsv($file, [
                        $payment->payment_id,
                        $payment->transaction_id ?? 'N/A',
                        $payment->user->name ?? 'N/A',
                        $payment->user->email ?? 'N/A',
                        $payment->amount,
                        $payment->currency,
                        ucfirst($payment->payment_status),
                        ucfirst($payment->payment_method),
                        $payment->order_id ?? 'N/A',
                        $payment->purchase_id ?? 'N/A',
                        $payment->subscription_id ?? 'N/A',
                        $payment->paid_at ? $payment->paid_at->format('Y-m-d H:i:s') : 'N/A',
                        $payment->created_at->format('Y-m-d H:i:s')
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (Throwable $th) {
            Log::channel('debug')->error('from : ' . __CLASS__ . '::' . __FUNCTION__ . ' - ' . $th->getMessage());
            return redirect()->back()->with('error', 'Failed to export payments');
        }
    }
}
