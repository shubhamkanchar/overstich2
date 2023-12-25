@extends('layouts.app')
@push('styles')
    <style>
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            margin: 0; 
        }
        .bg-gray {
            background-color: rgb(220, 219, 219); 
        }
    </style>
@endpush
@section('content')
    <div class="container">
        <div class="row mt-5 mb-5 justify-content-end row-gap-5 gap-2 cart-contents">
            {!! $cartContentView !!}
        </div>
    </div>
@endsection

@section('script')
    <script type="module">
        $(function() {

            let debounceTimer;

            $(document).on('submit', '.cart-update-form', function(event) {
                event.preventDefault();
                let data = $(this).serialize();
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(function() {
                    updateQuantity(data);
                }, 500); 
            });

            $(document).on('submit','.cart-remove-form', function(event) {
                event.preventDefault();
                let data = $(this).serialize();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This item will removed from the cart',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel',
                }).then((result) => {
                    
                    if (result.isConfirmed) { 
                        $('#popup-overlay').removeClass('d-none')
                        $('.spinner').removeClass('d-none')
                        updateQuantity(data);
                        $('#popup-overlay').addClass('d-none')
                        $('.spinner').addClass('d-none')
                    }
                    
                });
                
            })
        })

        function updateQuantity(data) {
            $.ajax({
                method:"post",
                url: "{{ route('cart.update')}}",
                data: data,
                beforeSend: () => {
                    $('#popup-overlay').removeClass('d-none')
                    $('.spinner').removeClass('d-none')
                },
                success: (res) =>{
                    $('.cart-contents').html(res.cartContentView)
                },
                error: (err) => {
                },
                beforeSend: () => {
                    $('#popup-overlay').addClass('d-none')
                    $('.spinner').addClass('d-none')
                }
            });
        }

    </script>
@endsection