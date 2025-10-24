<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller
{



    public function index()
    {
        $coupons = Coupon::orderBy('id', 'desc')->get();
        return view('backend.coupon.index', compact('coupons'));
    }


    public function create()
    {
        return view('backend.coupon.create');
    }


    public function store(Request $request)
    {


        list($startDateString, $endDateString) = explode(' - ', $request->daterange);

        $coupon = Coupon::where('code', $request->code)->first();
        if (!empty($coupon)) {
            return redirect()->route('admin.coupon.index')->with('error', 'This coupon code already exist!');
        }


        Coupon::create([
            'code' => $request->code,
            'type' => $request->type,
            'discount' => $request->discount,
            'discount_type' => $request->discount_type,
            'start_date' =>  date('Y-m-d', strtotime($startDateString)),
            'end_date' =>  date('Y-m-d', strtotime($endDateString)),

        ]);

        return redirect()->route('admin.coupon.index')->with('success', 'Coupon add successfully!');
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('backend.coupon.edit', compact('coupon'));
    }


    public function update(Request $request, $id)
    {


        list($startDateString, $endDateString) = explode(' - ', $request->daterange);

        $coupon = Coupon::where('code', $request->code)->where('id', '!=', $id)->first();
        if (!empty($coupon)) {
            return redirect()->route('admin.coupon.index')->with('error', 'This coupon code already exist!');
        }


        Coupon::where('id', $id)->update([
            'code' => $request->code,
            'type' => $request->type,
            'discount' => $request->discount,
            'discount_type' => $request->discount_type,
            'start_date' =>  date('Y-m-d', strtotime($startDateString)),
            'end_date' =>  date('Y-m-d', strtotime($endDateString)),

        ]);

        return redirect()->route('admin.coupon.index')->with('success', 'Coupon Update successfully!');
    }

    public function delete($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();
        return back()->with('success', 'Coupon delete Successfully!');
    }
}
