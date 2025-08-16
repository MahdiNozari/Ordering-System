<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OrderController;
use App\Models\Transaction;

class PaymentController extends Controller
{

    public function send(Request $request){
        
        $request->validate([
            'address_id' => ['required','integer','exists:addresses,id'],
            'coupon_code' => ['nullable','string']
        ]);

        if(!$request->session()->get('cart')){
            return redirect()->route('cart.index')->with('error','سبد خرید شما خالی است');
        }

        $cart = $request->session()->get('cart');

        $totalprice = 0;

        foreach($cart as $key => $item){
            $product = Product::findorfail($key);

            if($product->quantity < $item['qty']){
                return redirect()->route('cart.index')->with('error','موجودی انبار کافی نیست');
            }

            $totalprice += $product->is_sale ? ($product->sale_price * $item['qty']) : ($product->price * $item['qty']);
        }

        $coupon = null;
        $couponprice = 0;
        
        if($request->coupon_code){
            $coupon = Coupon::where('code',$request->coupon_code)->where('expired_at','>',Carbon::now())->first();

            if($coupon == null){ 
                return redirect()->route('cart.index')->withErrors(['code'=>'کد تخفیف وارد شده وجود ندارد']);
            }

            if(Order::where('user_id',Auth::id())->where('coupon_id',$coupon->id)->where('status',1)->exists()){
                dd(Order::where('user_id',Auth::id())->where('coupon_id',$coupon->id)->where('status',1)->exists());
                return redirect()->route('cart.index')->withErrors(['code'=>'کد تخفیف وارد شده قبلا استفاده شده']);
            }

            $couponprice = ($totalprice * $coupon->percentage)/100;
        }

        $payingprice = $totalprice - $couponprice;
        
        $amounts=[
            'total_amount' => $totalprice,
            'coupon_amount' => $couponprice,
            'paying_amount' => $payingprice,
        ];

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://sandbox.zarinpal.com/pg/v4/payment/request.json',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>json_encode([
            "merchant_id" => "b39cffcf-d98f-4279-b1a2-732476226769",
            "amount"=> $amounts['paying_amount'] . 0,
            "callback_url" => "http://localhost:8000/payments/verify",
            "description" => "Transaction description.",
            "metadata" => [
                "mobile"=> Auth::user()->phone,
                "email"=> Auth::user()->email
            ]
        ]),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Accept: application/json'
        ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);  

        $response = json_decode($response, true); 

        if($response['data'] != null){
            OrderController::CreateOrder($cart,$request->address_id,$coupon,$amounts,$response["data"]["authority"]);
            return redirect('https://sandbox.zarinpal.com/pg/StartPay/' . $response["data"]["authority"]);
        }else{

            return redirect()->route('cart.index')->with('error','تراکنش با خطا مواجه شد');
        }
        

    }

    public function verify(Request $request){
        $request->validate([
            'Authority' => ['required','string'],
            'Status' => ['required','string','min:2','max:3']
        ]);

        $orderid=Transaction::where('token',$request->Authority)->first()->order_id;
        $amount=Order::find($orderid)->paying_amount;

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://sandbox.zarinpal.com/pg/v4/payment/verify.json',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode([
            "merchant_id" => "b39cffcf-d98f-4279-b1a2-732476226769",
            "amount"=> $amount . 0,
            "authority" => $request->Authority
        ]),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Accept: application/json'
        ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        
        $response = json_decode($response, true);
    
        if(isset($response['data'])){
            if($response['data']['message'] == 'Paid'){
                OrderController::UpdateOrder($request->Authority,$response['data']['ref_id']);
                request()->session()->put('cart',[]);
                request()->session()->put('coupon',[]);
                return redirect()->route('payments.status',['status' => 1, 'ref_id' => $response['data']['ref_id']])->with('success','تراکنش با موفقیت انجام شد');
            }elseif($response['data']['message'] == 'Verified'){
                return redirect()->route('payments.status',['status' => 1, 'ref_id' => $response['data']['ref_id']])->with('success','تراکنش با موفقیت انجام شد');
            }
            else{
                return redirect()->route('payments.status',['status' => 0])->with('error','تراکنش با خطا مواجه شد');
            }
        }else{
            return redirect()->route('payments.status',['status' => 0])->with('error','تراکنش با خطا مواجه شد');
        }
    }

    public function status(Request $request){
        $request->validate([
            'status' =>['required'],
            'ref_id' =>['nullable']
        ]);

        $status = $request->status;
        $ref_id = $request->ref_id;
        return view('payment.status',compact('status','ref_id'));
    }
}
