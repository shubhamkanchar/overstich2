<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Address;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderPlatformFee;
use App\Models\ProductSize;
use App\Models\User;
use App\Models\UserCoupon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use Cart;

use App\Services\PhonePePaymentGateWay;
use Exception;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    protected $phonePePaymentGateway;

    public function __construct(PhonePePaymentGateWay $phonePePaymentGateway)
    {
        $this->phonePePaymentGateway = $phonePePaymentGateway;
    }

    public function index(Request $request) {
        $user = auth()->user();
        $userIdentifier = $user->name.$user->id;
        Cart::instance($userIdentifier)->restore($userIdentifier);
        $cartItems = Cart::instance($userIdentifier)->content();

        foreach($cartItems as $item) {
            $rowId = $item->rowId;
            $availableQuantity = ProductSize::where(['product_id' => $item->options?->product_id, 'size' => $item->options?->size ])->first()->quantity;
            if($item->qty > $availableQuantity) {
                Cart::instance($userIdentifier)->update($rowId, $availableQuantity);
            }
            Cart::store($userIdentifier);
        }

        $totalOriginalPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->options?->original_price * $cartItem->qty;
        });
        
        $totalStrikedPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->options?->striked_price * $cartItem->qty;
        });
    
        $totalPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->price * $cartItem->qty;
        });
    
        $totalDiscount = $cartItems->sum(function ($cartItem) {
            return $cartItem->options->discount * $cartItem->qty;
        });

        $totalAmountPerSeller = $cartItems->groupBy('options.seller_id')->map(function ($items) {
            return $items->sum(function ($cartItem) {
                return $cartItem->price * $cartItem->qty;
            });
        });
        
        $sellerIds = $totalAmountPerSeller->keys()->all();

        $appliedCoupons = Coupon::whereHas('userCoupon', function($query) use ($user) {
            $query->where('user_id', $user->id);
            $query->where('is_used', 0);
            $query->where('is_applied', 1);
        })
        ->with(['brand', 'userCoupon'])
        ->whereIn('seller_id', $sellerIds)
        ->get();

        $totalCouponDiscounts = 0;
        foreach($appliedCoupons as $aCoupon) {
            if($aCoupon->type == 'fixed') {
                $totalCouponDiscounts += $aCoupon->value;
            } else {
                $AmountPerSeller = $totalAmountPerSeller[$aCoupon->seller_id];
                $percentage = $aCoupon->value;
                $result = ($percentage / 100) * $AmountPerSeller;
                $totalCouponDiscounts += $result;
            }
        }
        
        $deliveryCharge = 0;
        $totalPrice = $totalPrice + env('PLATFORM_FEE') - $totalCouponDiscounts ;
        if(isset($request->address)){
            $address = Address::where(['user_id' => $user->id])->where('id', $request->address)->first();
        } else {
            $address = Address::where(['user_id' => $user->id])->where('default', 1)->first();
        }

        if (Cart::instance($userIdentifier)->count() === 0) {
            // notify()->error('Your Cart is Empty');
            request()->session()->put('msg', 'Your Cart is Empty');
            return  redirect()->route('cart.index');
        }
        return view('frontend.order.checkout', compact('cartItems', 'totalPrice', 'totalDiscount', 'totalOriginalPrice', 'totalStrikedPrice','deliveryCharge', 'appliedCoupons', 'address', 'totalCouponDiscounts'));
    }

    public function myOrders(Request $request) {
        $query = Order::where(['user_id' => auth()->id(), 'is_order_confirmed' => 1])
            ->with(['seller', 'seller.sellerInfo', 'orderItem', 'orderItem.product', 'orderItem.product.images']);

        $status = $request->status ?? [];
        if ($status) {
            $query->whereIn('status', $status);
        }

        $date = $request->date ?? [];
        if ($date) {
            $query->where(function ($q) use ($date) {
                $q->whereIn(\DB::raw('YEAR(created_at)'), $date);
                if (in_array('older', $date)) {
                    $q->orWhere('created_at', '<', now()->subYears(5));
                }
            });
        }
    
        // Apply search filter by product name
        $search = $request->search ?? '';
        if ($search) {
            $query->whereHas('orderItem', function ($subquery) use ($search) {
                $subquery->where('name', 'like', '%' . $search . '%');
            });
        }

        $orders = $query->orderBy('updated_at', 'desc')->paginate(5);
        $links= $orders->links();
        $orders = $orders->groupBy('batch');
        $statusDescriptions = [
            'new' => 'Your order is new and awaiting processing.',
            'processed' => 'Your order is currently being processed.',
            'processing' => 'Your order is currently being processing.',
            'delivered' => 'Your order has been successfully delivered.',
            'cancelled' => 'Your order has been cancelled.',
            'returned' => 'Your order has been returned.',
            'rejected' => 'Your order has been rejected due reason -',
        ];

        return view('frontend.order.my-orders', compact('orders', 'statusDescriptions', 'date', 'status', 'search', 'links'));
    }

    public function placeOrder(OrderRequest $request)
    {

        $user = auth()->user();
        $userIdentifier = $user->name.$user->id;
    
        Cart::instance($userIdentifier)->restore($userIdentifier);
        $cartItems = Cart::instance($userIdentifier)->content();
        $sellerIds = $cartItems->pluck('options.seller_id')->unique()->all();

        // Calculate total amount per seller
        $totalAmountPerSeller = $cartItems->groupBy('options.seller_id')->map(function ($items) {
            return $items->sum(function ($cartItem) {
                return $cartItem->price * $cartItem->qty;
            });
        });

        // Get the count of items per seller
        $itemCountPerSeller = $cartItems->groupBy('options.seller_id')->map(function ($items) {
            return $items->count();
        });

        $sellerIds = $totalAmountPerSeller->keys()->all();
        // Get applied coupons per seller
        $appliedCoupons = Coupon::whereHas('userCoupon', function($query) use ($user) {
                $query->where('user_id', $user->id);
                $query->where('is_used', 0);
                $query->where('is_applied', 1);
            })
            ->with(['brand', 'userCoupon'])
            ->whereIn('seller_id', $sellerIds)
            ->get();

        $totalCouponDiscounts = 0;
        // Calculate coupon discount per item for each seller
        $couponDiscountPerItemPerSeller = [];
        $couponIds = [];
        foreach ($appliedCoupons as $aCoupon) {
            $sellerId = $aCoupon->seller_id;
            $couponIds[$aCoupon->seller_id] = $aCoupon->id;
            if (!isset($couponDiscountPerItemPerSeller[$sellerId])) {
                $couponDiscountPerItemPerSeller[$sellerId] = 0;
            }

            $itemCount = $itemCountPerSeller[$sellerId] ?? 0;

            if ($itemCount > 0) {

                if ($aCoupon->type == 'fixed') {
                    $couponDiscountPerItemPerSeller[$sellerId] += $aCoupon->value / $itemCount;
                    $totalCouponDiscounts = $aCoupon->value;
                } else {
                    $amountPerSeller = $totalAmountPerSeller[$sellerId] ?? 0;
                    $percentage = $aCoupon->value;
                    $result = ($percentage / 100) * $amountPerSeller;
                    $couponDiscountPerItemPerSeller[$sellerId] += $result / $itemCount;
                    $totalCouponDiscounts = $result;
                }
            }
        }

        // Now $couponDiscountPerItemPerSeller contains the coupon discount per item for each seller

        $transactionId = 'MT'. strtotime('now') . '' . auth()->id() ?? '';
        $deliveryCharges = 0;

        $batch = 1;
        $lastOrder = Order::where('user_id', $user->id)->orderBy('batch', 'desc')->first();

        if($lastOrder && $lastOrder->batch) {
            $batch =  ($lastOrder->batch) + 1;
        }

        $id = 1;

        foreach($cartItems as $cartItem) {
            $totalOriginalPrice =  $cartItem->options->original_price * $cartItem->qty;
            $totalPrice = $cartItem->price * $cartItem->qty;
            $totalStrikedPrice = $cartItem->price * $cartItem->qty;
            $totalTaxableAmount = $cartItem->options?->taxable_amount * $cartItem->qty;
            $totalSgstAmount = $cartItem->options?->sgst_amount * $cartItem->qty;
            $totalCgstAmount = $cartItem->options?->cgst_amount * $cartItem->qty;
            $totalDiscount = $cartItem->options->discount * $cartItem->qty;
            $couponDiscount = 0;
            $couponId = 0;
            if(isset($couponDiscountPerItemPerSeller[$cartItem->options?->seller_id]) && isset($couponIds[$cartItem->options?->seller_id])) {
                $couponDiscount = $couponDiscountPerItemPerSeller[$cartItem->options?->seller_id];
                $totalDiscount += $couponDiscount;
                $totalPrice -= $couponDiscount;
                $couponId = $couponIds[$cartItem->options?->seller_id];
            }

            $order = new Order();
            $order->first_name = $request->first_name;
            $order->last_name = $request->last_name;
            $order->user_id = auth()->id();
            $order->seller_id = $cartItem->options?->seller_id;
            $order->product_id = $cartItem->options?->product_id;
            $order->return = $cartItem->options?->return;
            $order->replace = $cartItem->options?->replace;
            $order->email = $request->email;
            $order->batch = $batch;
            $order->phone = $request->mobile;
            $order->address = $request->address;
            $order->locality = $request->locality;
            $order->pincode = $request->pincode;
            $order->city = $request->city;
            $order->state = $request->state;
            $order->country = 'india';
            $order->order_number = 'OI'.strtotime('now') . $id . $user->id ?? '';
            $order->payment_method = $request->payment_method;
            $order->payment_transaction_id = $transactionId;
            $order->is_order_confirmed = $request->payment_method == 'cod' ? 1 : 0;
            $order->total_amount =  $totalPrice > 2300 ? $totalPrice + env('PLATFORM_FEE')  : $totalPrice + $deliveryCharges + env('PLATFORM_FEE');// final price
            $order->delivery_charge = $deliveryCharges;
            $order->sub_total = $totalOriginalPrice; //gross amount
            $order->total_sgst_amount = $totalSgstAmount;
            $order->total_cgst_amount = $totalCgstAmount;
            $order->total_taxable_amount = $totalTaxableAmount;
            $order->total_striked_price = $totalStrikedPrice;
            $order->status = 'NEW';
            $order->total_discount = $totalDiscount;
            $order->platform_fee = env('PLATFORM_FEE');
            $order->coupon_discount = $couponDiscount;
            $order->coupon_id = $couponId;
            $order->save();
            $id++;

            $orderItem = new OrderItem();
            $orderItem->saveFromCart($cartItem, $order->id);

            if($order->is_order_confirmed == 1) {
                $productSize = new ProductSize();
                $productSize->updateQuantity($orderItem);

                $paymentData = [
                    'batch' => $order->batch,
                    'user_id' => $order->user_id,
                    'order_id' => $order->id,
                    'transaction_id' => $order->payment_transaction_id,
                    'amount' => $order->total_amount,
                    'status' => 'unpaid',
                    'phone_status' => Null, 
                    'phone_response' => Null, 
                ];
                
                $payment = $this->phonePePaymentGateway->store($paymentData);
            }
        }

        $platformFee = env('PLATFORM_FEE');
        $platformGST = env('PLATFORM_FEE_GST');
        $taxAmount = ($platformGST/100) * $platformFee;
        $gstAmount = $taxAmount/2;

        $orderPlatformFee = new OrderPlatformFee();

        $orderPlatformFee->batch = $batch;
        $orderPlatformFee->order_number = 'OI'.strtotime('now') . $id . $user->id ?? '';
        $orderPlatformFee->user_id = $user->id;
        $orderPlatformFee->payment_transaction_id = $transactionId;
        $orderPlatformFee->payment_method = $request->payment_method;
        $orderPlatformFee->is_order_confirmed = $request->payment_method == 'cod' ? 1 : 0;
        $orderPlatformFee->amount = $platformFee;
        $orderPlatformFee->taxable_amount = $platformFee - $taxAmount;
        $orderPlatformFee->gst_percent = $platformGST;
        $orderPlatformFee->gst_amount = $gstAmount;
        $orderPlatformFee->invoice_number = '#'.strtotime('now') . $order->user_id;
        $orderPlatformFee->invoice_generated_at = now();

        $orderPlatformFee->save();

        if(isset($request->save_address) && $request->save_address == 1) {
            $this->saveDeliveryAddress($request, $user);
        }
        
        if($request->payment_method == 'phone_pe') {

            $cartTotalPrice = $cartItems->sum(function ($cartItem) {
                return $cartItem->price * $cartItem->qty;
            });

            $data = [
                'amount' => (($cartTotalPrice + $deliveryCharges) + env('PLATFORM_FEE') - $totalCouponDiscounts) *  100,
                'transactionId' => $transactionId,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'merchantUserId' => $userIdentifier,
            ];

            $response = $this->phonePePaymentGateway->pay($data);
            return redirect()->to($response->data->instrumentResponse->redirectInfo->url);
        }

        UserCoupon::whereIn('coupon_id', $couponIds)->where('user_id', $user->id)->update(['is_used' => 1]);
        Cart::instance($userIdentifier)->destroy();
        Cart::store($userIdentifier); 
        // notify()->success("Order placed successfully");
        return redirect()->route('success-page');  
    }

    public function saveDeliveryAddress($request, $user) {

        if($request->default_address){
            Address::where('user_id', $user->id)->update(['default' => 0]);
        }

        $address = Address::create([
            'address' => $request->address,
            'pincode' => $request->pincode,
            'state' => $request->state,
            'locality' => $request->locality,
            'city' => $request->city,
            'user_id' => $user->id,
            'default' => $request->default_address ?? 0,
            'phone' => $request->mobile,
        ]);

        return $address;
    }

    public function paymentResponse(Request $request) {

        Log::channel('daily')->info('Request Headers', ['headers' => $request->headers->all()]);
        $transactionId = $request->transactionId;
        if($request->code == 'PAYMENT_SUCCESS') {
            Order::where('payment_transaction_id', $transactionId)->update(['is_order_confirmed' => 1]);
            OrderPlatformFee::where('payment_transaction_id', $transactionId)->update(['is_order_confirmed' => 1]);
            // function to update all product quantity seller wise from above order we are getting one order only we can have multiple order at time.
            $orders = Order::where('payment_transaction_id', $transactionId)->get();
            foreach($orders as $order) {
                // foreach ($order->orderItem as $item) {
                    $productSize = new ProductSize();
                    $productSize->updateQuantity($order->orderItem);
                // }
                
                UserCoupon::where('coupon_id', $order->coupon_id)->where('user_id', $order->id)->update(['is_used' => 1]);
                $paymentData = [
                    'batch' => $order->batch,
                    'user_id' => $order->user_id,
                    'order_id' => $order->id,
                    'transaction_id' => $order->payment_transaction_id,
                    'amount' => $order->total_amount,
                    'status' => 'paid', 
                    'phone_status' => 'Success', 
                    'phone_response' => NULL, 
                ];

                try {
                    $response = $this->phonePePaymentGateway->getStatus($transactionId);
                    $paymentData['phone_response'] = json_encode($response);
                } catch (\Throwable $th) {
                    Log::channel('daily')->info('Error', ['phone-pay' => $th]);
                }

                $payment = $this->phonePePaymentGateway->store($paymentData);
            }

            $user = User::where('id', $order->user_id)->first();
            $userIdentifier = $user->name.$user->id;
            \Cart::instance($userIdentifier)->destroy();
            \Cart::store($userIdentifier);

            // notify()->success("Order placed successfully");
            request()->session()->put('msg', 'Order placed');
            return redirect()->route('success-page');//
        } else if($request->code == 'PAYMENT_ERROR') {   
            try {
                $order = Order::where('payment_transaction_id', $transactionId)->delete();
            } catch (\Throwable $th) {
                Log::channel('daily')->info($th);
            }
            // notify()->success("Payment Failed");
            request()->session()->put('msg', 'Payment Failed');
            return redirect()->route('error-page');
        } 
    }

    public function paymentCallback(Request $request) {

        Log::channel('daily')->info('Request Headers', ['headers' => $request->headers->all()]);
        $transactionId = $request->transactionId;

        if($request->code == 'PAYMENT_SUCCESS') {
            Order::where('payment_transaction_id', $transactionId)->update(['is_order_confirmed' => 1]);
            OrderPlatformFee::where('payment_transaction_id', $transactionId)->update(['is_order_confirmed' => 1]);
            $orders = Order::where('payment_transaction_id', $transactionId)->get();

            foreach($orders as $order) {
                // foreach ($order->orderItem as $item) {
                    $productSize = new ProductSize();
                    $productSize->updateQuantity($order->orderItem);
                // }
                UserCoupon::where('coupon_id', $order->coupon_id)->where('user_id', $order->id)->update(['is_used' => 1]);
                
                $paymentData = [
                    'batch' => $order->batch,
                    'user_id' => $order->user_id,
                    'order_id' => $order->id,
                    'transaction_id' => $order->payment_transaction_id,
                    'amount' => $order->total_amount,
                    'status' => 'paid', 
                    'phone_status' => 'Success', 
                    'phone_response' => NULL, 
                ];

                try {
                    $response = $this->phonePePaymentGateway->getStatus($transactionId);
                    $paymentData['phone_response'] = json_encode($response);
                } catch (\Throwable $th) {
                    Log::channel('daily')->info('Error', ['phone-pay' => $th]);
                }
                $payment = $this->phonePePaymentGateway->store($paymentData);
            }

            $user = User::where('id', $order->user_id)->first();
            $userIdentifier = $user->name.$user->id;
            \Cart::instance($userIdentifier)->destroy();
            \Cart::store($userIdentifier);

        } else if($request->code == 'PAYMENT_ERROR') {
            try {
                $order = Order::where('payment_transaction_id', $transactionId)->delete();
            } catch (\Throwable $th) {
                Log::channel('daily')->info($th);
            }
        }

        return response('Succeeded', 200);
    }

    public function downloadInvoice($id) {
        try {
            $batchOrders = Order::where(['user_id' => auth()->id(), 'is_order_confirmed' => 1, 'batch' => $id])
            ->whereNotNull('invoice_number')
            ->whereNotIn('status', ['cancelled','returned','rejected','refund-initializing','refund-initialized','refunded'])
            ->get();
            $orderPlatformFee = OrderPlatformFee::where(['user_id' => auth()->id(), 'is_order_confirmed' => 1, 'batch' => $id])->first();
            $pdf = Pdf::loadView('frontend.order.invoice', compact('batchOrders', 'orderPlatformFee'));
            return $pdf->download($orderPlatformFee->order_number.'.pdf');
        } catch(Exception $e) {
            request()->session()->put('msg', 'Something Went wrong');
            return redirect()->back();
        }
    }
}
