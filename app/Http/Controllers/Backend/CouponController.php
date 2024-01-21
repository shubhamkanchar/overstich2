<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\CouponDataTable;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\UserCoupon;
use Illuminate\Http\Request;
use Cart;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    public function index(CouponDataTable $datatable)
    {
        return $datatable->render('backend.seller.coupon.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.seller.coupon.add');
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
            'code' => 'string|required|unique:coupons',
            'type'=>'required|in:fixed,percent',
            'minimum'=>'numeric',
            'value'=>'required|numeric',
            'status'=>'required|in:active,inactive'
        ]);
        $data = $request->all();
        $data['seller_id'] = auth()->id();
        $status=Coupon::create($data);
        if($status){
            notify('success','Coupon Successfully added');
        }
        else{
            notify('error','Please try again!!');
        }
        return redirect()->back();
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
            return view('backend.seller.coupon.edit')->with('coupon',$coupon);
        }
        else{
            return view('backend.seller.coupon.index')->with('error','Coupon not found');
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
            'type'=>'required|in:fixed,percent',
            'code' => ['string', 'required', Rule::unique('coupons')->ignore($id)],
            'value'=>'required|numeric',
            'minimum'=>'numeric',
            'status'=>'required|in:active,inactive'
        ]);
        
        $data['seller_id'] = auth()->id();
        $data = $request->all();
        
        $status=$coupon->fill($data)->save();

        if($status){
            notify('success','Coupon Successfully updated');
        }
        else{
            notify('error','Please try again!!');
        }
        return redirect()->back();
        
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

    public function applyCoupon(Coupon $coupon, Request $request) {

        $user = auth()->user();   
        $isUsed= UserCoupon::where(['coupon_id' => $coupon->id, 'user_id' => $user->id, 'is_used' => 1 ])->count();
        if($isUsed == 0) {
            $userCoupon = UserCoupon::updateOrInsert(
                ['coupon_id' => $coupon->id, 'user_id' => auth()->id()],
                ['is_applied' => 1, 'is_used' => 0]
            );

            notify('success', 'Coupon Applied');
            return redirect()->back();
        } else {
            notify('error', 'Coupon Already Used');
            return redirect()->back();
        }
        
    }

    public function removeCoupon(Coupon $coupon, Request $request) {
        $user = auth()->user();
        $userCoupon = UserCoupon::where(['coupon_id' => $coupon->id, 'user_id' => $user->id ])->first();
        $userCoupon->is_applied = 0;
        $userCoupon->update();
        notify('success', 'Coupon Removed');
        return redirect()->back();
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
