<?php

namespace App\Http\Controllers\Backend\Mastertable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::get();
        return view('backend.masterTable.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.masterTable.permissions.create');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name'
        ]);

        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web',
        
        ]);

       return redirect()->route('admin.masterTable.permission.index')->with('success', 'Permission Add successfully!');
    }

  

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $permission = Permission::where('id', $id)->first();
        return view('backend.masterTable.permissions.edit', compact('permission'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,'.$id
        ]);

        Permission::where('id', $id)->update([
            'name' => $request->name,
         
        ]);

        return redirect()->route('admin.masterTable.permission.index')->with('success', 'Permission update successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return redirect()->route('admin.masterTable.permission.index')->with('success', 'Permission Delete successfully!');


    }
}
