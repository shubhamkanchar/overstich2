@extends('backend.seller.layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                Manage Orders
                @if (empty(auth()->user()->activeWarehouse))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        Create warehouse and set it default to proceed with orders
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
            <div class="card-body table-responsive">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
