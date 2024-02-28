<!-- GST and Account Detail.blade.php -->
<form action="{{ route('seller.account.update.gst-account')}}" method="POST" id="GSTAccountForm" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="gst" class="form-label">GST Number</label>
                <input type="text" required class="form-control @error('gst') is-invalid @enderror" id="gst" name="gst" placeholder="Enter GST number" value="{{ old('gst', $user->sellerInfo->gst ?? '') }}">
                @error('gst')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label for="gst_address" class="form-label">GST Registered Address</label>
                <input type="text" required class="form-control @error('gst_address') is-invalid @enderror" id="gst_address" name="gst_address" placeholder="Enter GST Registered Address" value="{{ old('gst_address', $user->sellerInfo->gst_address ?? '') }}">
                @error('gst_address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label for="gst_name" class="form-label">GST Registered Name</label>
                <input type="text" required class="form-control @error('gst_name') is-invalid @enderror" id="gst_name" name="gst_name" placeholder="Enter GST Registered Name" value="{{ old('gst_name', $user->sellerInfo->gst_name ?? '') }}">
                @error('gst_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="gst_doc">GST Document</label>
                @if($user->sellerInfo->gst_doc)
                    <div class="list-group">
                        <div class="list-group-item">
                            <a class="btn btn-primary" href="{{ asset('/doc/seller/' .$user->id.'/'. $user->sellerInfo->gst_doc) }}" target="_blank">View GST Document</a>
                            <a class="btn btn-dark" href="{{ asset('/doc/seller/' .$user->id.'/'. $user->sellerInfo->gst_doc) }}" download>Download</a>
                            <label for="replaceGstDoc" class="btn btn-danger text-white">Replace</label>
                        </div>
                    </div>
                @else
                    <input type="file" required class="form-control" id="gst_doc" name="gst_doc">
                @endif
                <input type="hidden" class="form-control" id="brand" name="brand" placeholder="Enter brand" value="{{  optional($user->sellerInfo)->brand }}">
            </div>
        </div>
        <h4 class="mt-3 mb-3">Account</h4>
        <div class="col-md-6">
            <div class="mb-3">
                <label for="account" class="form-label">Account</label>
                <input type="text" required class="form-control @error('account') is-invalid @enderror" id="account" name="account" placeholder="Enter account number" value="{{ old('account', $user->sellerInfo->account ?? '') }}">
                @error('account')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label for="ifsc" class="form-label">IFSC</label>
                <input type="text" required class="form-control @error('ifsc') is-invalid @enderror" id="ifsc" name="ifsc" placeholder="Enter IFSC code" value="{{ old('ifsc', $user->sellerInfo->ifsc ?? '') }}">
                @error('ifsc')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    <!-- Organization Details -->
        
        <div class="col-md-6">
            <div class="mb-3">
                <label for="bank_name" class="form-label">Bank Name</label>
                <input type="text" required class="form-control @error('bank_name') is-invalid @enderror" id="bank_name" name="bank_name" placeholder="Enter bank name" value="{{ old('bank_name', $user->sellerInfo->bank_name ?? '') }}">
                @error('bank_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label for="account_holder_name" class="form-label">Account Holder Name</label>
                <input type="text" required class="form-control @error('account_holder_name') is-invalid @enderror" id="account_holder_name" name="account_holder_name" placeholder="Enter account holder name" value="{{ old('account_holder_name', $user->sellerInfo->account_holder_name ?? '') }}">
                @error('account_holder_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label for="account_type" class="form-label">Account Type</label>
                <select class="form-select" name="account_type" id="accountType" required="">
                    <option value="" disabled>Select Account Type</option>
                    <option value="Saving" @selected(old('account_type', $user->sellerInfo->account_type ?? '') == 'Saving')>Saving</option>
                    <option value="Current" @selected(old('account_type', $user->sellerInfo->account_type ?? '') == 'Current')>Current</option>
                </select>
                @error('account_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label>Cancelled cheque</label>
                @if($user->sellerInfo->cancel_cheque)
                    <div class="list-group">
                        <div class="list-group-item">
                            <a class="btn btn-primary" href="{{ asset('/doc/seller/' .$user->id.'/'. $user->sellerInfo->cancel_cheque) }}" target="_blank">View Cancel Cheque</a>
                            <a class="btn btn-dark" href="{{ asset('/doc/seller/' .$user->id.'/'. $user->sellerInfo->cancel_cheque) }}" download>Download</a>
                            <label for="replaceCancelCheque" class="btn btn-danger text-white">Replace</label>
                        </div>
                    </div>
                @else
                    <input class="form-control" type="file" name="cancel_cheque" required placeholder="Cancel Cheque" required="">
                @endif
                <input type="hidden" class="form-control" id="brand" name="brand" placeholder="Enter brand" value="{{  optional($user->sellerInfo)->brand }}">
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
</form>
<form id="replaceCancelChequeForm" class="d-inline image-form" action="{{ route('seller.account.update-cancel-cheque') }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <input type="file" class="d-none" data-target="#replaceCancelChequeButton" id="replaceCancelCheque" name="replace_cancel_cheque">
    <button class="d-none submit-btn" id="replaceCancelChequeButton">Submit</button>
</form>
<form id="replaceGstDocForm" class="d-inline image-form" action="{{ route('seller.account.update-gst-doc') }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')
    <input type="file" class="d-none" data-target="#replaceGstDocButton" id="replaceGstDoc" name="replace_gst_doc">
    <button class="d-none submit-btn" id="replaceGstDocButton">Submit</button>
</form>
