<?php

namespace App\Http\Controllers\Backend\Mastertable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\MasterTable\BannerRequest;
use App\Services\Backend\MasterTable\BannerService;
use App\Models\Backend\Banner;

class BannerController extends Controller
{

    public $bannerService;

    public function __construct()
    {
        $this->bannerService = new BannerService();
    } 
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::orderBy('id', 'desc')->get();
        return view('backend.masterTable.banner.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.masterTable.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BannerRequest $request)
    {
        $this->bannerService->create($request);
        return back()->with('success', 'Banner Add successfully');
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
        $banner = Banner::findOrFail($id);
        return view('backend.masterTable.banner.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BannerRequest $request, $id)
    {
        $this->bannerService->update($request, $id);
        return redirect()->route('admin.masterTable.index')->with('success','Banner Update Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();
        return back()->with('success', 'Banner Delete Successfully !');
    }

  /**
   * banner active
   */

   public function active($id)
   {
    $banner = Banner::findOrFail($id);
    $banner->status = '1';
    $banner->save();
    return back()->with('success', 'Banner Active Successfully !');
   }


     /**
   * banner de-active
   */

   public function deActive($id)
   {
    $banner = Banner::findOrFail($id);
    $banner->status = '0';
    $banner->save();
    return back()->with('success', 'Banner de-active Successfully !');
   }


}
