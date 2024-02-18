<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\OrderDataTable;
use App\DataTables\ReturnOrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ReturnOrderModel;
use App\Models\Warehouse;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(OrderDataTable $dataTable) {
        if(auth()->user()->user_type == 'seller') {
            return $dataTable->render('backend.seller.order.index');    
        }
        return $dataTable->render('backend.admin.order.index');
    }

    public function viewOrder($id) {

        $user = auth()->user();
        $order = Order::where('id', $id)->with(['orderItem', 'orderItem.product'])->first();
        if($user->user_type == 'seller') {
            if($user->id !== $order->seller_id) {
                return abort(401, "Don't try to access others");
            }
            return view('backend.seller.order.view', compact('order'));    
        }
        return view('backend.admin.order.view', compact('order'));
    }

    public function downloadInvoice($id) {
        $order = Order::where('id',$id)->with(['orderItem', 'seller', 'seller.sellerInfo'])->withCount('orderItem')->first();
        
        // return view('backend.seller.order.invoice', compact('order'));
        $pdf = Pdf::loadView('backend.seller.order.invoice', compact('order'));
 
        return $pdf->download($order->order_number.'.pdf');
    }

    public function rejectOrder(Request $request, Order $order) {
        $order->status = 'rejected';
        $order->rejection_reason = $request->reason;
        $order->update();
        request()->session()->put('success','Order rejected successfully');
        return redirect()->route('seller.order.list');
    }

    public function acceptOrder(Request $request, Order $order) {
        $order->status = 'processing';
        if(is_null($order->invoice_number)) {
            $order->invoice_number = '#'.strtotime('now') . $order->user_id;
            $order->invoice_generated_at = now();
            $order->update();
        }
        $order->update();
        request()->session()->put('success','Order accepted successfully');
        return redirect()->route('seller.order.list');
    }

    public function orderReturnTable(ReturnOrderDataTable $dataTable){
        return $dataTable->render('backend.seller.order.return-order');
    }

    public function orderReturnView(Request $request){
        $user = auth()->user();
        $order_number = $request->order_number;
        $order = Order::where('order_number', $order_number)
                ->with(['orderItem', 'orderItem.product'])
                ->first();
        if($user->user_type == 'seller') {
            if($user->id != $order->seller_id) {
                return abort(401, "Don't try to access others");
            }
            return view('backend.seller.order.return-view', compact('order'));    
        }
        return view('backend.admin.order.return-view', compact('order'));
    }

    public function acceptReturnOrder(Request $request){
        $user = Auth::user();
        $wareHouse = Warehouse::where('user_id', $user->id)
            ->where('default', 1)
            ->first();
        $order = Order::where('id', $request->id)->first();
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
                    "payment_mode": "Pickup",
                    "return_pin": '.$wareHouse->pincode .',
                    "return_city": "'.$wareHouse->city .'",
                    "return_phone": "'.$wareHouse->mobile .'",
                    "return_add": "'.$wareHouse->address .'",
                    "return_state": "'.$wareHouse->state .'",
                    "return_country": "'.$wareHouse->country .'",
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
            $apiRequest = new Psr7Request('POST', config('delhivery.'.env('STRIPE_API_MODE').'.shipment-create'), $headers, $body);
            $res = $client->sendAsync($apiRequest)->wait();
            $data =  json_decode($res->getBody(),true);
            if($data['success']){
                $order->update([
                    'ewaybill' => $data['packages'][0]['waybill']
                ]);
                request()->session()->put('success','Order status updated successfully');
                $ReturnOrder = ReturnOrderModel::where('order_id',$request->id)->first();
                $ReturnOrder->update([
                    'status_condition' => 'accepted',
                ]);
                
                if($ReturnOrder->status == 'replace'){
                    $newOrder = $order->replicate();
                    $newOrder->ewaybill = Null; 
                    $newOrder->order_number = 'OI'.strtotime('now') . $order->user_id ?? '';
                    $order->status = 'processing';
                    $order->invoice_number = '#'.strtotime('now') . $order->user_id;
                    $order->invoice_generated_at = now();
                    $newOrder->save();

                    $newOrderItem = OrderItem::where('order_id', $request->id)->first();
                    $newOrderItem = $newOrderItem->replicate(); 
                    $newOrderItem->order_id = $newOrder->id;
                    $newOrderItem->save();
                }
            }else{
                request()->session()->put('error',$data['rmk']);
            }
            return redirect()->route('seller.order.list');
        } catch (Exception $e) {
            request()->session()->put('error',$e->getMessage());
            return redirect()->back();
        }
    }

    public function rejectReturnOrder(Request $request){
        $data = ReturnOrderModel::where('order_id',$request->id)
                ->update([
                    'status_condition' => 'rejected',
                    'rejected_reason' => $request->reason
                ]);
        if(!empty($data)){
            request()->session()->put('success','Order status updated successfully');
        }else{
            request()->session()->put('error','Something went wrong');
        }
        return redirect()->back();
    }
}
