<?php

namespace App\Http\Controllers;

use App\Models\Backend\City;
use App\Models\Backend\State;
use App\Models\BookingDate;
use App\Models\UserEnquirie;
use App\Models\Cart;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\User;
use App\Models\Vendor\VendorCategoryProfile;
use Illuminate\Http\Request;
use App\Models\Vendor\VendorVenueSpace;
use Illuminate\Support\Facades\Auth;
use App\Models\Vendor\VendorBusinessCategoryDetail;

class BookingEnquirieController extends Controller
{
    public function create(Request $request)
    {

        $userId = Auth::id();
        $dates = explode(",", $request->booking_date);
        UserEnquirie::create([
            'user_id' => $userId,
            'vendor_id' => $request->vendor_id,
            'category_id' => $request->category_id,
            'vendor_business_category_detail_id' => $request->vendor_business_category_detail_id,
            'name' => $request->name,
            'email' => $request->email,
            'booking_date' => $dates,
            'number_of_room' => $request->number_of_room,
            'number_of_guest' => $request->number_of_guest,
            'function_type' => $request->function_type,
            'function_time' => $request->function_time,
            'status' => '0',
        ]);

        foreach ($dates as $date) {
            BookingDate::create([
                'user_id' => $request->vendor_id,
                'booking_user_id' => Auth::id(),
                'category_id' => $request->category_id,
                'booking_date' => $date,
                'status' => '0'
            ]);
        }

        return back()->with('success', 'We are Contact you shortly!');
    }


    public function inquiryDone($id)
    {
        $inquir = UserEnquirie::findOrFail($id);
        $inquir->status = '1';
        $inquir->save();

        BookingDate::where(['booking_user_id' =>  $inquir->user_id, 'user_id' =>  $inquir->vendor_id, 'category_id' => $inquir->category_id, ''])->update(['status' => '1']);

        return back()->with('success', 'status change');
    }

    public function inquiryPending($id)
    {
        $inquir = UserEnquirie::findOrFail($id);
        $inquir->status = '0';
        $inquir->save();
        BookingDate::where(['booking_user_id' =>  $inquir->user_id, 'user_id' =>  $inquir->vendor_id, 'category_id' => $inquir->category_id, ''])->update(['status' => '0']);

        return back()->with('success', 'status change');
    }


    public function addCart(Request $request)
    {


        $userId = Auth::id();
        $dates = explode(",", $request->booking_date);

        $vendorCategoryProfile = VendorCategoryProfile::where(['user_id' => $request->vendor_id, 'category_id' => $request->category_id,])->first();
        if ($request->category_id == 6) {
            $price = $request->number_of_guest * $request->price;
        } else {
            $price = $request->price;
        }



        $cart = Cart::where(['user_id' => $userId, 'vendor_id' => $request->vendor_id, 'category_id' => $request->category_id])->first();
        if (!empty($cart)) {
            return
                redirect()->route('cart')->with('success', 'You already Add to cart please checkout!');
        }

        Cart::create([
            'user_id' => $userId,
            'vendor_id' => $request->vendor_id,
            'category_id' => $request->category_id,
            'vendor_business_category_detail_id' => $request->vendor_business_category_detail_id,
            'name' => $request->name,
            'email' => $request->email,
            'booking_date' => $dates,
            'number_of_room' => $request->number_of_room ?? null,
            'number_of_guest' => $request->number_of_guest ?? null,
            'function_type' => $request->function_type,
            'function_time' => $request->function_time,
            'product_name' => $vendorCategoryProfile->business_profile_name,
            'price' => $price,
            'image' => $vendorCategoryProfile->listing_cover_image,
            'status' => '0',
        ]);



        return redirect()->route('cart')->with('success', 'product add successfully!');
    }

    public function cart()
    {
        $userId = Auth::id();
        $carts = Cart::where('user_id', $userId)->orderBy('id', 'desc')->get();
        $countCart = count($carts);
        $totalAmount = Cart::where('user_id', $userId)->sum('price');

        return view('frontend.cart', compact('carts', 'countCart', 'totalAmount'));
    }

    public function removeItem($id)
    {
        $userId = Auth::id();
        $cart = Cart::findOrFail($id);

        BookingDate::where(['booking_user_id' => $userId, 'user_id' =>  $cart->vendor_id, 'type' => 'cart', 'status' => '0'])->delete();
        $cart->delete();
        return back()->with('success', 'Your Item has removed your cart successfully!');
    }


    public function checkout()
    {
        $userId = Auth::id();
        $items = Cart::where('user_id', $userId)->orderBy('id', 'desc')->get();
        $countItems = count($items);
        $totalAmount = Cart::where('user_id', $userId)->sum('price');
        return view('frontend.checkout', compact('items', 'countItems', 'totalAmount'));
    }


