<?php

namespace App\Http\Controllers\Auth\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\Category;
use App\Models\User;
use App\Http\Requests\VendorRequest;
use App\Services\VendorService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
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
        return view('auth.vendor.login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function regester()
    {
        $categories = Category::orderBy('name')->get();
        return view('auth.vendor.regester', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VendorRequest $request)
    {
        $this->vendorService->create($request);
        return redirect()->route('vendor.index')->with('success','Vendor Regester successfully');

    }

    public function login(Request $request)
 {
     $request->validate([
         'email' => 'required',
         'password' => 'required',
     ]);
 
     $credentials = $request->only('email', 'password');
     if (Auth::attempt([
        'email' => $request->email,
        'password' => $request->password,
        'user_type' => 'vendor'
     ])) {
         return redirect()->route('vendor.dashboard');
     }
     

       return redirect()->route('vendor.index')->with('error','Login details are not valid');
 }



   /**
      * Vendor Logout
      */

      public function logout()
      {
          Session::flush();
          Auth::logout();
          return redirect()->route('vendor.index');
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
