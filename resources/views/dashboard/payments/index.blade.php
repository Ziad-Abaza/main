@extends('dashboard.layouts.app')

@section('title', 'Payments')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Payments</h4>
                    <div>
                        <a href="{{ route('console.payments.export') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-download"></i> Export
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filters -->
                    <form method="GET" action="{{ route('console.payments.index') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="search">Search</label>
                                    <input type="text" class="form-control" id="search" name="search"
                                           value="{{ request('search') }}" placeholder="Transaction ID, user, order ID">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="payment_status">Status</label>
                                    <select class="form-control" id="payment_status" name="payment_status">
                                        <option value="">All Statuses</option>
                                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="completed" {{ request('payment_status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                                        <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="payment_method">Method</label>
                                    <select class="form-control" id="payment_method" name="payment_method">
                                        <option value="">All Methods</option>
                                        <option value="credit_card" {{ request('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                        <option value="paypal" {{ request('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                                        <option value="bank_transfer" {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                        <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="amount_min">Min Amount</label>
                                    <input type="number" step="0.01" class="form-control" id="amount_min" name="amount_min"
                                           value="{{ request('amount_min') }}" placeholder="0.00">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="amount_max">Max Amount</label>
                                    <input type="number" step="0.01" class="form-control" id="amount_max" name="amount_max"
                                           value="{{ request('amount_max') }}" placeholder="0.00">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date_from">Date From</label>
                                    <input type="date" class="form-control" id="date_from" name="date_from"
                                           value="{{ request('date_from') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date_to">Date To</label>
                                    <input type="date" class="form-control" id="date_to" name="date_to"
                                           value="{{ request('date_to') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-search"></i> Filter
                                        </button>
                                        <a href="{{ route('console.payments.index') }}" class="btn btn-secondary btn-sm">
                                            <i class="fas fa-times"></i> Clear
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Payments Table -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Payment ID</th>
                                    <th>Transaction ID</th>
                                    <th>User</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Method</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->payment_id }}</td>
                                        <td>{{ $payment->transaction_id ?? 'N/A' }}</td>
                                        <td>
                                            <div>
                                                <strong>{{ $payment->user->name ?? 'N/A' }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $payment->user->email ?? 'N/A' }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <strong>{{ number_format($payment->amount, 2) }} {{ $payment->currency }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $payment->payment_status == 'completed' ? 'success' : ($payment->payment_status == 'pending' ? 'warning' : ($payment->payment_status == 'failed' ? 'danger' : 'info')) }}">
                                                {{ ucfirst($payment->payment_status) }}
                                            </span>
                                        </td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                                        <td>
                                            @if($payment->order_id)
                                                <span class="badge badge-primary">Order</span>
                                            @elseif($payment->purchase_id)
                                                <span class="badge badge-info">Course Purchase</span>
                                            @elseif($payment->subscription_id)
                                                <span class="badge badge-warning">Subscription</span>
                                            @else
                                                <span class="badge badge-secondary">Other</span>
                                            @endif
                                        </td>
                                        <td>{{ $payment->created_at->format('M d, Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('console.payments.show', $payment) }}"
                                                   class="btn btn-info btn-sm" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('console.payments.edit', $payment) }}"
                                                   class="btn btn-warning btn-sm" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('console.payments.delete', $payment) }}"
                                                      method="POST" class="d-inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this payment?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No payments found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $payments->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
