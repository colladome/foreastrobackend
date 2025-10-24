<?php

namespace App\Http\Controllers\Backend\Mastertable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::orderBy('id','DESC')->get();
        return view('backend.masterTable.roles.index', compact('roles'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::get();
        return view('backend.masterTable.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permissions' => 'required',
        ]);
    
        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('admin.masterTable.role.index')->with('success', 'Role add successfully!');


    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        
        $role = Role::where('id', $id)->first();
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        $permissions = Permission::get();
        return view('backend.masterTable.roles.edit', compact('role', 'rolePermissions', 'permissions'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|unique:roles,name,'.$id,
            'permissions' => 'required',
        ]);
        $role->name = $request->name;
        $role->save();
        $role->syncPermissions($request->permissions);
        return redirect()->route('admin.masterTable.role.index')->with('success', 'Role Update successfully!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('admin.masterTable.role.index')->with('success', 'Role Delete successfully!');

    }
}
