<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CouponDataTable;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Cart;

class CouponController extends Controller
{
    public function index(CouponDataTable $datatable)
    {
        return $datatable->render('backend.admin.coupon.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.admin.coupon.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request,[
            'code'=>'string|required',
            'type'=>'required|in:fixed,percent',
            'value'=>'required|numeric',
            'status'=>'required|in:active,inactive'
        ]);
        $data=$request->all();
        $status=Coupon::create($data);
        if($status){
            notify('success','Coupon Successfully added');
        }
        else{
            notify('error','Please try again!!');
        }
        return redirect()->route('coupon.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon=Coupon::find($id);
        if($coupon){
            return view('backend.admin.coupon.edit')->with('coupon',$coupon);
        }
        else{
            return view('backend.admin.coupon.index')->with('error','Coupon not found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $coupon = Coupon::find($id);

        $this->validate($request,[
            'code'=>'string|required',
            'type'=>'required|in:fixed,percent',
            'value'=>'required|numeric',
            'status'=>'required|in:active,inactive'
        ]);

        $data = $request->all();
        
        $status=$coupon->fill($data)->save();

        if($status){
            notify('success','Coupon Successfully updated');
        }
        else{
            notify('error','Please try again!!');
        }
        return redirect()->route('coupon.index');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coupon= Coupon::find($id);
        if($coupon){
            $status=$coupon->delete();
            if($status){
                return response()->json(['message' => 'Coupon Deleted Successfully'], 200);
            }
            else{
                return response()->json(['message' => 'Something went wrong'], 400);
            }
            return redirect()->route('coupon.index');
        }
        else{
            return response()->json(['message' => 'Coupon not found'], 400);
        }
    }

    public function couponStore(Request $request){
        $coupon= Coupon::where('code', $request->code)->first();
        if(!$coupon){
            notify('error','Invalid coupon code, Please try again');
            return back();
        }
        if($coupon){
            $total_price= Cart::where('user_id',auth()->user()->id)->where('order_id',null)->sum('price');
            session()->put('coupon',[
                'id'=>$coupon->id,
                'code'=>$coupon->code,
                'value'=>$coupon->discount($total_price)
            ]);
            notify('success','Coupon successfully applied');
            return redirect()->back();
        }
    }
}
