@extends('backend.seller.layouts.app')

@section('content')
    <div class="grey-bg container admin-category">
        <div class="row">
            <div class="col-xl-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Add Coupon</h5>
                    <div class="card-body">
                        <form method="post" action="{{ route('seller.coupon.store') }}">
                            {{ csrf_field() }}
                            <div class="form-group row">
                                <div class="col-md-4 col-12 mt-2">
                                    <label for="inputTitle" class="col-form-label">Coupon Code <span
                                            class="text-danger">*</span></label>
                                    <input id="inputTitle" type="text" name="code" placeholder="Enter Coupon Code"
                                        value="{{ old('code') }}" class="form-control">
                                    @error('code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4 col-12 mt-2">
                                    <label for="type" class="col-form-label">Type <span
                                            class="text-danger">*</span></label>
                                    <select name="type" class="form-select">
                                        <option value="fixed">Fixed</option>
                                        <option value="percent">Percent</option>
                                    </select>
                                    @error('type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4 col-12 mt-2">
                                    <label for="inputTitle" class="col-form-label">Value <span class="text-danger">*</span></label>
                                    <input id="inputTitle" type="number" name="value" placeholder="Enter Coupon value"
                                        value="{{ old('value') }}" class="form-control">
                                    @error('value')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4 col-12 mt-2">
                                    <label for="minimum" class="col-form-label">Minimum Value Offer Applicable</label>
                                    <input id="minimum" type="number" name="minimum" min="0" value="{{ old('minimum') }}" class="form-control">
                                    @error('minimum')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4 col-12 mt-2">
                                    <label for="status" class="col-form-label">Status <span
                                            class="text-danger">*</span></label>
                                    <select name="status" class="form-control">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mt-2">
                                    <button type="reset" class="btn btn-warning">Reset</button>
                                    <button class="btn btn-success" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/summernote/summernote.min.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('admin/summernote/summernote.min.js') }}"></script>
    <script>
        $('#lfm').filemanager('image');

        $(document).ready(function() {
            $('#description').summernote({
                placeholder: "Write short description.....",
                tabsize: 2,
                height: 150
            });
        });
    </script>
@endpush
