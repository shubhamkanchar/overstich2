@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="offset-md-2 col-md-8">
            <form action="{{ route('user.replacePost',$order->order_number) }}" method="POST">
                @csrf
                <div class="card mt-5 mb-5">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-5">
                                <h4 class="fw-bold">Return / Replace order</h4>
                            </div>
                            <div class="col-md-7 text-end">
                                <a href="{{ route('welcome') }}" class="btn btn-dark">Go to Home</a>
                                <a href="{{ route('order.my-order') }}" class="btn btn-dark">Go to Orders</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                @if($order->return)
                                    <div class="form-check form-check-inline fs-5">
                                        <input class="form-check-input" type="radio" name="order_status" id="inlineRadio1" value="return" required>
                                        <label class="form-check-label" for="inlineRadio1">Return</label>
                                    </div>
                                @endif
                                @if($order->replace)
                                    <div class="form-check form-check-inline fs-5">
                                        <input class="form-check-input" type="radio" name="order_status" id="inlineRadio2" value="replace" required>
                                        <label class="form-check-label " for="inlineRadio2">Replace</label>
                                    </div>
                                @endif
                                <h5 class="mt-2 fw-bold">Reason for return/replace order:</h5>
                                @foreach(config('replace') as $key => $value)
                                    <div class="form-check">
                                        <input class="form-check-input replace-reason" type="radio" name="return_reason" id="inlineRadio{{ $key }}" value="{{ $key }}" required>
                                        <label class="form-check-label" for="inlineRadio2">{{ $value }}</label>
                                    </div>
                                @endforeach
                                <div class="form-check">
                                    <input class="form-check-input replace-reason" type="radio" name="return_reason" id="inlineRadioOther" value="other">
                                    <label class="form-check-label" for="inlineRadio2">Other</label>
                                </div>
                                <div class="form group">
                                    <textarea class="form-control" name="other_reason" id="other"></textarea>
                                </div>
                                <h5 class="mt-3 fw-bold">Account Information</h5>
                                <div class="row">
                                    <div class="col-md-6 p-3">
                                        <span>Account Holder Name</span>
                                        <input class="form-control" type="text" name="account_holder_name"
                                            value="{{ old('account') ?? Auth::user()->userAccount?->holder_name }}" placeholder="Account Holder Name" required>
                                            @error('account_holder_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 p-3">
                                        <span>Account No</span>
                                        <input class="form-control" type="text" name="account"
                                            value="{{ old('account') ?? Auth::user()->userAccount?->account_number }}" placeholder="Account Number" required>
                                            @error('account')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 p-3">
                                        <span>Bank Name</span>
                                        <input class="form-control" type="text" name="bank_name"
                                            value="{{ old('bank_name') ?? Auth::user()->userAccount?->bank_name }}" placeholder="Bank Name" required>
                                            @error('bank_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 p-3">
                                        <span>IFSC Code</span>
                                        <input class="form-control" type="text" name="ifsc" value="{{ old('ifsc') ?? Auth::user()->userAccount?->ifsc }}"
                                            placeholder="IFSC Code"required>
                                            @error('ifsc')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-dark">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
<script type="module">
$(document).on('click','.replace-reason',function(){
    if($(this).val() == 'other'){
        $('#other').attr('required',true);
    }else{
        $('#other').attr('required',false);
    }
})
</script>
@endsection