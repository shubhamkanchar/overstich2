<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DelhiveryController extends Controller
{
    public function pincodeCheck(Request $request){
        $response = Http::accept('application/json')
        ->withHeaders([
            'Authorization' =>'Token '. env('DELHIVERY_TOKEN'),
        ])->get(config('delhivery.test.pincode'), [
            'filter_codes' => $request->pincode,
        ]);
        return response($response->body(),200);
    }
}
