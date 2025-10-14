<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\Category;
use App\Models\Backend\Blog;
use App\Services\Backend\BlogService;
use App\Http\Requests\Backend\BlogRequest;;

class BlogController extends Controller
{
    public $blogService;

    public function __construct()
    {
        $this->blogService = new BlogService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::orderBy('id', 'DESC')->get();
        return view('backend.blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('backend.blog.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request)
    {
        $this->blogService->create($request);
        return redirect()->route('admin.blog.index')->with('success', 'Blog add successfully!');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $categories = Category::orderBy('name')->get();
        $blog = Blog::findOrFail($id);

        return view('backend.blog.edit', compact('blog', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->blogService->update($request, $id);
        return redirect()->route('admin.blog.index')->with('success', 'Blog Update successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $blog  = Blog::findOrFail($id);
        $blog->delete();
        return back()->with('Blog Delete successfully!');
    }



    /**
     * Blog active
     */

    public function active($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->status = '1';
        $blog->save();
        return back()->with('success', 'Blog Active Successfully !');
    }


    /**
     * Blog de-active
     */

    public function deActive($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->status = '0';
        $blog->save();
        return back()->with('success', 'Blog de-active Successfully !');
    }
}
