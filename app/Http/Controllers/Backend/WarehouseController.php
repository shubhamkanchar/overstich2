<?php

namespace App\Http\Controllers\Backend;

use App\Models\Warehouse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        echo 'hello';
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Warehouse $warehouse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warehouse $warehouse)
    {
        //
    }
}