    public function itemsOrder(Request $request)
    {
        if ($request->number_of_order == 0) {
            return redirect()->route('cart')->with('error', 'Please Add some Items in Your Cart!');
        }

        $userId = Auth::id();
        $order = Order::create([
            'user_id' => $userId,
            'billing_name' => $request->first_name . ' ' . $request->last_name,
            'billing_email' => $request->email,
            'number_of_item' => $request->number_of_order,
            'total_amount' => $request->total_amount,
            'billing_address' => $request->address,
            'billing_address2' => $request->address2,
            'state' => 'UP', //$request->state,
            'city' => 'siddharth nager', $request->city,
            'zip' => $request->zip,
            'payment_status' => 'pending' //$request->payment_status,
        ]);

        $orderId = 'sky_000' . $order->id;

        Order::where('id', $order->id)->update(['sky_order_id' => $orderId]);

        $items = Cart::where('user_id', $userId)->orderBy('id', 'desc')->get();
        foreach ($items as $item) {
            OrderItem::create([
                'user_id' => $item->user_id,
                'order_id' => $order->id,
                'vendor_id' => $item->vendor_id,
                'category_id' => $item->category_id,
                'vendor_business_category_detail_id' => $item->vendor_business_category_detail_id,
                'booking_date' => $item->booking_date,
                'number_of_room' => $item->number_of_room,
                'number_of_guest' => $item->number_of_guest,
                'function_type' => $item->function_type,
                'function_time' => $item->function_time,
                'product_name' => $item->product_name,
                'price' => $item->price,
                'image' => $item->image,
                'status' => '0',
            ]);


            foreach ($item->booking_date as $date) {
                BookingDate::create([
                    'user_id' => $item->vendor_id,
                    'order_id' => $order->id,
                    'booking_user_id' => $item->user_id,
                    'category_id' => $item->category_id,
                    'vendor_business_category_detail_id' => $item->vendor_business_category_detail_id,
                    'booking_date' => trim($date),
                    'type' => 'booking',
                    'status' => '0'
                ]);
            }
        }
        //after booking items remove the carts
        Cart::where('user_id', $userId)->delete();

        return redirect()->route('purchase')->with('success', 'Your order has been booked successfully!');
    }

    public function purchase()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->get();
        return view('frontend.purchase', compact('user', 'orders'));
    }

    /**
     * admin bookin order
     */
    public function productBooking()
    {
        $users = User::where(['user_type' => 'user', 'status' => '1'])->get();
        $vendors = User::where(['user_type' => 'vendor', 'status' => '1'])->get();
        //$disabledDates = BookingDate::where(['vendor_business_category_detail_id' => $id, 'status' => '1'])->pluck('booking_date')->toArray();


        return view('backend.newbooking', compact('users', 'vendors'));
    }



    public function productBookingSave(Request $request)
    {


        $productDetial = VendorBusinessCategoryDetail::where([
            'category_id' => $request->category_id,
            'user_id' => $request->vendor_id,
        ])->with('venueSpaces', 'vendorBusinessProfile')->first();

        if (empty($productDetial)) {
            return back()->with('error', 'vendor has not created business details!');
        }

        //pricing
        if ($productDetial->category_id = 1) {

            $minPrice = null;
            foreach ($productDetial->venueSpaces as $space) {
                $price = $space->venue_rent;
                if ($minPrice === null || $price < $minPrice) {
                    $minPrice = $price;
                }
            }
        } elseif ($productDetial->category_id = 6) {
            $minPrice = $productDetial->per_plate_veg_price * $request->number_of_guest;
        } elseif ($productDetial->category_id == '2') {
            $minPrice = $productDetial->min_price;
        } elseif ($productDetial->category_id == '3') {
            $minPrice = $productDetial->bride_makeup_price;
        } elseif ($productDetial->category_id == '7') {
            $minPrice = $productDetial->min_price;
        } elseif ($productDetial->category_id == '4') {
            $minPrice = $productDetial->min_price;
        } else {
            $minPrice = $productDetial->min_price;
        }






        $userId = $request->user_id;
        $user = User::where('id', $userId)->with('userProfile')->first();
        if (empty($user->userProfile->address) || empty($user->userProfile->area_id) || empty($user->userProfile->city_id) || empty($user->userProfile->state_id) || empty($user->userProfile->pin_code)) {

            return back()->with('error', 'user has not completed his profile!');
        }
        $state = State::where('id', $user->userProfile->state_id)->first();
        $city = City::where('id', $user->userProfile->city_id)->first();


        $order = Order::create([
            'user_id' => $userId,
            'billing_name' => $user->name,
            'billing_email' => $user->email,
            'number_of_item' => 1,
            'total_amount' => $minPrice,
            'billing_address' => $user->userProfile->address,
            'billing_address2' => $request->address2,
            'state' => $state->name, //$request->state,
            'city' => $city->name, //$request->city,
            'zip' => $user->userProfile->pin_code,
            'payment_status' => 'pending' //$request->payment_status,
        ]);

        $orderId = 'sky_000' . $order->id;

        Order::where('id', $order->id)->update(['sky_order_id' => $orderId]);


        OrderItem::create([
            'user_id' => $userId,
            'order_id' => $order->id,
            'vendor_id' => $request->vendor_id,
            'category_id' => $request->category_id,
            'vendor_business_category_detail_id' => $productDetial->id,
            'booking_date' => $request->booking_date,
            'number_of_room' => $request->number_of_room ?? null,
            'number_of_guest' => $request->number_of_guest ?? null,
            'function_type' => $request->function_type,
            'function_time' => $request->function_time,
            'product_name' => $productDetial->vendorBusinessProfile->product_name,
            'price' => $minPrice,
            'image' => $productDetial->vendorBusinessProfile->listing_cover_image,
            'status' => '1',
        ]);


        foreach ($request->booking_date as $date) {
            BookingDate::create([
                'user_id' => $request->vendor_id,
                'order_id' => $order->id,
                'booking_user_id' => $request->user_id,
                'category_id' => $request->category_id,
                'vendor_business_category_detail_id' => $productDetial->id,
                'booking_date' => trim($date),
                'type' => 'booking',
                'status' => '1'
            ]);

            return redirect()->route('admin.order')->with('success', 'Bookin has been completed!');
        }
    }
}
