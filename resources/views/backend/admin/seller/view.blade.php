@extends('backend.admin.layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Seller Information</div>
            <div class="card-body table-responsive">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table">
                            <tr>
                                <th colspan="2">Owner Information</th>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <td>Contact</td>
                                <td>{{ $user->owner_contact }}</td>
                            </tr>
                            <tr>
                                <td>Brand Name</td>
                                <td>{{ $sellerInfo->brand }}</td>
                            </tr>
                            <tr>
                                <td>GST</td>
                                <td>{{ $sellerInfo->gst }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table">
                            <tr>
                                <th colspan="2">Organization Information</th>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td>{{ $user->organization_name }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td>WhatsApp</td>
                                <td>{{ $sellerInfo->whatsapp }}</td>
                            </tr>
                            <tr>
                                <td>Product</td>
                                <td>{{ $sellerInfo->products }}</td>
                            </tr>
                            <tr>
                                <td>Price-range</td>
                                <td>{{ $sellerInfo->price_range }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table">
                            <tr>
                                <th colspan="2">Brand Address Information</th>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>{{ $sellerInfo->address }}</td>
                            </tr>
                            <tr>
                                <td>Locality</td>
                                <td>{{ $sellerInfo->locality }}</td>
                            </tr>
                            <tr>
                                <td>City</td>
                                <td>{{ $sellerInfo->city }}</td>
                            </tr>
                            <tr>
                                <td>State</td>
                                <td>{{ $sellerInfo->state }}</td>
                            </tr>
                            <tr>
                                <td>Pincode</td>
                                <td>{{ $sellerInfo->pincode }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table">
                            <tr>
                                <th colspan="2">Account Information</th>
                            </tr>
                            <tr>
                                <td>Holder Name</td>
                                <td>{{ $sellerInfo->account_holder_name }}</td>
                            </tr>
                            <tr>
                                <td>Bank Name</td>
                                <td>{{ $sellerInfo->bank_name }}</td>
                            </tr>
                            <tr>
                                <td>Account Number</td>
                                <td>{{ $sellerInfo->account }}</td>
                            </tr>
                            <tr>
                                <td>Account Type </td>
                                <td>{{ $sellerInfo->account_type }}</td>
                            </tr>
                            <tr>
                                <td>IFSC</td>
                                <td>{{ $sellerInfo->ifsc }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-primary" href="{{ asset('doc/seller/'.$user->id.'/'.$sellerInfo->noc_doc) }}" target="_blank">NOC Document</a>
                        <a class="btn btn-primary" href="{{ asset('doc/seller/'.$user->id.'/'.$sellerInfo->gst_doc) }}" target="_blank">GST Document</a>
                        <a class="btn btn-primary" href="{{ asset('doc/seller/'.$user->id.'/'.$sellerInfo->cancel_cheque) }}" target="_blank">Cancel Cheque</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection