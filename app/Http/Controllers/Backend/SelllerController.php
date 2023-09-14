<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SelllerController extends Controller
{
    public function dashboard(){
        return view('backend.seller.dashboard');
    }
}
