<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\OrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

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
        if(is_null($order->invoice_number)) {
            $order->invoice_number = '#'.strtotime('now') . $order->user_id;
            $order->invoice_generated_at = now();
            $order->update();
        }
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
        $order->update();
        request()->session()->put('success','Order accepted successfully');
        return redirect()->route('seller.order.list');
    }
}
