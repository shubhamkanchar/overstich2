@extends('backend.admin.layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Coupons</div>
            <div class="card-body table-responsive">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script type="module">
        $(document).ready(function() {
          $(document).on('click', '.dltBtn', function(e) {
              const deleteUrl = $(this).data('url');
              e.preventDefault();
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
                        LaravelDataTables["coupon-table"].draw();
                        Swal.fire({
                            text: response.message,
                            icon: "success"
                        });
                    },
                    error: (error) => {
                        Swal.fire({
                            text: error.message,
                            icon: "success"
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
        });
    </script>
@endpush
