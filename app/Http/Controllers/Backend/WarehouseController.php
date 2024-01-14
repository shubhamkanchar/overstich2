<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\WarehouseDataTable;
use App\Models\Warehouse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(WarehouseDataTable $dataTable)
    {
        return $dataTable->render('backend.seller.warehouse.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $response = Http::accept('application/json')
        ->withHeaders([
            'Authorization' =>'Token '. env('DELHIVERY_TOKEN'),
        ])->get(config('delhivery.test.warehouse-create'), [
            "phone" => "8888888888",
            "city" => "Kota",
            "name" => "TS Surface 2",
            "pin" => "324005",
            "address" => "address",
            "country" => "India",
            "email" => "abc@gmail.com",
            "registered_name" => "TS Surface 2",
            "return_address" => "return_address",
            "return_pin" => "324005",
            "return_city" => "Kota",
            "return_state" => "Delhi",
            "return_country" => "India"
        ]);
        dd($response->body());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Warehouse $warehouse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warehouse $warehouse)
    {
        return view('backend.seller.warehouse.edit',compact('warehouse'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Warehouse $warehouse)
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
            'default' => $request->default_address ?? 0
        ];
        $wareHouse = $warehouse->update($data);

        $response = Http::accept('application/json')
            ->withHeaders([
                'Authorization' => 'Token ' . env('DELHIVERY_LIVE_TOKEN'),
                'Content-Type' => 'application/json'
            ])->post(config('delhivery.live.warehouse-edit'), [
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
            $warehouse->update([
                'client' => $ewayBill['data']['client']
            ]);
        }
        notify()->success('Warehouse updated successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warehouse $warehouse)
    {
        //
    }
}
