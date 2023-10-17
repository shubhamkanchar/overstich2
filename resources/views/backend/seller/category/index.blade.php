@extends('backend.seller.layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Manage Category</div>
            <div class="card-body table-responsive">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@endsection
 
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush