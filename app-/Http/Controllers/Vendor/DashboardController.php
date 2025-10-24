<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Backend\Category;
use App\Models\OrderItem;
use App\Models\UserEnquirie;
use App\Services\VendorService;

class DashboardController extends Controller
{

    public $vendorService;

    public function __construct()
    {
        $this->vendorService = new VendorService();
    }


    /**
     * Display a listing of the resource.
     */
    public function dashboard()
    {
        //     $countUsers = User::where('user_type', 'user')->count();
        //     $countVendors = User::where('user_type', 'vendor')->count();
        //$user = Auth::user();
        $user = Auth::user();
        $userId = Auth::id();
        $orders = OrderItem::where('vendor_id', $userId)->with('order')->get();
        $countOrder = count($orders);
        $countEnquiry = UserEnquirie::where('vendor_id', $userId)->count();


        return view('vendor.dashboard', compact('user', 'countOrder', 'countEnquiry'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function profile()
    {
        $user = Auth::user();
        $userProfile = User::with('userProfile', 'categories')->where('id', $user->id)->first();
        $categories = Category::orderBy('name')->get();
        return view('vendor.profile.profile', compact('userProfile', 'categories'));
    }


    public function profileUpdate(Request $request, $id)
    {

        $this->vendorService->update($request, $id);
        return back()->with('success', 'Profile Update successfully!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
