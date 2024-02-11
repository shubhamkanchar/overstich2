<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\AdsDataTable;
use App\Http\Controllers\Controller;
use App\Models\AdsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdsModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AdsDataTable $datatable)
    {
        return $datatable->render('backend.admin.ads.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.admin.ads.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file'=>'required',
            'link'=>'required',
            'type'=>'required',
            'status'=>'required',
        ]);

        if ($request->hasFile('file')) {
            $banner = $request->file('file');
            if ($banner->isValid()) {
                $bannerName = uniqid() . '.' . $banner->getClientOriginalExtension();
                $banner->move(public_path('image/banner/'), $bannerName);
            }
        }

        $ad = AdsModel::create([
            'link'=>$request->link,
            'location'=>$request->type,
            'status'=>$request->status,
            'file'=>$bannerName,
        ]);

        if($ad){
            request()->session()->put('success','Ads added successfully');
        }else{
            request()->session()->put('error','Something went wrong');
        }
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     */
    public function show(AdsModel $adsModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $adsModel = AdsModel::findOrFail($id);
        return view('backend.admin.ads.edit',compact('adsModel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AdsModel $adsModel)
    {
        $request->validate([
            'link'=>'required',
            'type'=>'required',
            'status'=>'required',
        ]);
        $ads = AdsModel::findOrFail($request->ad);

        $data = [
            'link'=>$request->link,
            'location'=>$request->type,
            'status'=>$request->status,
        ];
        if ($request->hasFile('file')) {
            $banner = $request->file('file');
            if ($banner->isValid()) {
                File::delete(public_path('image/banner/'.$ads->file));
                $bannerName = uniqid() . '.' . $banner->getClientOriginalExtension();
                $banner->move(public_path('image/banner/'), $bannerName);
                $data['file'] = $bannerName;
            }
        }

        $ad = $ads->update($data);

        if($ad){
            request()->session()->put('success','Ads updated successfully');
        }else{
            request()->session()->put('error','Something went wrong');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $ad = AdsModel::findOrFail($request->ad);
        if(File::exists(public_path('image/banner/'.$ad->file))){
            File::delete(public_path('image/banner/'.$ad->file));
        }
        if($ad->delete()){
            // return response()->json([
            //     'status'=>'success',
            //     'message'=>'Ads deleted successfully'
            // ],200);
            request()->session()->put('success','Ads deleted successfully');
        }else{
            // return response()->json([
            //     'status'=>'error',
            //     'message'=>'Something went wrong'
            // ],400);
            request()->session()->put('error','Something went wrong');
        }
        return redirect()->back();
    }
}
