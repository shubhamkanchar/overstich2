<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SellerInfo;
use App\Models\SellerInfoImage;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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
        $request->validate([
            'brand' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->brand,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_type' => 'seller',
            ]);
            $user->assignRole('seller');

            if($request->hasFile('gst_doc')){
                $gstFile = $request->file('gst_doc');
                $gstDoc = $request->brand . '_' . rand(1111, 9999) . '.' . $gstFile->getClientOriginalExtension();
                $gstFile->move(public_path() .'/doc/seller/'.$user->id, $gstDoc);
            }

            if($request->hasFile('noc_doc')){
                $nocFile = $request->file('noc_doc');
                $nocDoc = $request->brand . '_' . rand(1111, 9999) . '.' . $nocFile->getClientOriginalExtension();
                $nocFile->move(public_path() .'/doc/seller/'.$user->id, $nocDoc);
            }

            if($request->hasFile('cancel_cheque')){
                $cancelChequeFile = $request->file('cancel_cheque');
                $cancelCheque = $request->brand . '_' . rand(1111, 9999) . '.' . $cancelChequeFile->getClientOriginalExtension();
                $cancelChequeFile->move(public_path() .'/doc/seller/'.$user->id, $cancelCheque);
            }
            $sellerInfo = SellerInfo::create([
                'seller_id' => $user->id,
                'brand' => $request->brand,
                'gst' => $request->gst,
                'whatsapp' => $request->whatsapp,
                'category' => $request->category,
                'products' => $request->product,
                'price_range' => $request->price_range,
                'address' => $request->address_line,
                'locality' => $request->locality,
                'city' => $request->city,
                'state' => $request->state,
                'pincode' => $request->pincode,
                'account' => $request->account,
                'is_approved' => 0,
                'ifsc' => $request->ifsc,
                'gst_doc' => $gstDoc,
                'noc_doc' => $nocDoc,
                'account_holder_name' => $request->account_holder_name,
                'bank_name' => $request->bank_name,
                'account_type' => $request->account_type,
                'owner_name' => $request->owner_name,
                'owner_contact' => $request->owner_contact,
                'organization_name' => $request->organization_name,
                'cancel_cheque' => $cancelCheque
            ]);

            foreach ($request->file('product_photos') as $file) {
                $fileName = $request->brand . '_' . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path() .'/image/seller', $fileName);
                SellerInfoImage::create([
                    'seller_id' => $user->id,
                    'file' => $fileName
                ]);
            }
            notify()->success('Registration successful');
            DB::commit();
        } catch (Exception $e) {
            Log::info($e->getMessage());
            notify()->error('Something went wrong! Please try again');
            DB::rollBack();
        }
        return redirect()->back()->withErrors(['formSubmit'=>1]);
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

    public function homepage(){
        return view('frontend.seller.homepage');
    }
}
