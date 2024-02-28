<div class="row">
    <div class="col-md-6">
        <div class="mb-3">
            <form id="replaceNocDocForm" class="d-inline image-form" action="{{ route('seller.account.update-noc-doc') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <label for="noc_doc" class="form-label">NOC Document</label>
                @if($user->sellerInfo->noc_doc)
                    <div class="list-group">
                        <div class="list-group-item list-group-item-action">
                            <a class="btn btn-primary" href="{{ asset('/doc/seller/' .$user->id.'/'. $user->sellerInfo->noc_doc) }}" target="_blank">View Cancel Cheque</a>
                            <a class="btn btn-dark" href="{{ asset('/doc/seller/' .$user->id.'/'. $user->sellerInfo->noc_doc) }}" download>Download</a>
                            <label for="NocDoc" class="btn btn-danger text-white">Replace</label>
                        </div>
                    </div>
                @else
                    <div class="list-group border">
                        <div class="list-group-item list-group-item-action">
                            <label for="NocDoc" class="btn btn-primary text-white">Add NOC</label>
                        </div>
                    </div>
                @endif
                <input type="file" class="d-none" data-target="#NocDocButton" id="NocDoc" name="noc_doc">
                <button class="d-none submit-btn" id="NocDocButton">Submit</button>
            </form>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <form id="AuthorizeSignatureForm" class="d-inline image-form" action="{{ route('seller.account.update-authorize-signature') }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <label class="form-label">Authorize Signature</label>
                @if($user->sellerInfo->signature)
                    <div class="list-group">
                        <div class="list-group-item list-group-item-action">
                            <a class="btn btn-primary" href="{{ asset($user->sellerInfo->signature) }}" target="_blank">View Signature</a>
                            <a class="btn btn-dark" href="{{ asset($user->sellerInfo->signature) }}"download>Download</a>
                            <label for="NocDoc" class="btn btn-danger text-white">Replace</label>
                        </div> 
                    </div>
                @else
                    <div class="list-group">
                        <div class="list-group-item list-group-item-action">
                            <label for="authorizeSignature" class="btn btn-primary text-white">Add Signature</label>
                        </div> 
                    </div>
                @endif
                <input type="file" class="d-none upload-file" data-target="#authorizeSignatureButton" id="authorizeSignature" name="authorize_signature">
                <button class="d-none submit-btn" id="authorizeSignatureButton">Submit</button>
            </form>
        </div>
    </div>
</div>