<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DelhiveryController extends Controller
{
    public function pincodeCheck(Request $request){
        $response = Http::get(config('delhivery.test.pincode'), [
            'token' => env('DELHIVERY_TOKEN'),
            'filter_codes' => $request->pincode,
        ]);
        dd($response->body());
    }
}
