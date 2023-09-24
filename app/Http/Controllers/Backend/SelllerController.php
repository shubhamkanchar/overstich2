<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SellersDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SelllerController extends Controller
{
    public function index(SellersDataTable $dataTable)
    {
        return $dataTable->render('backend.admin.seller.index');
    }

    public function dashboard(){
        return view('backend.seller.dashboard');
    }
}
