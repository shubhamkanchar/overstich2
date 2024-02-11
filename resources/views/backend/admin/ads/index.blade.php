@extends('backend.admin.layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Manage Ads
                <a class="btn btn-dark float-end" href="{{ route('ads.create') }}">Add Ads</a>
            </div>
            <div class="card-body table-responsive">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@endsection
@push('scripts')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
<script type="module">
    $('#sellercategorytable').on('click', '.ads delete',function () {
        const deleteUrl = $(this).data('url');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'DELETE',
                    url: deleteUrl,
                    beforeSend: ()=>{
                        // $('#popup-overlay').removeClass('d-none')
                        // $('.spinner').removeClass('d-none')
                    },
                    success: (response) => {
                        LaravelDataTables["ads-table"].draw();
                        Swal.fire({
                            text: response.message,
                            icon: "success"
                        });
                    },
                    error: (error) => {
                        Swal.fire({
                            text: error.message,
                            icon: "error"
                        });
                    },
                    complete: () => {
                        // $('#popup-overlay').addClass('d-none')
                        // $('.spinner').addClass('d-none')
                    }
                });
            }
        });
    });
</script>
@endpush