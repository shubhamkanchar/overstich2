<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice</title>
    <style>
        h4 {
            margin: 0;
        }
        .w-full {
            width: 100%;
        }
        .w-half {
            width: 50%;
        }
        .margin-top {
            margin-top: 1.25rem;
        }
        .footer {
            width: 100%;
            position: absolute;
            bottom: 0px;
            padding: 5px;
        }
        table {
            width: 100%;
            border-spacing: 0;
        }
        table.products {
            font-size: 0.875rem;
        }
        table.products tr {
            /* background-color: rgb(96 165 250); */
        }
        table.products th {
            padding: 0.5rem;
            /* border: 2px 0px solid;  */
        }
        table tr.items {
        }
        table tr.items td {
            padding: 0.5rem;
        }
        .text-center {
            text-align: center;
        }
        .text-end {
            text-align: right;
        }
        .total {
            text-align: right;
            margin-top: 1rem;
            font-size: 0.875rem;
        }
        .font-bold {
            font-weight: bold;
        }

        hr {
            border: 0.5px solid black;
        }
    </style>
</head>
<body>

    <div id="firstPage">
        <div class="text-center"> 
            <h3> Tax Invoice </h3>
        </div>
        <div class="margin-top">
            <table class="w-full">
                <tr>
                    <td class="w-half">
                        <div><b>Order ID: </b>{{ $order->order_number }}</div>
                        <div><b>Transaction ID:</b> {{ $order->payment_transaction_id }}</div>
                        <div><b>Order Date:</b> {{ $order->created_at->format('d-m-Y') }}</div>
                        <div><b>Invoice Date:</b> {{ $order->invoice_generated_at->format('d-m-Y') }}</div>
                    </td>
                    <td class="w-half text-end" style="vertical-align: top;">
                        <div><b>Invoice ID: </b>{{ $order->invoice_number }}</div>
                        <div><b>Nature of Supply:</b> Goods</div>
                        <div>&nbsp;</div>
                        <div>&nbsp;</div>
                    </td>
                </tr>
            </table>
        </div>
        <hr>
        <div class="margin-top">
            <table class="w-full">
                <tr>
                    <td class="w-half">
                        <div> <b> Billed From:</b> </div>
                        <div> <b> {{  $order->seller->name }} </b> </div>
                        <div> <b>shipping-from-address:</b>  {{ $order->seller->sellerInfo->address }}, {{ $order->seller->sellerInfo->locality }}, {{ $order->seller->sellerInfo->city }}, {{ $order->seller->sellerInfo->state }} - {{ $order->seller->sellerInfo->pincode }}</div>
                        <div> <b>GSTIN Number:</b> {{  $order->seller->sellerInfo->gst }} </div>
                        <div> <b> state code </b>-{{ $order->seller->sellerInfo->pincode }} </div>
                    </td>
                    <td class="w-half" style="vertical-align: top;">
                        <div> <b> Ship From:</b> </div>
                        <div> <b> {{  $order->seller->name }} </b> </div>
                        <div> <b>shipping-from-address:</b>  {{ $order->seller->sellerInfo->address }}, {{ $order->seller->sellerInfo->locality }}, {{ $order->seller->sellerInfo->city }}, {{ $order->seller->sellerInfo->state }} - {{ $order->seller->sellerInfo->pincode }}</div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="margin-top">
            <table class="w-full">
                <tr>
                    <td class="w-half" style="vertical-align: top">
                        <div><b>Bill To:</b></div>
                        <div><b>{{ ucfirst($order->first_name).' '. ucfirst($order->last_name) }}</b></div> 
                        <div>{{ $order->address }}, {{ $order->locality }}, {{ $order->city }}, {{ $order->state }} - {{ $order->pincode }}</div>
                        <div> <b>Customer Type</b> : unregistered</div>
                    </td>
                </tr>
            </table>
        </div>
        <hr>
        
        <div class="margin-top">
        {{-- Total items:{{ $order->order_item_count }} --}}
            <table class="products">
                <tr>
                    <td colspan="6">
                        <hr style="border: 0.5px solid gray;">
                    </td>
                </tr>
                <tr>
                    <th class="text-center">Qty</th>
                    <th class="text-center">Product</th>
                    <th class="text-center">Gross Amount(rs)</th>
                    <th class="text-center">Discount(rs)</th>
                    <th class="text-center">Taxable Amount(rs)</th>
                    <th class="text-center">IGST(rs)</th>
                    <th class="text-center">CGST(rs)</th>
                    <th class="text-center">SGST(rs)</th>
                    <th class="text-center">Total Amount(rs)</th>
                </tr>
                <tr>
                    <td colspan="9">
                        <hr style="border: 0.5px solid gray;">
                    </td>
                </tr>
                <tr class="items">
                    <tr>
                        <td class="text-center">{{ $order->orderItem->quantity }}</td>
                        <td class="text-center">{{ ucfirst($order->orderItem->name) }}</td>
                        <td class="text-center">Rs.{{ number_format($order->orderItem->original_price, 2) }}</td>
                        <td class="text-center">Rs.{{ number_format($order->orderItem->discount, 2) }}</td>
                        <td class="text-center">Rs.{{ number_format($order->orderItem->price, 2) }} </td>
                        <td class="text-center">Rs.{{ number_format($order->igst_percent, 2) }} </td>
                        <td class="text-center">Rs.{{ number_format($order->cgst_percent, 2) }} </td>
                        <td class="text-center">Rs.{{ number_format($order->sgst_percent, 2) }} </td>
                        <td class="text-center">Rs.{{ number_format($order->orderItem->price, 2) }} </td>
                    </tr>
                </tr>
                <tr>
                    {{-- <td colspan="1">&nbsp;</td> --}}
                    <td colspan="9">
                        <hr style="border: 0.5px solid gray;">
                    </td>
                </tr>
                <tr>
                    {{-- <td colspan="1"> <b>Total</b></td>
                    <td colspan="1"> </td>
                    <td colspan="1"> </td>
                    <td class="text-center font-bold">Subtotal(rs) </td>
                    <td class="text-center font-bold">Delivery Charge(rs) </td>
                    <td class="text-center font-bold">Discount(rs) </td>
                    <td class="text-center font-bold">Total Amount(rs) </td> --}}
                </tr>
                <tr>
                    <td colspan="1"> <b>Total</b>
                    <td colspan="1"> </td>
                    <td class="text-center"><b>Rs.{{ number_format($order->sub_total, 2) }}</b></td>
                    <td class="text-center"><b>Rs.{{ number_format($order->total_discount, 2) }}</b></td>
                    <td class="text-center"><b>Rs.{{ number_format($order->total_amount, 2) }}</b> </td>
                    <td class="text-center"><b>Rs.{{ number_format($order->igst_percent, 2) }}</b> </td>
                    <td class="text-center"><b>Rs.{{ number_format($order->cgst_percent, 2) }}</b> </td>
                    <td class="text-center"><b>Rs.{{ number_format($order->sgst_percent, 2) }}</b> </td>
                    <td class="text-center"><b>Rs.{{ number_format($order->total_amount, 2) }}</b> </td>
                </tr>
            </table>
        </div>

        <hr>
        <div class="text-end">
            <span class="text-start" style="margin-right: 40px;">Grand Total:</span>
            <span class="text-start" style="margin-left: 10px;"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span><b> {{ number_format($order->total_amount, 2) }}</b> </span>
        </div>
        <div class="text-end" style="margin: 5px;">{{  $order->seller->name }}</div>
        <br>
        <br>
        <br>
        <div class="div">
            <img src="" alt="">
        </div>
        <div class="text-end">Authorized Signatory</div>
        <hr>
        <h5>DECLARATION</h5>
        <p>The goods sold as part of this shipment are intended for end-user consumption and are not for retail sale.</p>
        <hr>
        <p>If you have any questions, contact us on +917066856414 or overstitch.in@gmail.com</p>
        <hr>
        <p>Purchase made on Overstitch</p>
        {{-- <div class="footer">
            <div class="text-end">Thank you</div>
            <div class="text-end">copyright @ overstitch</div>
            <div class="text-start"> Contact Overstich: 04556669 || www.overstich.com/helpline</div>
            <hr>
            <div class="text-end">
                <span style="margin-right: 20px;"><b>E.&O.E</b></span>
                <span>| page 1 of 2</span>
            </div>

        </div> --}}
    </div>
</body>
</html>