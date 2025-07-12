@extends('dashboard.layouts.app')

@section('title', 'Payment Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Payment Details</h4>
                    <div>
                        <a href="{{ route('console.payments.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <a href="{{ route('console.payments.edit', $payment) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Payment Information -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Payment Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>Payment ID:</strong></td>
                                            <td>{{ $payment->payment_id }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Transaction ID:</strong></td>
                                            <td>{{ $payment->transaction_id ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Amount:</strong></td>
                                            <td><strong class="text-success">{{ number_format($payment->amount, 2) }} {{ $payment->currency }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>
                                                <span class="badge badge-{{ $payment->payment_status == 'completed' ? 'success' : ($payment->payment_status == 'pending' ? 'warning' : ($payment->payment_status == 'failed' ? 'danger' : 'info')) }}">
                                                    {{ ucfirst($payment->payment_status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Payment Method:</strong></td>
                                            <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Paid At:</strong></td>
                                            <td>{{ $payment->paid_at ? $payment->paid_at->format('M d, Y H:i:s') : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Created:</strong></td>
                                            <td>{{ $payment->created_at->format('M d, Y H:i:s') }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Last Updated:</strong></td>
                                            <td>{{ $payment->updated_at->format('M d, Y H:i:s') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- User Information -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">User Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <td><strong>User Name:</strong></td>
                                            <td>{{ $payment->user->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email:</strong></td>
                                            <td>{{ $payment->user->email ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Phone:</strong></td>
                                            <td>{{ $payment->user->phone ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>User ID:</strong></td>
                                            <td>{{ $payment->user_id }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Related Entity Information -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Related Entity</h5>
                                </div>
                                <div class="card-body">
                                    @if($payment->order_id)
                                        <div class="alert alert-info">
                                            <h6>Order Payment</h6>
                                            <p><strong>Order ID:</strong> {{ $payment->order_id }}</p>
                                            @if($payment->order)
                                                <p><strong>Order Status:</strong> {{ ucfirst($payment->order->status ?? 'N/A') }}</p>
                                                <p><strong>Order Total:</strong> {{ number_format($payment->order->total ?? 0, 2) }} {{ $payment->order->currency ?? 'EGP' }}</p>
                                            @endif
                                        </div>
                                    @elseif($payment->purchase_id)
                                        <div class="alert alert-warning">
                                            <h6>Course Purchase Payment</h6>
                                            <p><strong>Purchase ID:</strong> {{ $payment->purchase_id }}</p>
                                            @if($payment->purchase)
                                                <p><strong>Course:</strong> {{ $payment->purchase->course->name ?? 'N/A' }}</p>
                                                <p><strong>Purchase Status:</strong> {{ ucfirst($payment->purchase->status ?? 'N/A') }}</p>
                                            @endif
                                        </div>
                                    @elseif($payment->subscription_id)
                                        <div class="alert alert-success">
                                            <h6>Subscription Payment</h6>
                                            <p><strong>Subscription ID:</strong> {{ $payment->subscription_id }}</p>
                                            @if($payment->subscription)
                                                <p><strong>Child:</strong> {{ $payment->subscription->child->user->name ?? 'N/A' }}</p>
                                                <p><strong>Level:</strong> {{ $payment->subscription->level->name ?? 'N/A' }}</p>
                                                <p><strong>Subscription Status:</strong> {{ ucfirst($payment->subscription->status ?? 'N/A') }}</p>
                                            @endif
                                        </div>
                                    @else
                                        <div class="alert alert-secondary">
                                            <h6>Other Payment</h6>
                                            <p>This payment is not associated with any specific order, purchase, or subscription.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Gateway Response -->
                    @if($payment->payment_gateway_response)
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Payment Gateway Response</h5>
                                    </div>
                                    <div class="card-body">
                                        <pre class="bg-light p-3 rounded">{{ json_encode($payment->payment_gateway_response, JSON_PRETTY_PRINT) }}</pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Status Update Form -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Update Payment Status</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('console.payments.update-status', $payment) }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="payment_status">New Status</label>
                                                    <select class="form-control" id="payment_status" name="payment_status" required>
                                                        <option value="pending" {{ $payment->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="completed" {{ $payment->payment_status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                        <option value="failed" {{ $payment->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                                                        <option value="refunded" {{ $payment->payment_status == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <div>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-save"></i> Update Status
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
