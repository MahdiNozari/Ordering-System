<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public static function CreateOrder($cart,$addressid,$coupon,$amounts,$token){
        DB::begintransaction();
        
        $order = Order::create([
            'user_id' => Auth::id(),
            'address_id' => $addressid,
            'coupon_id' => $coupon == null ? null : $coupon->id,
            'total_amount' => $amounts['total_amount'],
            'coupon_amount' => $amounts['coupon_amount'],
            'paying_amount' => $amounts['paying_amount'],

        ]);

        foreach($cart as $key=>$item){
            $product = Product::findorfail($key);
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'price' => $product->is_sale ? $product->sale_price : $product->price,
                'quantity' => $item['qty'],
                'subtotal' => $product->is_sale ? $item['qty'] * $product->sale_price : $item['qty'] * $product->price
            ]);
        }

        Transaction::create([
            'user_id' => Auth::id(),
            'order_id' => $order->id,
            'amount' => $amounts['paying_amount'],
            'token' => $token
        ]);

        DB::commit();
    }

    public static function UpdateOrder($token,$refid){
        DB::begintransaction();

        $transaction = Transaction::where('token',$token)->firstorfail();
        $transaction->update([
            'status' => 1,
            'ref_number' => $refid
        ]);

        $order = Order::findorfail($transaction->order_id);
        $order->update([
            'status' => 1,
            'payment_status'=>1
        ]);

        $orderitems = OrderItem::where('order_id',$order->id)->get();
        foreach($orderitems as $item){
            $product = Product::find($item->product_id);
            $product->update([
                'quantity' => ($product->quantity -  $item -> quantity)
            ]);
        }

        DB::commit();
    }
}
