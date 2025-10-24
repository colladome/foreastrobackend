<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Category;
use App\Models\Backend\Photo;
use App\Models\Backend\RealWedding;
use App\Models\Review;
use App\Models\User;
use App\Models\Vendor\VendorCategoryProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class PhotoController extends Controller
{
    public function addPhotos()
    {
        $photos = Photo::get();

        // $file = [];
        // foreach ($photos->photos as $photo) {
        //     $file[] = $photo['file'];
        // }

        // print_r($file);
        // die;
        $categories = Category::orderBy('name')->get();
        return view('backend.photo.photo', compact('categories'));
    }


    public function storePhotos(Request $request)
    {




        if (!empty($request->file('cover_image'))) {


            $image = $request->file('cover_image');

            $uuid = Str::uuid()->toString();
            $extension = $image->extension();
            $fileName = $uuid . 'cover_image';
            $documentPath = 'photo';
            $filePath = $documentPath . '/' . $fileName;

            $galleryImage = [
                'file' =>  $filePath,
                'extension' => $extension
            ];

            $storedFilePath = $image->storeAs($documentPath, $fileName, 'public');
        }





        if (!empty($request->file('photos'))) {
            $photos = [];
            foreach ($request->file('photos') as $image) {


                $uuid = Str::uuid()->toString();
                $extension = $image->extension();
                $fileName = $uuid . 'photo';
                $documentPath = 'photo';
                $filePath = $documentPath . '/' . $fileName;

                $galleryImage = [
                    'file' =>  $filePath,
                    'extension' => $extension
                ];

                $storedFilePath = $image->storeAs($documentPath, $fileName, 'public');

                $photos[] = $galleryImage;
            }
        }


        Photo::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category,
            'name' => $request->name,
            'place' => $request->place,
            'cover_image' => $galleryImage,
            'photos' => $photos ?? null,

        ]);


        return redirect()->route('admin.listPhotos')->with('success', 'Photos save successfully!');
    }


    public function listPhotos()
    {
        $photos = Photo::get();
        return view('backend.photo.index', compact('photos'));
    }

    public function deletePhoto($id)
    {
        $photo = Photo::findOrFail($id);
        $photo->delete();
        return back()->with('success', 'Photo delete successfully!');
    }

    public function editPhoto($id)
    {
        $photo = Photo::findOrFail($id);
        // print_r($photo);
        // die;
        $categories = Category::orderBy('name')->get();
        return view('backend.photo.edit', compact('categories', 'photo'));
    }

    public function updatePhoto(Request $request, $id)
    {

        if (!empty($request->file('cover_image'))) {


            $image = $request->file('cover_image');

            $uuid = Str::uuid()->toString();
            $extension = $image->extension();
            $fileName = $uuid . 'cover_image';
            $documentPath = 'photo';
            $filePath = $documentPath . '/' . $fileName;

            $galleryImage = [
                'file' =>  $filePath,
                'extension' => $extension
            ];

            $storedFilePath = $image->storeAs($documentPath, $fileName, 'public');
        } else {
            $photo = Photo::where('id', $id)->first();
            $galleryImage = $photo->cover_image;
        }





        if (!empty($request->file('photos'))) {
            $photos = [];
            foreach ($request->file('photos') as $image) {


                $uuid = Str::uuid()->toString();
                $extension = $image->extension();
                $fileName = $uuid . 'photo';
                $documentPath = 'photo';
                $filePath = $documentPath . '/' . $fileName;

                $galleryImage = [
                    'file' =>  $filePath,
                    'extension' => $extension
                ];

                $storedFilePath = $image->storeAs($documentPath, $fileName, 'public');

                $photos[] = $galleryImage;
            }
        } else {
            $photo = Photo::where('id', $id)->first();
            $photos = $photo->photos;
        }


        Photo::where('id', $id)->update([

            'category_id' => $request->category,
            'name' => $request->name,
            'place' => $request->place,
            'cover_image' => $galleryImage,
            'photos' => $photos ?? null,

        ]);


        return redirect()->route('admin.listPhotos')->with('success', 'Photos update successfully!');
    }


    public function listRealWedding()
    {
        $realWeddings = RealWedding::orderBy('id', 'desc')->get();
        return view('backend.realWedding.index', compact('realWeddings'));
    }



    public function addRealWedding()
    {
        $categories = Category::orderBy('name')->get();
        $vendors = User::where(['user_type' => 'vendor', 'status' => '1'])->get();
        return view('backend.realWedding.create', compact('categories', 'vendors'));
    }


    public function storeRealWedding(Request $request)
    {

        if (!empty($request->file('cover_image'))) {


            $image = $request->file('cover_image');

            $uuid = Str::uuid()->toString();
            $extension = $image->extension();
            $fileName = $uuid . 'real_wedding_cover_image';
            $documentPath = 'realWedding';
            $filePath = $documentPath . '/' . $fileName;

            $galleryImage = [
                'file' =>  $filePath,
                'extension' => $extension
            ];

            $storedFilePath = $image->storeAs($documentPath, $fileName, 'public');
        }





        if (!empty($request->file('photos'))) {
            $photos = [];
            foreach ($request->file('photos') as $image) {


                $uuid = Str::uuid()->toString();
                $extension = $image->extension();
                $fileName = $uuid . 'real_wedding';
                $documentPath = 'realWedding';
                $filePath = $documentPath . '/' . $fileName;

                $galleryImage = [
                    'file' =>  $filePath,
                    'extension' => $extension
                ];

                $storedFilePath = $image->storeAs($documentPath, $fileName, 'public');

                $photos[] = $galleryImage;
            }
        }


        RealWedding::create([
            'user_id' => Auth::id(),
            'vendor_id' => $request->vendor,
            'category_id' => $request->category,
            'name' => $request->name,
            'description' => $request->description,
            'place' => $request->place,
            'cover_image' => $galleryImage,
            'photos' => $photos ?? null,

        ]);


        return redirect()->route('admin.listRealWedding')->with('success', 'Real Wedding save successfully!');
    }


    public function editRealWedding($id)
    {
        $realWedding = RealWedding::findOrFail($id);
        $vendors = User::where(['user_type' => 'vendor', 'status' => '1'])->get();


        $categories = Category::orderBy('name')->get();
        return view('backend.realWedding.edit', compact('categories', 'realWedding', 'vendors'));
    }





    public function updateRealWedding(Request $request, $id)
    {

        if (!empty($request->file('cover_image'))) {


            $image = $request->file('cover_image');

            $uuid = Str::uuid()->toString();
            $extension = $image->extension();
            $fileName = $uuid . 'real_wedding_cover_image';
            $documentPath = 'realWedding';
            $filePath = $documentPath . '/' . $fileName;

            $galleryImage = [
                'file' =>  $filePath,
                'extension' => $extension
            ];

            $storedFilePath = $image->storeAs($documentPath, $fileName, 'public');
        } else {
            $photo = RealWedding::where('id', $id)->first();
            $galleryImage = $photo->cover_image;
        }





        if (!empty($request->file('photos'))) {
            $photos = [];
            foreach ($request->file('photos') as $image) {


                $uuid = Str::uuid()->toString();
                $extension = $image->extension();
                $fileName = $uuid . 'real_wedding';
                $documentPath = 'realWedding';
                $filePath = $documentPath . '/' . $fileName;

                $galleryImage = [
                    'file' =>  $filePath,
                    'extension' => $extension
                ];

                $storedFilePath = $image->storeAs($documentPath, $fileName, 'public');

                $photos[] = $galleryImage;
            }
        } else {
            $photo = RealWedding::where('id', $id)->first();
            $photos = $photo->photos;
        }


        RealWedding::where('id', $id)->update([

            'category_id' => $request->category,
            'vendor_id' => $request->vendor,
            'name' => $request->name,
            'place' => $request->place,
            'description' => $request->description,
            'cover_image' => $galleryImage,
            'photos' => $photos ?? null,

        ]);


        return redirect()->route('admin.listRealWedding')->with('success', 'Real Wedding update successfully!');
    }

    public function deleteRealWedding($id)
    {
        $photo = RealWedding::findOrFail($id);
        $photo->delete();
        return back()->with('success', 'Photo delete successfully!');
    }


    public function review()
    {
        $reviews = Review::orderBy('id', 'desc')->with('user', 'vendorBusinessCategoryDetail')->get();
        return view('backend.review', compact('reviews'));
    }

    public function reviewActive($id)
    {
        $review = Review::findOrFail($id);
        $review->status = '1';
        $review->save();
        return back()->with('success', 'User Review Active Successfully!');
    }

    public function reviewInActive($id)
    {
        $review = Review::findOrFail($id);
        $review->status = '0';
        $review->save();
        return back()->with('success', 'User Review In-Active Successfully!');
    }

    public function reviewDelete($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        return back()->with('success', 'User Review Delete Successfully!');
    }




    public function getProduct(Request $request)
    {

        $output = "<option value=''>--Select Product--</option>";
        if (!isset($request->vendor_id)) {
            $output = "<option value=''>--Select Product--</option>";
            return $output;
        }
        $products = VendorCategoryProfile::where('user_id', $request->vendor_id)->get();


        foreach ($products as $product) {

            $output .= "<option value='$product->category_id' $product->id == $request->product_id ? 'selected': ''>$product->business_profile_name</option>";
        }




        return $output;
    }
}
