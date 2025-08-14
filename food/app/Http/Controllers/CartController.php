<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(Request $request){

        $cart = $request->session()->get('cart');
        $addresses = Auth::user()->addresses;

        if ($cart == null){
            return view('cart.index',compact('cart'));
        }

        $cart_total_price = 0;
        foreach ($cart as $key=>$item){
            $price = $item['is_sale'] ? $item['sale_price'] : $item['price'];
            $cart_total_price += $price * $item['qty'];
        }

        return view('cart.index',compact('cart','cart_total_price','addresses'));
    }

    public function add(Request $request){
        $request->validate([
            'product_id' => ['required','integer','exists:products,id'],
            'qty' => ['required','integer']
        ]);

        $product = Product::findorfail($request->product_id);

        if($request->qty >= $product->quantity){
                return redirect()->back()->with('error','موجودی انبار کافی نیست');
         }

        $cart = $request->session()->get('cart',[]);
        
        if(isset($cart[$product->id])){

            $cart[$product->id]['qty']=$request->qty; 
        }
        else{
            $cart[$product->id]=[
                'name' => $product->name,
                'quantity' => $product->quantity,
                'is_sale' => $product->is_sale,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'primary_image' => $product->primary_image,
                'qty' => $request->qty
            ];
        }

        $request->session()->put('cart',$cart);

        return redirect()->back()->with('success','محصول با موفقیت به سبد خرید اضافه شد');
    }

    public function increment(Request $request){
        $request->validate([
            'product_id' => ['required','integer','exists:products,id'],
            'qty' => ['required','integer']
        ]);

        $product = Product::findorfail($request->product_id);

        $cart = $request->session()->get('cart',[]);
        
        if(isset($cart[$product->id])){
           if($cart[$product->id]['qty'] >= $product->quantity){
                return redirect()->back()->with('error','موجودی انبار کافی نیست');
            }

            $cart[$product->id]['qty']++; 
        }
        else{
            $cart[$product->id]=[
                'name' => $product->name,
                'quantity' => $product->quantity,
                'is_sale' => $product->is_sale,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'primary_image' => $product->primary_image,
                'qty' => 1
            ];
        }

        $request->session()->put('cart',$cart);

        return redirect()->back()->with('success','محصول با موفقیت به سبد خرید اضافه شد');
    }

    public function decrement(Request $request){
        $request->validate([
            'product_id' => ['required','integer','exists:products,id'],
            'qty' => ['required','integer']
        ]);

        $product = Product::findorfail($request->product_id);

        if($request->qty == 0){
            return redirect()->back()->with('error','تعداد انتخابی کمتر از حد مجاز است');
        }
        

        $cart = $request->session()->get('cart',[]);
        
        if(isset($cart[$product->id])){
          
            $cart[$product->id]=[
                'name' => $product->name,
                'quantity' => $product->quantity,
                'is_sale' => $product->is_sale,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'primary_image' => $product->primary_image,
                'qty' => $cart[$product->id]['qty'] - 1
            ];
           
        }
        

        $request->session()->put('cart',$cart);

        return redirect()->back()->with('success','محصول با موفقیت از سبد خرید کاهش یافت');
    }

    public function remove(Request $request){

        $cart = $request->session()->get('cart');

        if(isset($cart[$request->product_id])){
            unset($cart[$request->product_id]);
        }

        $request->session()->put('cart',$cart);

        return redirect()->back()->with('success','محصول با موفقیت از سبد خرید حذف یافت');
    }

    public function clear(Request $request){
        $request->session()->put('cart',[]);
        return redirect()->route('products.menu')->with('success','سبد خرید شما خالی شد');
    }

    public function checkCoupon(Request $request){
        $request->validate([
            'code' => ['required','string']
        ]);

        $coupon = Coupon::where('code',$request->code)->where('expired_at','>',Carbon::now())->first();

        if($coupon == null){
            return redirect()->route('cart.index')->withErrors(['code' => 'کد تخفیف وارد شده صحیح نیست']);
        }

        $request->session()->put('coupon',['code' => $coupon->code, 'percentage' => $coupon->percentage]);

        return redirect()->route('cart.index');
    }
}
