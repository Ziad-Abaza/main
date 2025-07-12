@extends('dashboard.layouts.app')

@section('title', 'Edit Payment')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Edit Payment</h4>
                    <div>
                        <a href="{{ route('console.payments.show', $payment) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> View Details
                        </a>
                        <a href="{{ route('console.payments.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('console.payments.update', $payment) }}" method="POST">
                        @csrf
                        <div class="row">
                            <!-- User Selection -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user_id">User <span class="text-danger">*</span></label>
                                    <select class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                        <option value="">Select User</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->user_id }}" {{ (old('user_id', $payment->user_id) == $user->user_id) ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Amount -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="amount">Amount <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror"
                                           id="amount" name="amount" value="{{ old('amount', $payment->amount) }}" required>
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Currency -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="currency">Currency <span class="text-danger">*</span></label>
                                    <select class="form-control @error('currency') is-invalid @enderror" id="currency" name="currency" required>
                                        <option value="EGP" {{ (old('currency', $payment->currency) == 'EGP') ? 'selected' : '' }}>EGP</option>
                                        <option value="USD" {{ (old('currency', $payment->currency) == 'USD') ? 'selected' : '' }}>USD</option>
                                        <option value="EUR" {{ (old('currency', $payment->currency) == 'EUR') ? 'selected' : '' }}>EUR</option>
                                        <option value="GBP" {{ (old('currency', $payment->currency) == 'GBP') ? 'selected' : '' }}>GBP</option>
                                    </select>
                                    @error('currency')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Payment Status -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="payment_status">Payment Status <span class="text-danger">*</span></label>
                                    <select class="form-control @error('payment_status') is-invalid @enderror" id="payment_status" name="payment_status" required>
                                        <option value="pending" {{ (old('payment_status', $payment->payment_status) == 'pending') ? 'selected' : '' }}>Pending</option>
                                        <option value="completed" {{ (old('payment_status', $payment->payment_status) == 'completed') ? 'selected' : '' }}>Completed</option>
                                        <option value="failed" {{ (old('payment_status', $payment->payment_status) == 'failed') ? 'selected' : '' }}>Failed</option>
                                        <option value="refunded" {{ (old('payment_status', $payment->payment_status) == 'refunded') ? 'selected' : '' }}>Refunded</option>
                                    </select>
                                    @error('payment_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Payment Method -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="payment_method">Payment Method <span class="text-danger">*</span></label>
                                    <select class="form-control @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method" required>
                                        <option value="credit_card" {{ (old('payment_method', $payment->payment_method) == 'credit_card') ? 'selected' : '' }}>Credit Card</option>
                                        <option value="paypal" {{ (old('payment_method', $payment->payment_method) == 'paypal') ? 'selected' : '' }}>PayPal</option>
                                        <option value="bank_transfer" {{ (old('payment_method', $payment->payment_method) == 'bank_transfer') ? 'selected' : '' }}>Bank Transfer</option>
                                        <option value="cash" {{ (old('payment_method', $payment->payment_method) == 'cash') ? 'selected' : '' }}>Cash</option>
                                        <option value="other" {{ (old('payment_method', $payment->payment_method) == 'other') ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('payment_method')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Transaction ID -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="transaction_id">Transaction ID</label>
                                    <input type="text" class="form-control @error('transaction_id') is-invalid @enderror"
                                           id="transaction_id" name="transaction_id" value="{{ old('transaction_id', $payment->transaction_id) }}">
                                    @error('transaction_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Paid At -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="paid_at">Paid At</label>
                                    <input type="datetime-local" class="form-control @error('paid_at') is-invalid @enderror"
                                           id="paid_at" name="paid_at"
                                           value="{{ old('paid_at', $payment->paid_at ? $payment->paid_at->format('Y-m-d\TH:i') : '') }}">
                                    @error('paid_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Order ID -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="order_id">Order ID</label>
                                    <select class="form-control @error('order_id') is-invalid @enderror" id="order_id" name="order_id">
                                        <option value="">No Order</option>
                                        @foreach($orders as $order)
                                            <option value="{{ $order->order_id }}" {{ (old('order_id', $payment->order_id) == $order->order_id) ? 'selected' : '' }}>
                                                {{ $order->order_id }} - {{ $order->user->name ?? 'N/A' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('order_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Purchase ID -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="purchase_id">Purchase ID</label>
                                    <select class="form-control @error('purchase_id') is-invalid @enderror" id="purchase_id" name="purchase_id">
                                        <option value="">No Purchase</option>
                                        @foreach($purchases as $purchase)
                                            <option value="{{ $purchase->purchase_id }}" {{ (old('purchase_id', $payment->purchase_id) == $purchase->purchase_id) ? 'selected' : '' }}>
                                                {{ $purchase->purchase_id }} - {{ $purchase->user->name ?? 'N/A' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('purchase_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Subscription ID -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="subscription_id">Subscription ID</label>
                                    <select class="form-control @error('subscription_id') is-invalid @enderror" id="subscription_id" name="subscription_id">
                                        <option value="">No Subscription</option>
                                        @foreach($subscriptions as $subscription)
                                            <option value="{{ $subscription->subscription_id }}" {{ (old('subscription_id', $payment->subscription_id) == $subscription->subscription_id) ? 'selected' : '' }}>
                                                {{ $subscription->subscription_id }} - {{ $subscription->child->user->name ?? 'N/A' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('subscription_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Payment
                                </button>
                                <a href="{{ route('console.payments.show', $payment) }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
