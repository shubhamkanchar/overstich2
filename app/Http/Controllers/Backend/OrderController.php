<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\OrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(OrderDataTable $dataTable) {
        return $dataTable->render('backend.admin.order.index');
    }

    public function viewOrder($id) {
        $order = Order::where('id', $id)->with(['orderItem', 'orderItem.product'])->first();
        return view('backend.admin.order.view', compact('order'));
    }
}
