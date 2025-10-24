<?php

namespace App\Http\Controllers\Backend\Mastertable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\MasterTable\CityRequest;
use App\Services\Backend\MasterTable\CityService;
use App\Models\Backend\City;
use App\Models\Backend\State;

class CityController extends Controller
{
    public $cityService;

    public function __construct()
    {
        $this->cityService = new CityService();
    } 

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = City::orderBy('id', 'desc')->get();

        return view('backend.masterTable.city.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $states = State::orderBy('id', 'desc')->get();

        return view('backend.masterTable.city.create', compact('states'));
    }

    public function store(CityRequest $request)
    {
        
        $this->cityService->create($request);
        return redirect()->route('admin.masterTable.city.index')->with('success','City Add Successfully !');
    }

    

   /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $states = State::orderBy('name','asc')->get();
        $city = City::findOrFail($id);
        return view('backend.masterTable.city.edit', compact('states','city'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CityRequest $request,$id)
    {
        
        $this->cityService->update($request, $id);
        return redirect()->route('admin.masterTable.city.index')->with('success','City Update Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $city->delete();
        return back()->with('success', 'City Delete Successfully !');
    }



    public function filterCity(Request $request)
    {

        $output = "<option value=''>--Select City--</option>" ;
        if(!isset($request->state_id))
        {
            $output = "<option value=''>--Select City--</option>" ;
            return $output;
        }
        $cities = City::where('state_id', $request->state_id)->get();
       
        
            foreach ($cities as $city) {
                
                $output .= "<option value='$city->id' $city->id == $request->city_id ? 'selected': ''>$city->name</option>" ;
            }

        
        
        
        return $output;
    }



}
