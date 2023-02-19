<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $coupons = Coupon::latest()->get();

        return view('dashboard.coupon.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $coupon = null;

        return view('dashboard.coupon.form', compact('coupon'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCouponRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCouponRequest $request)
    {
        $coupon = new Coupon();
        $coupon->fill($request->all());
        $coupon->save();

        return redirect('/coupons')->with('success', trans('dashboard.added_successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\View\View
     */
    public function show(Coupon $coupon)
    {
        return view('dashboard.coupon.show', compact('coupon'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\View\View
     */
    public function edit(Coupon $coupon)
    {
        return view('dashboard.coupon.form', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCouponRequest  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {
        $coupon->fill($request->except('car_sizes_ids'));
        $coupon->save();

        return redirect('/coupons')->with('success', trans('dashboard.update_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->back()->with('success', trans('dashboard.deleted_successfully'));
    }
}
