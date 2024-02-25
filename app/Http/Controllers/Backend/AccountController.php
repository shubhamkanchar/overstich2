<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SellerInfoImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function sellerAccount() {
        $user = User::with(['sellerInfo'])->where('id', auth()->id())->first();
        return view('backend.seller.account.index', compact('user'));
    }

    public function userAccount() {
        $user = User::with(['sellerInfo'])->where('id', auth()->id())->first();
        return view('frontend.user.account.index', compact('user'));
    }

    public function deactivate() {
        $user = auth()->user();
        $user->is_active = 0;
        Product::where('seller_id', $user->id)->update(['status' => 'inactive']);
        $user->save();
        return response()->json(['message' => 'Account Deactivated'], 200);
    } 

    public function activate() {
        $user = auth()->user();
        $user->is_active = 1;
        Product::where('seller_id', $user->id)->update(['status' => 'active']);
        $user->save();
    }

    public function updateBrandInfo(Request $request) {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'locality' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'pincode' => 'required|string|max:10', 
        ]);
    
        // Update user's basic information
        $user = auth()->user();
        $user->name = $request->name;
        $user->save();
    
        // Update or create seller info
        $sellerInfo = $user->sellerInfo;
        $sellerInfo->brand = $request->brand;
        $sellerInfo->whatsapp = $request->whatsapp;
        $sellerInfo->organization_name = $request->organization_name;
        $sellerInfo->owner_name = $request->name;
        $sellerInfo->owner_contact = $request->owner_contact;
        $sellerInfo->address = $request->address;
        $sellerInfo->locality = $request->locality;
        $sellerInfo->city = $request->city;
        $sellerInfo->state = $request->state;
        $sellerInfo->pincode = $request->pincode;
        $sellerInfo->save();
    
        return redirect()->back()->with('success', 'Profile updated successfully.');    
    }

    public function updateProfile(Request $request)
    {
        // Validate the request for updating profile
        request()->session()->put('tab', 'basic');
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update the user's profile
        $user = auth()->user();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->save();
        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        request()->session()->put('tab', 'password');
        // Validate the request for updating password
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|different:current_password',
            'confirm_password' => 'required|string|same:new_password',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update the user's password
        $user = auth()->user();
        if (!password_verify($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }
        $user->password =  Hash::make($request->new_password);
        $user->save();
        return redirect()->back()->with('success', 'Password updated successfully.');
    }

    public function passwordVerification(Request $request)
    {
        $current_password = auth()->User()->password; 
        $old_password = $request->current_password; 
        if (Hash::check($old_password, $current_password)) {
            return 'true'; 
        } else {
            return 'false'; 
        }
    }

    public function updateProductDetails(Request $request){

        $user = Auth::user();
        $sellerInfo = $user->sellerInfo;
        $sellerInfo->category = $request->category;
        $sellerInfo->products = $request->product;
        $sellerInfo->price_range = $request->price_range;
        $sellerInfo->is_completed = 1;
        $sellerInfo->save();

        foreach ($request->file('product_photos') as $file) {
            $fileName = $request->brand . '_' . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path() .'/image/seller', $fileName);
            SellerInfoImage::create([
                'seller_id' => $user->id,
                'file' => $fileName
            ]);
        }

        return redirect()->back()->with('success', 'Profile updated successfully.');  
    }
}
