<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Models\Address;
use App\Models\Province;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index(){
        $user = Auth::user();
        return view('profile.index',compact('user'));
    }

    public function update(Request $request, User $user){
        $request->validate([
            'name' => ['required','string'],
            'email' => ['required','email','unique:users,email,'.$user->id]
        ]);

        $user->update([
            'name' => $request->name,
            'email' =>$request->email
        ]);

        return redirect()->route('profile.index')->with('success','اطلاعات کاربر با موفقیت ویرایش شد');
    }

    public function addresses(){
        $addresses=Auth::user()->addresses;
        return view('profile.address.index',compact('addresses'));    
    }

    public function addresscreate(){
        $user = Auth::user();
        $cities = City::all();
        $provinces= Province::all();
        return view('profile.address.create',compact('user','provinces','cities'));
    }
    
    public function addressstore(Request $request){
        $request->validate([
            'title' => ['required','string'],
            'phone' => ['required','regex:/^09[1|2|3][0-9]{8}$/'],
            'postal_code' => ['required','regex:/^\d{5}[ -]?\d{5}$/'],
            'province_id' => ['required','integer'],
            'city_id' => ['required','integer'],
            'address' => ['required','string']
        ]);

        Address::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'phone' => $request->phone,
            'postal_code' => $request->postal_code,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
            'address' => $request->address
        ]);

        return redirect()->route('profile.address')->with('success','آدرس جدید با موفقیت ایجاد شد');
    }

    public function addressedit(Address $address){
        $provinces = Province::all();
        $cities = City::all();
        return view('profile.address.edit',compact('address','provinces','cities'));
    }

    public function addressupdate(Address $address, Request $request){
        $request->validate([
            'title' => ['required','string'],
            'phone' => ['required','regex:/^09[1|2|3][0-9]{8}$/'],
            'postal_code' => ['required','regex:/^\d{5}[ -]?\d{5}$/'],
            'province_id' => ['required','integer'],
            'city_id' => ['required','integer'],
            'address' => ['required','string']
        ]);

        $address->update([
            'title' => $request->title,
            'phone' => $request->phone,
            'postal_code' => $request->postal_code,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
            'address' => $request->address
        ]);
        return redirect()->route('profile.address')->with('success','آدرس  با موفقیت ویرایش  شد');
    }

    public function addToWishlist(Request $request){
        $request->validate([
            'product_id' => ['required','integer','exists:products,id']
        ]);

        $wish=Wishlist::where('user_id',Auth::id())->where('product_id',$request->product_id)->first();

        if($wish){
            return redirect()->back()->with('error','محصول در علاقه مندی ها وجود دارد');
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id'=>$request->product_id
        ]);


        return redirect()->back()->with('success','محصول با موفقیت به علاقه مندی ها اضافه شد');
    }

    public function wishlist(){
        $wishlist=Auth::user()->wishlist;
        return view('profile.wishlist',compact('wishlist'));
    }

    public function removeFromWishlist(Request $request){
        $request->validate([
            'wishlist' => ['required','integer','exists:wishlists,id']
        ]);
        
        $wishlist = Wishlist::findorfail($request->wishlist);
        $wishlist->delete();
        return redirect()->back()->with('success','محصول با موفقیت از علاقه مندی ها حذف شد');
    }
}
