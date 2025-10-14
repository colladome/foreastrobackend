<?php

namespace App\Http\Controllers\Backend\Mastertable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\Category;
use App\Http\Requests\Backend\MasterTable\CategoryRequest;
use App\Services\Backend\MasterTable\CategoryService;


class CategoryController extends Controller
{


    public $categoryService;

    public function __construct()
    {
        $this->categoryService = new CategoryService();
    } 
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();

        return view('backend.masterTable.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.masterTable.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */

     
    public function store(CategoryRequest $request)
    {
        
        $this->categoryService->create($request);
        return redirect()->route('admin.masterTable.category.index')->with('success','Category Add Successfully !');
    }

   

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('backend.masterTable.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request,$id)
    {
        
        $this->categoryService->update($request, $id);
        return redirect()->route('admin.masterTable.category.index')->with('success','Category Update Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $banner = Category::findOrFail($id);
        $banner->delete();
        return back()->with('success', 'Category Delete Successfully !');
    }
}
