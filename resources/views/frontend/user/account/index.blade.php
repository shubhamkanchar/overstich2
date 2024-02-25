@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center mt-5 mb-5">
        <div class="col-12 col-md-12 mb-3">
            <div class="card">
                <div class="card-header">
                    @php
                        $activeTab = session('tab') ?? 'basic';
                    @endphp
                    <div class="d-flex justify-content-between">
                        <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $activeTab == 'basic' ? 'active' : ''}}" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab" aria-controls="basic" aria-selected="true">Basic Profile Details</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $activeTab == 'password' ? 'active' : ''}}" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab" aria-controls="password" aria-selected="false">Password</button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade {{ $activeTab == 'basic' ? 'show active' : ''}}" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                            <form action="{{ route('account.update')}}" id="profileForm" method="post">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" required class="form-control" id="name" name="name" value="{{ old('phone', $user->name) }}" placeholder="Enter your name">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">phone</label>
                                            <input type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $user->phone) }}" maxlength="10" data-msg="please enter valid number">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div> 
                                    <div class="col-md-12 col-12">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" disabled id="email" value="{{ $user->email }}" placeholder="Enter your email">
                                        </div>
                                    </div>
                                    @csrf
                                    <div class="col-3">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade {{ $activeTab == 'password' ? 'show active' : ''}}" id="password" role="tabpanel" aria-labelledby="password-tab">
                            <form action="{{ route('account.update.password')}}" id="passwordForm" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label for="current-password" class="form-label">Current Password</label>
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" id="current-password" placeholder="Enter your current password">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="new-password" class="form-label">New Password</label>
                                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" id="new-password" placeholder="Enter your new password">
                                    @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="confirm-password" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password" id="confirm-password" placeholder="Confirm your new password">
                                    @error('confirm_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script type="module">
        $('#profileForm').validate({
            rules: {
                name: {
                    required: true
                },
                phone: {
                    phone_number: true
                }
            }
        });

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
    </script>
@endsection
