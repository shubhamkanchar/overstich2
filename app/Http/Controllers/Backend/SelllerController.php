<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SellersDataTable;
use App\Http\Controllers\Controller;
use App\Models\SellerInfo;
use App\Models\SellerInfoImage;
use App\Models\User;
use Illuminate\Http\Request;
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
            notify()->success('Seller approved');
        }else{
            notify()->success('Something went wrong');
        }
        return redirect()->back();
    }

    public function reject(Request $request){
        $seller = SellerInfo::where('seller_id',$request->id)->update([
            'is_approved'=>0
        ]);

        if($seller){
            notify()->success('Seller rejected');
        }else{
            notify()->success('Something went wrong');
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
            notify()->success('Seller deleted');
        }else{
            notify()->success('Something went wrong');
        }
        return redirect()->back();
    }

    public function view(Request $request){
        $user = user::where('id',$request->id)->first();
        $sellerInfo = SellerInfo::where('seller_id',$request->id)->first();
        $sellerImage = SellerInfoImage::where('seller_id',$request->id)->get();
        return view('backend.admin.seller.view',compact('user','sellerInfo','sellerImage'));
    }
}
