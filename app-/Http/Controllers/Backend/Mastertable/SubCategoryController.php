<?php

namespace App\Http\Controllers\Backend\Mastertable;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\Category;
use App\Services\Backend\MasterTable\SubCategoryService;
use App\Models\Backend\SubCategory;

class SubCategoryController extends Controller
{

    public $subCategoryService;

    public function __construct()
     {
        $this->subCategoryService = new SubCategoryService();
     }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subCategories = SubCategory::orderBy('name')->get();
        return view('backend.masterTable.sub_category.index', compact('subCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $categories = Category::orderBy('name')->get();

        return view('backend.masterTable.sub_category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->subCategoryService->create($request);

        return redirect()->route('admin.masterTable.subCategory.index')->with('success', 'Sub Category Add successfully!');

    }

   

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categories = Category::orderBy('name')->get();
        $subCategory = SubCategory::findOrFail($id);
        return view('backend.masterTable.sub_category.edit', compact('categories','subCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->subCategoryService->update($request, $id);

        return redirect()->route('admin.masterTable.subCategory.index')->with('success', 'Sub Category Update successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $subCategory = SubCategory::findOrFail($id);
        $subCategory->delete();
        return redirect()->route('admin.masterTable.subCategory.index')->with('success', 'Sub Category Delete successfully!');

    }
}
