@extends('backend.admin.layouts.app')

@section('content')
  <div class="grey-bg container admin-category">
    <div class="row">
      <div class="col-xl-12 col-sm-12 col-12">
          <div class="card">
              <h5 class="card-header">Edit Coupon</h5>
              <div class="card-body">
                  <form method="post" action="{{ route('coupon.update', $coupon->id) }}">
                      @csrf
                      @method('PATCH')
                      <div class="form-group row">
                        <div class="col-md-6 col-12">
                            <label for="inputTitle" class="col-form-label">Coupon Code <span
                                    class="text-danger">*</span></label>
                            <input id="inputTitle" type="text" name="code" placeholder="Enter Coupon Code"
                                value="{{ $coupon->code }}" class="form-control">
                            @error('code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 col-12">
                            <label for="type" class="col-form-label">Type <span class="text-danger">*</span></label>
                            <select name="type" class="form-control">
                                <option value="fixed" {{ $coupon->type == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                <option value="percent" {{ $coupon->type == 'percent' ? 'selected' : '' }}>Percent
                                </option>
                            </select>
                            @error('type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 col-12">
                            <label for="inputTitle" class="col-form-label">Value <span
                                    class="text-danger">*</span></label>
                            <input id="inputTitle" type="number" name="value" placeholder="Enter Coupon value"
                                value="{{ $coupon->value }}" class="form-control">
                            @error('value')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 col-12">
                            <label for="status" class="col-form-label">Status <span
                                    class="text-danger">*</span></label>
                            <select name="status" class="form-control">
                                <option value="active" {{ $coupon->status == 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="inactive" {{ $coupon->status == 'inactive' ? 'selected' : '' }}>
                                    Inactive</option>
                            </select>
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mt-2">
                            <button class="btn btn-success" type="submit">Update</button>
                        </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>
    </div>
  </div>
@endsection
