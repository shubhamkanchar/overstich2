<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SellersDataTable;
use App\Http\Controllers\Controller;
use App\Models\SellerInfo;
use App\Models\SellerInfoImage;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SelllerController extends Controller
{
    public function index(SellersDataTable $dataTable)
    {
        return $dataTable->render('backend.admin.seller.index');
    }

    public function dashboard(){
        return view('backend.seller.dashboard');
    }

    public function approve(Request $request){
        $seller = SellerInfo::where('seller_id',$request->id)->update([
            'is_approved'=>1
        ]);

        if($seller){
            request()->session()->put('success','Seller approved');
        }else{
            request()->session()->put('success','Something went wrong');
        }
        return redirect()->back();
    }

    public function reject(Request $request){
        $seller = SellerInfo::where('seller_id',$request->id)->update([
            'is_approved'=>0
        ]);

        if($seller){
            request()->session()->put('success','Seller rejected');
        }else{
            request()->session()->put('success','Something went wrong');
        }
        return redirect()->back();
    }

    public function delete(Request $request){
        $sellerInfo = SellerInfo::where('seller_id',$request->id)->delete();
        $SellerInfoImage = SellerInfoImage::where('seller_id',$request->id)->get();
        foreach($SellerInfoImage as $img){
            if(File::exists(public_path('image/seller/'.$img->file))){
                unlink(public_path('image/seller/'.$img->file));
            }
        }
        $SellerInfoImage = SellerInfoImage::where('seller_id',$request->id)->delete();
        $seller= User::where('id',$request->id)->delete();
        if($seller){
            request()->session()->put('success','Seller deleted');
        }else{
            request()->session()->put('success','Something went wrong');
        }
        return redirect()->back();
    }

    public function view(Request $request){
        $user = user::where('id',$request->id)->first();
        $sellerInfo = SellerInfo::where('seller_id',$request->id)->first();
        $sellerImage = SellerInfoImage::where('seller_id',$request->id)->get();
        return view('backend.admin.seller.view',compact('user','sellerInfo','sellerImage'));
    }

    public function uploadSignature(Request $request) {
        $image = $request->signature;
        $user = auth()->user();
        $sellerInfo = SellerInfo::where('seller_id', $user->id)->first();
        try {
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
}
