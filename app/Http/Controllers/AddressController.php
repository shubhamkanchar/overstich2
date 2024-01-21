<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addresses = Address::where('user_id',Auth::user()->id)->paginate(6);
        return view('frontend.user.address.index',compact('addresses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('frontend.user.address.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->default_address){
            Address::where('user_id',Auth::user()->id)->update(['default'=>0]);
        }

        $address = Address::create([
            'address' => $request->address,
            'pincode' => $request->pincode,
            'state' => $request->state,
            'locality' => $request->locality,
            'city' => $request->city,
            'user_id' => Auth::user()->id,
            'default' => $request->default_address ?? 0,
        ]);

        if($address){
            notify()->success("Address added successfully");
        }else{
            notify()->error("Something went wrong");
        }
        return redirect()->route('addresses.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $address = Address::where('uuid',$request->address)->firstOrFail();
        return view('frontend.user.address.edit',compact('address'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if($request->default_address){
            Address::where('user_id',Auth::user()->id)->update(['default'=>0]);
        }

        $address = Address::where('uuid',$request->uuid)->update([
            'address' => $request->address,
            'pincode' => $request->pincode,
            'state' => $request->state,
            'locality' => $request->locality,
            'city' => $request->city,
            'default' => $request->default_address ?? 0,
        ]);

        if($address){
            notify()->success("Address updated successfully");
        }else{
            notify()->error("Something went wrong");
        }
        return redirect()->route('addresses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $address = Address::where('uuid',$request->address)->delete();

        if($address){
            notify()->success("Address deleted successfully");
        }else{
            notify()->error("Something went wrong");
        }
        return redirect()->route('addresses.index');
    }
}
