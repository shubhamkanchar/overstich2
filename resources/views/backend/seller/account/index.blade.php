@extends('backend.seller.layouts.app')
@section('content')
    <div class="container mt-4">
        @if(!$user->sellerInfo->is_completed)
            <div class="alert alert-warning" role="alert">
                Please complete profile and upload product details
            </div>
        @endif
        @php
            $activeTab = session('tab') ?? 'basic';
        @endphp
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $activeTab == 'basic' ? 'active' : ''}}" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab" aria-controls="basic" aria-selected="true">Basic Profile Details</button>
                        </li>
                        
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $activeTab == 'gst-account' ? 'active' : ''}}" id="seller-info-tab" data-bs-toggle="tab" data-bs-target="#seller-info" type="button" role="tab" aria-controls="seller-info" aria-selected="false">Gst & Account </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $activeTab == 'document' ? 'active' : ''}}" id="seller-documents-tab" data-bs-toggle="tab" data-bs-target="#seller-documents" type="button" role="tab" aria-controls="seller-documents" aria-selected="false">Documents</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $activeTab == 'product-info' ? 'active' : ''}}" id="seller-product-tab" data-bs-toggle="tab" data-bs-target="#seller-product" type="button" role="tab" aria-controls="seller-product" aria-selected="false">Product Details</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link {{ $activeTab == 'password' ? 'active' : ''}}" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab" aria-controls="password" aria-selected="false">Password</button>
                        </li>
                    </ul>
                    @if ($user->is_active == 1)    
                        <div>
                            <button class="btn btn-warning" id="deactivate">Deactivate Account</button>
                        </div>
                    @else
                        <div>
                            <button class="btn btn-success" id="activate">Activate Account</button>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade {{ $activeTab == 'basic' ? 'show active' : ''}}" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                        @include('backend.seller.account.brand')
                    </div>
                    <div class="tab-pane fade {{ $activeTab == 'password' ? 'show active' : ''}}" id="password" role="tabpanel" aria-labelledby="password-tab">
                        @include('backend.seller.account.password')
                    </div>
                    <div class="tab-pane fade {{ $activeTab == 'gst-account' ? 'show active' : ''}}" id="seller-info" role="tabpanel" aria-labelledby="seller-info-tab">
                        @include('backend.seller.account.gst_account')
                    </div>
                    <div class="tab-pane fade {{ $activeTab == 'document' ? 'show active' : ''}}" id="seller-documents" role="tabpanel" aria-labelledby="seller-documents-tab">
                        @include('backend.seller.account.documents')
                    </div>
                    <div class="tab-pane fade {{ $activeTab == 'product-info' ? 'show active' : ''}}" id="seller-product" role="tabpanel" aria-labelledby="seller-product-tab">
                        @include('backend.seller.account.product-details')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="module">
        $(function() {
            $('#deactivate').on('click', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You want to deactivate your account',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No, cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('seller.account.deactivate')}}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            beforeSend: () => {
                                $('#popup-overlay').removeClass('d-none')
                                $('.spinner').removeClass('d-none')
                            },
                            success: (response) => {
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Your Account Deactivated',
                                    icon: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Okay',
                                }).then((result) => {
                                    window.location.reload();
                                });
                            },
                            error: (error) => {
                                Swal.fire({
                                    title: 'Error',
                                    text: error.responseJSON.msg,
                                    icon: 'error',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Okay',
                                }).then((result) => {
                                    window.location.reload();
                                });
                            },
                            complete: () => {
                                $('#popup-overlay').addClass('d-none')
                                $('.spinner').addClass('d-none')
                            }
                        });
                    }
                });
            })

            $('#activate').on('click', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You want to activate your account',
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No, cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: "{{ route('seller.account.activate')}}",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            beforeSend: () => {
                                $('#popup-overlay').removeClass('d-none')
                                $('.spinner').removeClass('d-none')
                            },
                            success: (response) => {
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Your Account Activated',
                                    icon: 'success',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Okay',
                                }).then((result) => {
                                    window.location.reload();
                                });
                            },
                            error: (error) => {
                                Swal.fire({
                                    title: 'Error',
                                    text: error.responseJSON.msg,
                                    icon: 'error',
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'Okay',
                                }).then((result) => {
                                    window.location.reload();
                                });
                            },
                            complete: () => {
                                $('#popup-overlay').addClass('d-none')
                                $('.spinner').addClass('d-none')
                            }
                        });
                    }
                });
            })

            $('#passwordForm').validate({
                rules: {
                    current_password: {
                        required: true,
                        remote: {
                            url: "{{ route('account.verify-old-password')}}", // URL to the backend validation function
                            method: 'post',
                            data: {
                                _token : "{{ csrf_token() }}",
                                old_password: function() {
                                    return $('#current-password').val();
                                }
                            }
                        }
                    },
                    new_password: {
                        required: true,
                        minlength: 8
                    },
                    confirm_password: {
                        required: true,
                        equalTo: "#new-password"
                    }
                },
                messages: {
                    current_password: {
                        remote: "Old password is not matching"
                    },
                    confirm_password: {
                        equalTo: "Please enter the same password as above"
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });

            $('#replaceCancelCheque').on('change', function () {
                let button = $($(this).data('target')).trigger('click');
            });

            $('#replaceGstDoc').on('change', function () {
                let button = $($(this).data('target')).trigger('click');
            });
        
            $('#GSTAccountForm').validate({
                rules: {
                    gst: {
                        required: true,
                        maxlength: 255 
                    },
                    gst_address: {
                        required: true,
                        maxlength: 255
                    },
                    gst_name: {
                        required: true,
                        maxlength: 255
                    },
                    ifsc: {
                        required: true,
                        maxlength: 255
                    },
                    account: {
                        required: true,
                        maxlength: 255
                    },
                    bank_name: {
                        required: true,
                        maxlength: 255
                    },
                    account_holder_name: {
                        required: true,
                        maxlength: 255
                    },
                    account_type: {
                        required: true
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
       })
    </script>
@endpush