<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Warehouse;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DelhiveryController extends Controller
{
    public function pincodeCheck(Request $request)
    {
        $response = Http::accept('application/json')
            ->withHeaders([
                'Authorization' => 'Token ' . env('DELHIVERY_TOKEN'),
            ])->get(config('delhivery.test.pincode'), [
                'filter_codes' => $request->pincode,
            ]);
        return response($response->body(), 200);
    }

    public function warehouseCreate()
    {
        return view('backend.seller.warehouse.create');
    }

    public function warehouseStore(Request $request)
    {
        if ($request->default_address == 1) {
            Warehouse::where('user_id', Auth::user()->id)->update(['default' => 0]);
        }
        $data = [
            'name' => $request->name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'address' => $request->address,
            'pincode' => $request->pincode,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'return_address' => $request->return_check == 1 ?  $request->address : $request->return_address,
            'return_pincode' => $request->return_check == 1 ?  $request->pincode : $request->return_pincode,
            'return_city' => $request->return_check == 1 ?  $request->city : $request->return_city,
            'return_state' => $request->return_check == 1 ?  $request->state : $request->return_state,
            'return_country' => $request->return_check == 1 ?  $request->country : $request->return_country,
            'user_id' => Auth::user()->id,
            'default' => $request->default_address ?? 0
        ];
        $wareHouse = Warehouse::create($data);

        $response = Http::accept('application/json')
            ->withHeaders([
                'Authorization' => 'Token ' . env('DELHIVERY_LIVE_TOKEN'),
                'Content-Type' => 'application/json'
            ])->post(config('delhivery.live.warehouse-create'), [
                'name' => $request->name,
                'phone' => $request->mobile,
                'email' => $request->email,
                'address' => $request->address,
                'pin' => $request->pincode,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'return_address' => $request->return_check == 1 ?  $request->address : $request->return_address,
                'return_pin' => $request->return_check == 1 ?  $request->pincode : $request->return_pincode,
                'return_city' => $request->return_check == 1 ?  $request->city : $request->return_city,
                'return_state' => $request->return_check == 1 ?  $request->state : $request->return_state,
                'return_country' => $request->return_check == 1 ?  $request->country : $request->return_country,
            ]);
        $ewayBill = json_decode($response->body(), true);
        if ($ewayBill['success']) {
            $wareHouse->update([
                'client' => $ewayBill['data']['client']
            ]);
        }
        notify()->success('Warehouse created successfully');
        return redirect()->back();
    }

    public function shipmentCreate(Request $request)
    {
        $wareHouse = Warehouse::where('user_id', Auth::user()->id)
            ->where('default', 1)
            ->first();
        $order = Order::where('id', $request->id)->first();
        $orderType = $order->payment_method == 'cod' ? 'COD' : 'PREPAID';
        $codAmount = $order->payment_method == 'cod' ? $order->total_amount : 0;
        $orderItem = $order->orderItem;
        $data = [
            "images" => $orderItem->image,
            "color" => $orderItem->color,
            "descr" => $orderItem->name,
            "pcat" => "Clothing.",
            "item_quantity"  => $orderItem->quantity
        ];
        $data = json_encode($data);

        try {
            $response = Http::accept('application/json')
                ->withHeaders([
                    'Authorization' => 'Token ' . env('DELHIVERY_LIVE_TOKEN'),
                ])->get(config('delhivery.live.waybill'));
            $ewayBill = $response->body();
            
            $order->update(['ewaybill' => $ewayBill]);

            $client = new Client();
            $headers = [
                'Authorization' => 'Token ' . env('DELHIVERY_LIVE_TOKEN'),
                'Content-Type' => 'application/json',
            ];

            $body = 'format=json&data={
                "shipments": [
                {
                    "name": "'.$order->first_name.' '.$order->last_name.'",
                    "add": "'.$order->address.'",
                    "pin": "'.$order->pincode.'",
                    "city": "'.$order->city.'",
                    "state": "'.$order->state.'",
                    "country": "'.$order->country.'",
                    "phone": "'.$order->phone.'",
                    "order": "'.$order->order_number.'",
                    "payment_mode": "'.$orderType.'",
                    "return_pin": "",
                    "return_city": "",
                    "return_phone": "",
                    "return_add": "",
                    "return_state": "",
                    "return_country": "",
                    "products_desc": "",
                    "hsn_code": "",
                    "cod_amount": "'.$codAmount.'",
                    "order_date": null,
                    "total_amount": '.$codAmount.',
                    "seller_add": "",
                    "seller_name": "",
                    "seller_inv": "",
                    "quantity": "",
                    "waybill": "'.$ewayBill.'",
                    "shipment_width": "",
                    "shipment_height": "",
                    "weight": "",
                    "seller_gst_tin": "",
                    "shipping_mode": "Surface",
                    "address_type": ""
                  }
                ],
                "pickup_location": {
                    "name": "' . $wareHouse->name . '",
                    "city": "' . $wareHouse->city . '",
                    "pin_code": ' . $wareHouse->pincode . ',
                    "country": "' . $wareHouse->country . '",
                    "phone": "' . $wareHouse->mobile . '",
                    "add": "' . $wareHouse->address . '"
                }
            }';
            $request = new Psr7Request('POST', config('delhivery.live.shipment-create'), $headers, $body);
            $res = $client->sendAsync($request)->wait();
            $data =  json_decode($res->getBody(),true);
            if($data['success']){
                notify()->success('Manifest created successfully');
            }else{
                notify()->error($data['rmk']);
            }
            return redirect()->back();
        } catch (Exception $e) {
            Log::info($e->getMessage());
        }
    }

    public function slipDownload(Request $request)
    {
        $order = Order::where('id', $request->id)->first();
        $response = Http::accept('application/json')
            ->withHeaders([
                'Authorization' => 'Token ' . env('DELHIVERY_TOKEN'),
            ])->get(config('delhivery.test.slip'), [
                'wbns' => $order->ewaybill,
                'pdf' => true
            ]);
        return response($response->body(), 200);
    }

    public function raisePickup(Request $request)
    {
        $wareHouse = Warehouse::where('user_id', Auth::user()->id)
            ->where('default', 1)
            ->first();  
        $response = Http::accept('application/json')
            ->withHeaders([
                'Authorization' => 'Token ' . env('DELHIVERY_TOKEN'),
                'Content-Type' => 'application/json'
            ])->post(config('delhivery.test.pickup'), [
                "pickup_time"=> $request->time.":00",
                "pickup_date"=> $request->date,
                "pickup_location"=> $wareHouse->name,
                "expected_package_count"=> $request->count
            ]);
        $data = json_decode($response->body(),true);
        if(!empty($data)){
            notify()->success($data['prepaid']);
        }else{
            notify()->error('Something went wrong');
        }
        return redirect()->back();
    }
}
