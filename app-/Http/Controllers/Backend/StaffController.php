<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StaffPermission;
use App\Models\User;
use App\Services\StaffService;
use App\Http\Requests\VendorRequest;
use Spatie\Permission\Models\Role;
class StaffController extends Controller
{


public $staffService;


public function __construct()
{
    $this->staffService = new StaffService();
}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staffs = User::with('roles')->where('user_type','staff')->get();
        return view('backend.staff.index', compact('staffs'));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $roles = Role::orderBy('name')->get();
        return view('backend.staff.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $this->staffService->create($request);

        return redirect()->route('admin.staff.index')->with('success','Staff details Add successfully');
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
    public function edit($id)
    {
        $roles = Role::orderBy('name')->get();
        $staff = User::with('roles')->where([
            'id' => $id,
            'user_type' => 'staff',
            ])->first();

        return view('backend.staff.edit', compact('roles','staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
        $this->staffService->update($request, $id);

        return redirect()->route('admin.staff.index')->with('success','Staff details Update successfully');
    }

     /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $staff = User::findOrFail($id);
        $staff->delete();
        return back()->with('success', 'Staff Delete Successfully !');
    }






  /**
   * staff active
   */

   public function active($id)
   {

    
    $staff = User::findOrFail($id);
    $staff->status = '1';
    $staff->save();
    return back()->with('success', 'Staff Active Successfully !');
   }


 /**
   * staff de-active
   */

   public function deActive($id)
   {

    $staff = User::findOrFail($id);
    $staff->status = '0';
    $staff->save();
    return back()->with('success', 'Staff de-active Successfully !');
   }



}
