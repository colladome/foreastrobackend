<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TestimonialController extends Controller
{


    public function index()
    {
        $testimonials = Testimonial::orderBy('id', 'desc')->get();
        return view('backend.testimonial.index', compact('testimonials'));
    }

    public function create()
    {

        return view('backend.testimonial.create');
    }


    public function store(Request $request)
    {



        $image = $request->file('image');
        if ($image) {
            $uuid = Str::uuid()->toString();
            $extension = $request->file('image')->extension();
            $fileName = $uuid . 'testimonial' . '.' . $extension;
            $documentPath = 'testimonial';
            $filePath = $documentPath . '/' . $fileName;


            $storedFilePath = $image->storeAs($documentPath, $fileName, 'public');
        }

        Testimonial::create([
            'name' => $request->name,
            'image' => $filePath,
            'rating' => $request->review,
            'descreption' => $request->descreption,
        ]);


        return redirect()->route('admin.testimonial.index')->with('success', 'Testimonial add successfully!');
    }



    public function edit($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('backend.testimonial.edit', compact('testimonial'));
    }


    public function update(Request $request, $id)
    {

        $testimonial = Testimonial::findOrFail($id);

        $image = $request->file('image');
        if ($image) {
            $uuid = Str::uuid()->toString();
            $extension = $request->file('image')->extension();
            $fileName = $uuid . 'testimonial' . '.' . $extension;
            $documentPath = 'testimonial';
            $filePath = $documentPath . '/' . $fileName;


            $storedFilePath = $image->storeAs($documentPath, $fileName, 'public');
        } else {
            $filePath = $testimonial->image;
        }

        Testimonial::where('id', $id)->update([
            'name' => $request->name,
            'image' => $filePath,
            'rating' => $request->rating,
            'descreption' => $request->descreption,
        ]);

        return redirect()->route('admin.testimonial.index')->with('success', 'Testimonial add successfully!');
    }


    public function delete($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();
        return back()->with('success', 'Testimonial delete successfully!');
    }
}
