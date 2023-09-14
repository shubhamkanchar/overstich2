<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SellerInfo;
use App\Models\SellerInfoImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('frontend.seller.register');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->file('product_photos'));
        $user = User::create([
            'name'=> $request->brand,
            'email' => $request->mail,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('seller');

        $sellerInfo = SellerInfo::create([
            'seller_id'=>$user->id,
            'gst'=>$request->gst,
            'whatsapp'=>$request->whatsapp,
            'category'=>$request->category,
            'products'=>$request->product,
            'price_range'=>$request->price_range,
            'address'=>$request->address_line,
            'locality'=>$request->locality,
            'city'=>$request->city,
            'state'=>$request->state,
            'pincode'=>$request->pincode,
            'account'=>$request->account,
            'is_approved'=>0,
            'ifsc'=>$request->ifsc,
        ]);

        foreach($request->file('product_photos') as $file){
            $fileName = $request->brand.'_'.rand(1111,9999).'.'.$file->getClientOriginalExtension();
            $file->move('image/seller',$fileName);
            SellerInfoImage::create([
                'seller_id'=>$user->id,
                'file'=> $fileName
            ]);
        }
        notify()->success('Registration successful');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
