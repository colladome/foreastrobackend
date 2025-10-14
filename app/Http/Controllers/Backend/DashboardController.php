<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Astrologer;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Backend\Category;
use App\Models\BookingDate;
use App\Models\Communication;
use ZEGO\ZegoServerAssistant;
use ZEGO\ZegoErrorCodes;

use App\Models\Order;

use Spatie\Permission\Models\Permission;
use App\Models\Vendor\VendorBusinessCategoryDetail;


class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        $countUsers = User::where('user_type', 'user')->count();

        $user = Auth::user();
        $countAstrologer = Astrologer::count();

        $countCallAndMessages = Communication::orderBy('id', 'desc')->where('status', 'accept')->count();

        return view('backend.dashboard', compact('countUsers', 'user', 'countAstrologer','countCallAndMessages'));
    }



    public function orderManagement()
    {
        $orders = Order::with('order')->orderBy('id', 'desc')->get();
        $vendors = User::where(['user_type' => 'vendor', 'status' => '1'])->get();
        $categories = Category::where('status', '1')->get();
        return view('backend.orderManagement', compact('orders', 'vendors', 'categories'));
    }


    public function filterOrder(Request $request)
    {

        $vendors = User::where(['user_type' => 'vendor', 'status' => '1'])->get();
        $categories = Category::where('status', '1')->get();

        if (empty($request->vendor_id) && empty($request->category_id) && empty($request->payment_status) && empty($request->order_status) && empty($request->from_date) && empty($request->to_date)) {

            $orders = Order::with('order')->orderBy('id', 'desc')->get();

            return view('backend.orderManagement', compact('orders', 'vendors', 'categories', 'request'));
        }

        //filter by only dates
        if (empty($request->vendor_id) && empty($request->category_id) && empty($request->payment_status) && empty($request->order_status) || !empty($request->from_date) || !empty($request->to_date)) {


            $query = BookingDate::where(['type' => 'booking']);


            if (!empty($request->from_date)) {

                $query->where('booking_date', '>=', $request->from_date);
            }


            if (!empty($request->to_date)) {
                $query->where('booking_date', '<=', $request->to_date);
            }
            $bookingIds = $query->pluck('order_id')->toArray();



            $orders = Order::whereIn('id', $bookingIds)->with('order')->orderBy('id', 'desc')->get();

            return view('backend.orderManagement', compact('orders', 'vendors', 'categories', 'request'));
        }









        $vendorId = $request->vendor_id;
        $categoryId = $request->category_id;
        $paymentStatus = $request->payment_status;
        $orderStatus  = $request->order_status;
        $startDate = $request->from_date;
        $endDate = $request->from_date;

        $orders = Order::with('order')
            ->whereHas('order', function ($query) use ($vendorId, $categoryId, $startDate, $endDate) {

                if (!empty($vendorId)) {
                    $query->where('vendor_id', $vendorId);
                }


                if (!empty($categoryId)) {
                    $query->where('category_id', $categoryId);
                }

                // Check if booking_date is not empty
                if (isset($startDate) && !empty($startDate) && !empty($endDate) && isset($endDate)) {
                    $query->whereJsonContains('booking_date', $startDate)
                        ->orWhereJsonContains('booking_date', $endDate);
                }
            })
            ->when(request()->filled('payment_status'), function ($query) {
                // Add the payment_status filter if payment_status in request is not empty
                $query->where('payment_status', request('payment_status'));
            })
            ->when(request()->filled('order_status'), function ($query) {
                // Add the order_status filter if order_status in request is not empty
                $query->where('order_status', request('order_status'));
            })
            ->orderBy('id', 'desc')
            ->get();






        return view('backend.orderManagement', compact('orders', 'vendors', 'categories', 'request'));
    }
    
    
    public function chatHistory($id)
    {
        
        $communication = Communication::where('id', $id)->first();
         $user = User::findOrFail($communication->user_id);
        $astro = Astrologer::findOrFail($communication->astrologer_id);
        
        $astroName = $astro->name;
        $userName = $user->name;
        
        require_once base_path('zegocloud/auto_loader.php');

        // Use the ZegoCloud classes

        // ZegoCloud configuration
        $appId = 2007373594; // Replace with your own app ID
        $serverSecret = '22aa0babf5392ace36d6abe4d47ca0bb'; // Replace with your own server secret
        $userId = $communication->user_id.'-user'; // Replace with the user ID
        
       
        $astroId = $communication->astrologer_id.'-astro';
        $payload = ''; // Leave empty for basic authentication token
        $expiryTime = 3600; // Token expiration time in seconds

        // Generate the token
        $token = ZegoServerAssistant::generateToken04($appId, $userId, $serverSecret, $expiryTime, $payload);

        $finalToken = $token->token;

        // print_r($token);
        // die;
        return view('backend.chat', compact('finalToken','astroId', 'userId','astroName','userName'));
    }
}
