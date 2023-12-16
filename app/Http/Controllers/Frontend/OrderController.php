<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductSize;
use App\Models\User;
use Illuminate\Http\Request;
use Cart;

use App\Services\PhonePePaymentGateWay;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    protected $phonePePaymentGateway;

    public function __construct(PhonePePaymentGateWay $phonePePaymentGateway)
    {
        $this->phonePePaymentGateway = $phonePePaymentGateway;
    }

    public function index() {
        $user = auth()->user();
        $userIdentifier = $user->name.$user->id;
        Cart::instance($userIdentifier)->restore($userIdentifier);
        $cartItems = Cart::instance($userIdentifier)->content();
        foreach($cartItems as $item) {
            $rowId = $item->rowId;
            $availableQuantity = ProductSize::where(['product_id' => $item->options?->product_id, 'size' => $item->options?->size ])->first()->quantity;
            Cart::instance($userIdentifier)->update($rowId, $availableQuantity);
            Cart::store($userIdentifier);
        }

        $totalOriginalPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->options->original_price * $cartItem->qty;
        });
    
        $totalPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->price * $cartItem->qty;
        });
    
        $totalDiscount = $cartItems->sum(function ($cartItem) {
            return $cartItem->options->discount * $cartItem->qty;
        });

        $deliveryCharge = 0;
        if (Cart::instance($userIdentifier)->count() === 0) {
            notify()->error('Your Cart is Empty');
            return  redirect()->route('cart.index');
        }
        return view('frontend.order.checkout', compact('cartItems', 'totalPrice', 'totalDiscount', 'totalOriginalPrice', 'deliveryCharge'));
    }

    public function myOrders() {
        $orders = Order::where(['user_id' => auth()->id(), 'is_order_confirmed' => 1])->with(['seller', 'seller.sellerInfo', 'orderItem', 'orderItem.product', 'orderItem.product.images'])->get()->groupBy(['batch']);
        $statusDescriptions = [
            'new' => 'Your order is new and awaiting processing.',
            'process' => 'Your order is currently being processed.',
            'delivered' => 'Your order has been successfully delivered.',
            'cancelled' => 'Your order has been cancelled.',
            'returned' => 'Your order has been returned.',
        ];
        return view('frontend.order.my-orders', compact('orders', 'statusDescriptions'));
    }
    public function placeOrder(OrderRequest $request)
    {

        $user = auth()->user();
        $userIdentifier = $user->name.$user->id;
    
        Cart::instance($userIdentifier)->restore($userIdentifier);
        $cartItems = Cart::instance($userIdentifier)->content();

        $productSellers = [];
        foreach($cartItems as $item) {
            $productSellers[$item->options?->seller_id][] = $item;
        }

        $transactionId = 'MT'. strtotime('now') . '' . auth()->id() ?? '';
        $deliveryCharges = 0;

        $batch = 1;
        $lastOrder = Order::where('user_id', $user->id)->orderBy('batch', 'desc')->first();
        if($lastOrder && $lastOrder->batch) {
            $batch =  ($lastOrder->batch) + 1;
        }

        $id = 1;
        foreach($productSellers as $sellerId => $productSellerItems) {

            $itemsCollection = collect($productSellerItems);

            $totalOriginalPrice = $itemsCollection->sum(function ($cartItem) {
                return $cartItem->options->original_price * $cartItem->qty;
            });

            $totalPrice = $itemsCollection->sum(function ($cartItem) {
                return $cartItem->price * $cartItem->qty;
            });

            $totalDiscount = $itemsCollection->sum(function ($cartItem) {
                return $cartItem->options->discount * $cartItem->qty;
            });

            $order = new Order();
            $order->first_name = $request->first_name;
            $order->last_name = $request->last_name;
            $order->user_id = auth()->id();
            $order->seller_id = $sellerId;
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
            $order->payment_transaction_id = $request->payment_method == 'cod' ? $transactionId. $id . $user->id : $transactionId;
            $order->is_order_confirmed = $request->payment_method == 'cod' ? 1 : 0;
            $order->total_amount =  $totalPrice > 2300 ? $totalPrice : $totalPrice + $deliveryCharges;
            $order->delivery_charge = $deliveryCharges;
            $order->sub_total = $totalOriginalPrice;
            $order->status = 'NEW';
            $order->total_discount = $totalDiscount;
            $order->save();
            $id++;
            foreach ($productSellerItems as $cartItem) {
                $orderItem = new OrderItem();
                $orderItem->saveFromCart($cartItem, $order->id);
            }

            if($order->is_order_confirmed == 1) {
                foreach ($order->orderItem as $item) {
                    $productSize = new ProductSize();
                    $productSize->updateQuantity($item);
                }

                $paymentData = [
                    'batch' => $order->batch,
                    'user_id' => $order->user_id,
                    'transaction_id' => $order->payment_transaction_id,
                    'amount' => $order->total_amount,
                    'status' => 'unpaid',
                    'phone_status' => Null, 
                    'phone_response' => Null, 
                ];
                
                $payment = $this->phonePePaymentGateway->store($paymentData);
            }
        }
        
        if($request->payment_method == 'phone_pe') {

            $data = [
                'amount' => ($totalPrice + $deliveryCharges) *  100,
                'transactionId' => $transactionId,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'merchantUserId' => $userIdentifier,
            ];

            $response = $this->phonePePaymentGateway->pay($data);
            return redirect()->to($response->data->instrumentResponse->redirectInfo->url);
        }

        
        Cart::instance($userIdentifier)->destroy();
        Cart::store($userIdentifier); 
        notify()->success("Order placed successfully");
        return redirect()->route('cart.index');
    }

    public function paymentResponse(Request $request) {

        Log::channel('daily')->info('Request Headers', ['headers' => $request->headers->all()]);
        $transactionId = $request->transactionId;

        if($request->code == 'PAYMENT_SUCCESS') {
            Order::where('payment_transaction_id', $transactionId)->update(['is_order_confirmed' => 1]);

            // function to update all product quantity seller wise from above order we are getting one order only we can have multiple order at time.
            $orders = Order::where('payment_transaction_id', $transactionId)->get();
            $id = 1;
            foreach($orders as $order) {
                foreach ($order->orderItem as $item) {
                    $productSize = new ProductSize();
                    $productSize->updateQuantity($item);
                }

                $paymentData = [
                    'batch' => $order->batch,
                    'user_id' => $order->user_id,
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
                $order->payment_transaction_id = $order->payment_transaction_id.$id.$order->user_id;// updating transaction id to get seperate transaction for each order;
                $order->update();
                $payment = $this->phonePePaymentGateway->store($paymentData);
                $id++;
            }

            $user = User::where('id', $order->user_id)->first();
            $userIdentifier = $user->name.$user->id;
            \Cart::instance($userIdentifier)->destroy();
            \Cart::store($userIdentifier);

            notify()->success("Order placed successfully");
        } else if($request->code == 'PAYMENT_SUCCESS') {
            $order = Order::where('payment_transaction_id', $transactionId)->first();
            $order->delete();
            notify()->success("Payment Failed");
        }

        return redirect()->route('cart.index');

    }

    public function paymentCallback(Request $request) {

        Log::channel('daily')->info('Request Headers', ['headers' => $request->headers->all()]);
        $transactionId = $request->transactionId;

        if($request->code == 'PAYMENT_SUCCESS') {
            Order::where('payment_transaction_id', $transactionId)->update(['is_order_confirmed' => 1]);
            $orders = Order::where('payment_transaction_id', $transactionId)->get();
            $id = 1;
            foreach($orders as $order) {
                foreach ($order->orderItem as $item) {
                    $productSize = new ProductSize();
                    $productSize->updateQuantity($item);
                }

                $paymentData = [
                    'batch' => $order->batch,
                    'user_id' => $order->user_id,
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
                $order->payment_transaction_id = $order->payment_transaction_id.$id.$order->user_id;// updating transaction id to get seperate transaction for each order;
                $order->update();
                $payment = $this->phonePePaymentGateway->store($paymentData);
                $id++;
            }

            $user = User::where('id', $order->user_id)->first();
            $userIdentifier = $user->name.$user->id;
            \Cart::instance($userIdentifier)->destroy();
            \Cart::store($userIdentifier);

        } else if($request->code == 'PAYMENT_SUCCESS') {
            $order = Order::where('payment_transaction_id', $transactionId)->first();
            $order->delete();
            notify()->success("Payment Failed");
        }

        return response('Succeeded', 200);
    }
}
