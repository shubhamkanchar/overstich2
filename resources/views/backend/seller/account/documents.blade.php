<form action="" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="noc_doc" class="form-label">NOC Document</label>
                <input type="file" class="form-control" id="noc_doc" name="noc_doc">
                @if($user->sellerInfo->noc_doc)
                    <a href="{{ asset('doc/seller/'.auth()->user()->id.'/' . $user->sellerInfo->noc_doc) }}" target="_blank">View NOC Document</a>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label>Authorize Signature</label>
                <input class="form-control" type="file" name="cancel_cheque" placeholder="Cancel Cheque" required="">
                @if($user->sellerInfo->cancel_cheque)
                    <a href="{{ asset('doc/seller/'.auth()->user()->id.'/' . $user->sellerInfo->cancel_cheque) }}" target="_blank">View cancel</a>
                @endif
            </div>
        </div>
    </div>
</form>