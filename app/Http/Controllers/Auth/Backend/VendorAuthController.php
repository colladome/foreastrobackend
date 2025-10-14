<?php

namespace App\Http\Controllers\Auth\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\VendorService;
use App\Http\Requests\VendorRequest;
use App\Models\Backend\Category;
use App\Models\BookingDate;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;

class VendorAuthController extends Controller
{

    public $vendorService;


    public function __construct()
    {
        $this->vendorService = new VendorService();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $vendors = User::with('userProfile', 'categories')->where('user_type', 'vendor')->get();

        return view('backend.vendor.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $categories = Category::orderBy('name')->get();
        return view('backend.vendor.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VendorRequest $request)
    {



        $this->vendorService->create($request);

        return redirect()->route('admin.vendor.index')->with('success', 'Vendor details Add successfully');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $categories = Category::orderBy('name')->get();
        $vendor = User::with('userProfile', 'categories')->where([
            'id' => $id,
            'user_type' => 'vendor',
        ])->first();

        return view('backend.vendor.edit', compact('categories', 'vendor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VendorRequest $request, $id)
    {
        $this->vendorService->update($request, $id);
        return redirect()->route('admin.vendor.index')->with('success', 'Vendor details update successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $vendor = User::findOrFail($id);
        $vendor->delete();
        return back()->with('success', 'Vendor Delete Successfully !');
    }






    /**
     * vendor active
     */

    public function active($id)
    {


        $vendor = User::findOrFail($id);
        $vendor->status = '1';
        $vendor->save();
        return back()->with('success', 'Vendor Active Successfully !');
    }


    /**
     * Vendor de-active
     */

    public function deActive($id)
    {

        $vendor = User::findOrFail($id);
        $vendor->status = '0';
        $vendor->save();
        return back()->with('success', 'Vendor de-active Successfully !');
    }


    /**
     * 
     * list users
     */


    public function listUser()
    {
        $users = User::where('user_type', 'user')->get();
        return view('backend.user.index', compact('users'));
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'User delete Successfully!');
    }


    public function changeBookingStatusActive($id)
    {

        $order = Order::findOrFail($id);
        $orderItems = OrderItem::where('order_id', $id)->get();
        foreach ($orderItems as $orderItem) {

            BookingDate::where([
                'user_id' => $orderItem->vendor_id,
                'category_id' => $orderItem->category_id,
                'booking_user_id' => $orderItem->user_id,
                'vendor_business_category_detail_id' => $orderItem->vendor_business_category_detail_id,
                'type' => 'booking'
            ])->update(['status' => '1']);

            $orderItem->status = '1';
            $orderItem->save();
        }

        $order->order_status = 'completed';
        $order->save();
        return back()->with('success', 'status has changed');
    }


    public function changeBookingStatusInActive($id)
    {

        $order = Order::findOrFail($id);
        $orderItems = OrderItem::where('order_id', $id)->get();
        foreach ($orderItems as $orderItem) {

            BookingDate::where([
                'user_id' => $orderItem->vendor_id,
                'category_id' => $orderItem->category_id,
                'booking_user_id' => $orderItem->user_id,
                'vendor_business_category_detail_id' => $orderItem->vendor_business_category_detail_id,
                'type' => 'booking'
            ])->update(['status' => '0']);

            $orderItem->status = '0';
            $orderItem->save();
        }

        $order->order_status = 'pending';
        $order->save();

        return back()->with('success', 'status has changed');
    }


    public function changePaymentStatusActive($id)
    {
        $order = Order::findOrFail($id);
        $order->payment_status = 'completed';
        $order->save();
        return back()->with('success', 'Payment Status has been changed');
    }

    public function changePaymentStatusInActive($id)
    {
        $order = Order::findOrFail($id);
        $order->payment_status = 'pending';
        $order->save();
        return back()->with('success', 'Payment Status has been changed');
    }

    /**
     * order detials
     */


    public function orderDetial($id)
    {
        $order = Order::where('id', $id)->with('order')->first();


        return view('backend.orderDetial', compact('order'));
    }
}
