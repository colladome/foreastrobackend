<?php

namespace App\Http\Controllers\Backend\Mastertable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\State;
use App\Services\Backend\MasterTable\AreaService;
use App\Http\Requests\Backend\MasterTable\AreaRequest;
use App\Models\Backend\Area;


class AreaController extends Controller
{



    public $areaService;

    public function __construct()
    {
        $this->areaService = new AreaService();
    } 



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $areas = Area::orderBy('id','desc')->get();

        return view('backend.masterTable.area.index', compact('areas'));
        
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $states = State::orderBy('id', 'desc')->get();

        return view('backend.masterTable.area.create', compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AreaRequest $request)
    {
        
        $this->areaService->create($request);
        return redirect()->route('admin.masterTable.area.index')->with('success','Area Add Successfully !');
    }

   

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $states = State::orderBy('name','asc')->get();
        $area = Area::findOrFail($id);
        return view('backend.masterTable.area.edit', compact('states','area'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AreaRequest $request, $id)
    {
        $this->areaService->update($request, $id);
        return redirect()->route('admin.masterTable.area.index')->with('success','Area Update Successfully !');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $area = Area::findOrFail($id);
        $area->delete();
        return back()->with('success', 'Area Delete Successfully !');
    }

    /**
     * filter area
     */

    public function filteArea(Request $request)
    {
        $output = "";
        if(!isset($request->city_id))
        {
            $output = "<option value=''>--Select City--</option>" ;
            return $output;
        }
        $areas = Area::where('city_id', $request->city_id)->get();
       
        
            foreach ($areas as $area) {
                
                $output .= "<option value='$area->id'>$area->name</option>" ;
            }

        
        
        
        return $output;
    }
}
