<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Http\Request;


class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = Coupon::all();
        return view('coupon.index',compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => ['required','unique:coupons,code'],
            'percentage' => ['required','integer'],
            'expired_at'=>['required','date_format:Y/m/d H:i:s']
        ]);

        Coupon::create([
            'code' => $request->code,
            'percentage' => $request->percentage,
            'expired_at' => Verta::parse($request->expired_at)->formatgregorian('Y-n-j H:i')
        ]);
        return redirect()->route('coupons.index')->with('success','کد تخفیف با موفقیت ایجاد شد');
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        return view('coupon.edit',compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code' => ['required','unique:coupons,code,'. $coupon->id],
            'percentage' => ['required','integer'],
            'expired_at'=>['required','date_format:Y/m/d H:i:s']
        ]);

        $coupon->update([
            'code' => $request->code,
            'percentage' => $request->percentage,
            'expired_at' => Verta::parse($request->expired_at)->formatgregorian('Y-n-j H:i')
        ]);
        return redirect()->route('coupons.index')->with('success','کد تخفیف با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('coupons.index')->with('success','کد تخفیف با موفقیت حذف شد');
    }
}
