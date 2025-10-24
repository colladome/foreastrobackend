<?php

namespace App\Http\Controllers\Backend\Mastertable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\MasterTable\StateRequest;
use App\Services\Backend\MasterTable\StateService;
use App\Models\Backend\State;

class StateController extends Controller
{

    public $stateService;

    public function __construct()
    {
        $this->stateService = new StateService();
    } 

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $states = State::orderBy('id', 'desc')->get();

        return view('backend.masterTable.state.index', compact('states'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.masterTable.state.create');
    }

    public function store(StateRequest $request)
    {
        
        $this->stateService->create($request);
        return redirect()->route('admin.masterTable.state.index')->with('success','State Add Successfully !');
    }

    

   /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $state = State::findOrFail($id);
        return view('backend.masterTable.state.edit', compact('state'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StateRequest $request,$id)
    {
        
        $this->stateService->update($request, $id);
        return redirect()->route('admin.masterTable.state.index')->with('success','State Update Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $banner = State::findOrFail($id);
        $banner->delete();
        return back()->with('success', 'State Delete Successfully !');
    }
}
