<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SellerInfo;
use App\Models\SellerInfoImage;
use App\Models\User;
use Exception;
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

    public function updateCancelCheque(Request $request) {
        request()->session()->put('tab', 'gst-account');
        $request->validate([
            'cancel_cheque' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);
        try {
            $user = auth()->user();
            $sellerInfo = $user->sellerInfo;

            if($request->hasFile('replace_cancel_cheque')) {
                $oldImagePath = public_path().'/doc/seller/'.$user->id.'/'.$sellerInfo->cancel_cheque;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }

                $cancelChequeFile = $request->file('replace_cancel_cheque');
                $cancelCheque = $sellerInfo?->brand . '_cancel_cheque_' . rand(1111, 9999) . '.' . $cancelChequeFile->getClientOriginalExtension();
                $cancelChequeFile->move(public_path() .'/doc/seller/'.$user->id, $cancelCheque);
            }

            $sellerInfo->cancel_cheque = $cancelCheque;
            $sellerInfo->update();
            return redirect()->back()->with('success', 'Cancel Cheque Updated');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
            
    }

    public function uploadNocDoc(Request $request) {
        request()->session()->put('tab', 'documents');
        $request->validate([
            'noc_doc' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);
        try {
            $user = auth()->user();
            $sellerInfo = $user->sellerInfo;

            if($request->hasFile('noc_doc')) {
                $oldImagePath = public_path().'/doc/seller/'.$user->id.'/'.$sellerInfo->noc_doc;
                if (!empty($sellerInfo->noc_doc) && file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
                
                $nocDocFile = $request->file('noc_doc');
                $nocDoc = $sellerInfo?->brand . '_noc_document_' . rand(1111, 9999) . '.' . $nocDocFile->getClientOriginalExtension();
                $nocDocFile->move(public_path() .'/doc/seller/'.$user->id, $nocDoc);
            }
        
            $sellerInfo->noc_doc = $nocDoc;
            $sellerInfo->update();
            return redirect()->back()->with('success', 'Noc Document Updated');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function updateGstDoc(Request $request) {
        request()->session()->put('tab', 'gst-account');
        $request->validate([
            'replace_gst_doc' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);
        try {
            $user = auth()->user();
            $sellerInfo = $user->sellerInfo;

            if($request->hasFile('replace_gst_doc')) {
                $oldImagePath = public_path().'/doc/seller/'.$user->id.'/'.$sellerInfo->gst_doc;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                } 

                $gstDocChequeFile = $request->file('replace_gst_doc');
                $gstDocCheque = $sellerInfo?->brand . '_gst_doc_' . rand(1111, 9999) . '.' . $gstDocChequeFile->getClientOriginalExtension();
                $gstDocChequeFile->move(public_path() .'/doc/seller/'.$user->id, $gstDocCheque);
            }
        
            $sellerInfo->gst_doc = $gstDocCheque;
            $sellerInfo->update();
            return redirect()->back()->with('success', 'Gst Document Updated');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
            
    }

    public function uploadSignature(Request $request) {
        request()->session()->put('tab', 'documents');
        $request->validate([
            'authorize_signature' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);
        $image = $request->authorize_signature;
        $user = auth()->user();
        $sellerInfo = SellerInfo::where('seller_id', $user->id)->first();
        try {
            $oldImagePath = public_path($sellerInfo->signature);
            if (!empty($sellerInfo->signature) && file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('image/seller/' . $user->name.'/signature'), $imageName);

            $sellerInfo->signature = 'image/seller/' . $user->name . '/'.'signature/' . $imageName;
            $sellerInfo->update();
            return redirect()->back()->with('success', 'Signature uploaded successfully');
        } catch(Exception $e) {
            request()->session()->put('error','something went wrong please try again');
            return redirect()->back();
        }
    }

    public function updateBrandInfo(Request $request) {
        request()->session()->put('tab', 'basic');
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

    public function updateGstAccount(Request $request) {

        request()->session()->put('tab', 'gst-account');
        try {
            $request->validate([
                'gst' => 'required|string|max:255',
                'gst_address' => 'required|string|max:255',
                'gst_name' => 'required|string|max:255',
                'ifsc' => 'required|string|max:255',
                'account' => 'required|string|max:255',
                'bank_name' => 'required|string|max:255',
                'account_holder_name' => 'required|string|max:255',
                'account_type' => 'required|string|in:Saving,Current',
                'cancel_cheque' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'gst_doc' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);
    
            $user = auth()->user();
            $sellerInfo = $user->sellerInfo;
            
            $sellerInfo->gst = $request->gst;
            $sellerInfo->gst_address = $request->gst_address;
            $sellerInfo->gst_name = $request->gst_name;
            $sellerInfo->ifsc = $request->ifsc;
            $sellerInfo->account = $request->account;
            $sellerInfo->bank_name = $request->bank_name;
            $sellerInfo->account_holder_name = $request->account_holder_name;
            $sellerInfo->account_type = $request->account_type;
        
            if($request->hasFile('cancel_cheque')){
                $cancelChequeFile = $request->file('cancel_cheque');
                $cancelCheque = $sellerInfo?->brand . '_cancel_cheque_' . rand(1111, 9999) . '.' . $cancelChequeFile->getClientOriginalExtension();
                $cancelChequeFile->move(public_path() .'/doc/seller/'.$user->id, $cancelCheque);
                $sellerInfo->cancel_cheque = $cancelCheque;
            }

            if($request->hasFile('gst_doc')){
                $gstDocChequeFile = $request->file('gst_doc');
                $gstDocCheque = $sellerInfo?->brand . '_gst_doc_' . rand(1111, 9999) . '.' . $gstDocChequeFile->getClientOriginalExtension();
                $gstDocChequeFile->move(public_path() .'/doc/seller/'.$user->id, $gstDocCheque);
                $sellerInfo->gst_doc = $gstDocCheque;
            }
        
            $sellerInfo->update();
        
            return redirect()->back()->with('success', 'GST and account details updated successfully.');
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->back()->with('error', 'Something went wrong');
        }
    
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
        request()->session()->put('tab', 'product-info');
        try {
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

            return redirect()->back()->with('success', 'Product Details updated successfully.'); 
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong');
        }
             
    }
}
