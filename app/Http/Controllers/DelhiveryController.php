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
                'Authorization' => 'Token ' . env('DELHIVERY_LIVE_TOKEN'),
            ])->get(config('delhivery.'.env('STRIPE_API_MODE').'.pincode'), [
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
        $response = Http::accept('application/json')
            ->withHeaders([
                'Authorization' => 'Token ' . env('DELHIVERY_LIVE_TOKEN'),
                'Content-Type' => 'application/json'
            ])->post(config('delhivery.'.env('STRIPE_API_MODE').'.warehouse-create'), [
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
            $data = [
                'name' => $request->name,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'address' => $request->address,
                'pincode' => $request->pincode,
                'city' => $request->city,
                'state' => $request->state,
                'client' => $ewayBill['data']['client'],
                'country' => $request->country,
                'return_address' => $request->return_check == 1 ?  $request->address : $request->return_address,
                'return_pincode' => $request->return_check == 1 ?  $request->pincode : $request->return_pincode,
                'return_city' => $request->return_check == 1 ?  $request->city : $request->return_city,
                'return_state' => $request->return_check == 1 ?  $request->state : $request->return_state,
                'return_country' => $request->return_check == 1 ?  $request->country : $request->return_country,
                'user_id' => Auth::user()->id,
                'default' => $request->default_address ?? 0
            ];
            Warehouse::create($data);
            request()->session()->put('success','Warehouse created successfully');
        }else{
            request()->session()->put('error',$ewayBill['error'][0]);
        }
        return redirect()->back();
    }

    public function shipmentCreate(Request $request)
    {
        $user = Auth::user();
        $wareHouse = Warehouse::where('user_id', $user->id)
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
                    "seller_name": "'.$user->name.'",
                    "seller_inv": "",
                    "quantity": "'.$orderItem->quantity.'",
                    "waybill": "",
                    "shipment_width": "'.$request->width.'",
                    "shipment_height": "'.$request->height.'",
                    "shipment_length":"'.$request->length.'",
                    "weight": "'.$request->weight.'",
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
            $request = new Psr7Request('POST', config('delhivery.'.env('STRIPE_API_MODE').'.shipment-create'), $headers, $body);
            $res = $client->sendAsync($request)->wait();
            $data =  json_decode($res->getBody(),true);
            if($data['success']){
                $order->update([
                    'ewaybill' => $data['packages'][0]['waybill']
                ]);
                request()->session()->put('success','Manifest created successfully');
            }else{
                request()->session()->put('error',$data['rmk']);
            }
            return redirect()->route('seller.order.list');
        } catch (Exception $e) {
            request()->session()->put('error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function slipDownload(Request $request)
    {
        $order = Order::where('id', $request->id)->first();
        $response = Http::accept('application/json')
            ->withHeaders([
                'Authorization' => 'Token ' . env('DELHIVERY_LIVE_TOKEN'),
                'Content-Type' => 'application/json',
            ])->get(config('delhivery.'.env('STRIPE_API_MODE').'.slip'), [
                'wbns' => $order->ewaybill,
                'pdf' => 'true'
            ]);
        $data = json_decode($response->body(),true);
        if($data['packages_found'] > 0){
            return redirect()->to($data['packages'][0]['pdf_download_link']);
        }else{
            request()->session()->put('error','Package not found');
            return redirect()->back(); 
        }
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
            ])->post(config('delhivery.'.env('STRIPE_API_MODE').'.pickup'), [
                "pickup_time"=> $request->time.":00",
                "pickup_date"=> $request->date,
                "pickup_location"=> $wareHouse->name,
                "expected_package_count"=> $request->count
            ]);
        $data = json_decode($response->body(),true);
        if(!empty($data)){
            request()->session()->put('success',$data['prepaid']);
        }else{
            request()->session()->put('error','Something went wrong');
        }
        return redirect()->back();
    }

    public function track(Request $request)
    {
        $order = Order::where('id', $request->id)->first();
        // $response = Http::accept('application/json')
        //     ->withHeaders([
        //         'Authorization' => 'Token ' . env('DELHIVERY_LIVE_TOKEN'),
        //         'Content-Type' => 'application/json',
        //     ])->get(config('delhivery.'.env('STRIPE_API_MODE').'.track'), [
        //         'waybill' => $order->ewaybill
        //     ]);
        // $data = json_decode($response->body(),true);
        // dd($data);
        // return response($response->body(), 200);
        return redirect()->to('https://www.delhivery.com/track/package/'.$order->ewaybill);
    }

    public function shipmentForm(Request $request){
        return view('backend.seller.shipment.create');
    }

    public function ndrCall(Request $request){
        $order = Order::where('id', $request->id)->first();
        $response = Http::accept('application/json')
            ->withHeaders([
                'Authorization' => 'Token ' . env('DELHIVERY_LIVE_TOKEN'),
                'Content-Type' => 'application/json',
            ])->get(config('delhivery.'.env('STRIPE_API_MODE').'.track'), [
                'waybill' => $order->ewaybill
            ]);
        $data = json_decode($response->body(),true);
        dd($data);
        return response($response->body(), 200);
    }

    public function cancelOrder(Request $request){
        if(Auth::user()->role == 'seller'){
            $order = Order::where('id', $request->id)->first();
        }else{
            $order = Order::where('id', $request->id)->where('user_id',Auth::user()->id)->first();
        }
        if(empty($order)){
            return response()->json([
                'msg'=>'order not found'
            ],400);
        }

        $response = Http::accept('application/json')
            ->withHeaders([
                'Authorization' => 'Token ' . env('DELHIVERY_LIVE_TOKEN'),
                'Content-Type' => 'application/json',
            ])->post(config('delhivery.'.env('STRIPE_API_MODE').'.order-edit'), [
                'waybill' => $order->ewaybill,
                "cancellation"=>true
            ]);
        $data = json_decode($response->body(),true);
        if($data['status']){
            $order->update([
                'status'=>'cancelled'
            ]);
            return response()->json([
                'msg'=>'Order cancelled successfully'
            ],200);
        }
        return response()->json([
            'msg'=>'something went wrong'
        ],400);
    }
}
