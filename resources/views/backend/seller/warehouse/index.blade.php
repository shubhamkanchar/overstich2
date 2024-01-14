@extends('backend.seller.layouts.app')

@section('content')
    <div class="container seller-product">
        <div class="card">
            <div class="card-header">Manage Product</div>
            <div class="card-body table-responsive">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@endsection
 
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush