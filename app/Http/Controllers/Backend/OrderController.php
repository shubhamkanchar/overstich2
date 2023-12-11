<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\OrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
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
}
