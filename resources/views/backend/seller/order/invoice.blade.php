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

    <div class="text-center"> 
        <h3> Tax Invoice </h3>
    </div>
    <table class="w-full">
        <tr>
            <td class="w-half">
                <div> <b> Sold by: {{  $order->seller->name }} </b> </div>
                <div> <b>shipping-from-address:</b>  {{ $order->seller->sellerInfo->address }}, {{ $order->seller->sellerInfo->locality }}, {{ $order->seller->sellerInfo->city }}, {{ $order->seller->sellerInfo->state }} - {{ $order->seller->sellerInfo->pincode }}</div>
                <div> <b> GST No: {{  $order->seller->sellerInfo->gst }} </b> </div>
            </td>
            <td class="w-half text-end">
                <span style="border: 1px dotted;"> <b>Invoice ID: </b> {{ $order->invoice_number}} </span>
            </td>
        </tr>
    </table>
    <hr>
    <div class="margin-top">
        <table class="w-full">
            <tr>
                <td class="w-half">
                    <div><b>Order ID: </b>{{ $order->order_number }}</div>
                    <div><b>Transaction ID:</b> {{ $order->payment_transaction_id }}</div>
                    <div><b>Order Date:</b> {{ $order->created_at->format('d-m-Y') }}</div>
                    <div><b>Invoice Date:</b> {{ $order->invoice_generated_at }}</div>
                </td>
                <td class="w-half" style="vertical-align: top">
                    <div><b>Ship To:</b></div>
                    <div><b>{{ ucfirst($order->first_name).' '. ucfirst($order->last_name) }}</b></div>
                    <div>{{ $order->address }}, {{ $order->locality }}, {{ $order->city }}, {{ $order->state }} - {{ $order->pincode }}</div>
                </td>
            </tr>
        </table>
    </div>
    <div class="margin-top">
    Total items:{{ $order->order_item_count }}
        <table class="products">
            <tr>
                <td colspan="6">
                    <hr style="border: 0.5px solid gray;">
                </td>
            </tr>
            <tr>
                <th class="text-center">Product(rs)</th>
                <th class="text-center">Price(rs)</th>
                <th class="text-center">Discount(rs)</th>
                <th class="text-center">Quantity</th>
                <th class="text-center">Overall Discount(rs)</th>
                <th class="text-center">Overall Amount(rs)</th>
            </tr>
            <tr>
                <td colspan="6">
                    <hr style="border: 0.5px solid gray;">
                </td>
            </tr>
            <tr class="items">
                @foreach ($order->orderItem as $item)
                    <tr>
                        <td class="text-center">{{ ucfirst($item->name) }}</td>
                        <td class="text-center">{{ number_format($item->price, 2) }} </td>
                        <td class="text-center">{{ number_format($item->discount, 2) }} </td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-center">{{ number_format($item->total_discount, 2) }} </td>
                        <td class="text-center">{{ number_format($item->total_price, 2) }} </td>
                    </tr>
                @endforeach
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
                <td colspan="4">
                    <hr style="border: 0.5px solid gray;">
                </td>
            </tr>
            <tr>
                <td colspan="2"></td>
                <td class="text-center font-bold">Subtotal(rs) </td>
                <td class="text-center font-bold">Delivery Charge(rs) </td>
                <td class="text-center font-bold">Discount(rs) </td>
                <td class="text-center font-bold">Total Amount(rs) </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td class="text-center">{{ number_format($order->sub_total, 2) }} </td>
                <td class="text-center">{{ number_format($order->deliver, 2) }}</td>
                <td class="text-center">{{ number_format($order->total_discount, 2) }} </td>
                <td class="text-center">{{ number_format($order->total_amount, 2) }} </td>
            </tr>
        </table>
    </div>

    <hr>
    <div class="text-end">
        <span class="text-start" style="margin-right: 40px;">Grand Total:</span>
        <span class="text-start" style="margin-left: 10px;"><b> {{ number_format($order->total_amount, 2) }} rs</b> </span>
    </div>
    <div class="text-end">{{  $order->seller->name }}</div>
    <br>
    <br>
    <div class="text-end">Authorized Signatory</div>
    <hr>
    <div class="footer">
        <div class="text-end">Thank you</div>
        <div class="text-end">copyright @ overstitch</div>
        <div class="text-start"> Contact Overstich: 04556669 || www.overstich.com/helpline</div>
        <hr>
        <div class="text-end">
            <span style="margin-right: 20px;"><b>E.&O.E</b></span>
            <span>| page 1 0f 1</span>
        </div>

    </div>
</body>
</html>