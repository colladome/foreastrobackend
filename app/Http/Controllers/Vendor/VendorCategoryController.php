<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Backend\Category;
use App\Models\Backend\State;
use App\Models\Backend\City;
use App\Models\Backend\Area;
use App\Services\VendorCategoryService;
use App\Models\Vendor\VendorCategoryProfile;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\VendorCategoryProfileRequest;
use App\Models\Backend\SubCategory;
use App\Models\BookingDate;
use App\Models\OrderItem;
use App\Models\UserEnquirie;
use App\Models\Vendor\Package;
use App\Services\VendorBusinessCategoryDetailService;
use App\Models\Vendor\VendorBusinessCategoryDetail;
use App\Models\Vendor\VendorVenueSpace;
use App\Services\VendorBusinessCategoryAboutService;
use App\Models\Vendor\VendorBusinessCategoryAbout;
use App\Services\GalleryService;
use App\Models\Vendor\VendorGallery;
use Illuminate\Support\Str;

class VendorCategoryController extends Controller
{



    public $vendorCategoryService;
    public $vendorBusinessCategoryDetailService;
    public $vendorBusinessCategoryAboutService;
    public $galleryService;

    public function __construct()
    {
        $this->vendorCategoryService = new VendorCategoryService();
        $this->vendorBusinessCategoryDetailService = new VendorBusinessCategoryDetailService();
        $this->vendorBusinessCategoryAboutService = new VendorBusinessCategoryAboutService();
        $this->galleryService = new GalleryService();
    }
    public function categoryListing()
    {
        $user = Auth::user();
        $categories = $user->categories;

        //  $categories = Category::orderBy('name')->get();
        return view('vendor.category_listig.category_listing', compact('categories'));
    }


    public function categoryProfile(Request $request)
    {
        $request->validate([
            'category_id' => 'required'
        ]);

        $categoryId = $request->category_id;
        $categoryProfile = VendorCategoryProfile::where([
            'user_id' => Auth::id(),
            'category_id' => $categoryId
        ])->first();



        $user = Auth::user();
        $categories = $user->categories;
        $states = State::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $areas = Area::orderBy('name')->get();

        return view('vendor.category_listig.category_profile', compact('categories', 'cities', 'areas', 'categoryId', 'states', 'categoryProfile'));
    }

    public function categoryProfileSave(VendorCategoryProfileRequest $request)
    {


        $categoryProfile = VendorCategoryProfile::where([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id
        ])->first();



        if (!empty($categoryProfile->id)) {

            $this->vendorCategoryService->update($request, $categoryProfile);


            return back()->with('success', 'Category Profile Update successfully!');
        } else {
            $this->vendorCategoryService->create($request);
            return back()->with('success', 'Category Profile Add successfully!');
        }
    }


    public function categoryDetail($id)
    {

        $vendorCategoryProfile = VendorCategoryProfile::where([
            'user_id' => Auth::id(),
            'category_id' => $id,
        ])->first();

        if (empty($vendorCategoryProfile)) {
            return back()->with('error', 'Please You First create your business Profile');
        }

        $category = Category::findOrFail($id);
        $categoryId = $id;
        $user = Auth::user();
        $categories = $user->categories;
        $subCategories = SubCategory::where('category_id', $categoryId)->orderBy('name')->get();

        if ($category->id == '1') {
            $vendorBusinessCategoryDetail = VendorBusinessCategoryDetail::with('venueSpaces')->where([
                'user_id' => Auth::id(),
                'category_id' => $categoryId,
            ])->first();

            return view('vendor.venues.details', compact('categoryId', 'categories', 'subCategories', 'vendorBusinessCategoryDetail'));
        }


        if ($category->id == '6') {
            $vendorBusinessCategoryDetail = VendorBusinessCategoryDetail::with('venueSpaces')->where([
                'user_id' => Auth::id(),
                'category_id' => $categoryId,
            ])->first();


            return view('vendor.catering.details', compact('categoryId', 'categories', 'subCategories', 'vendorBusinessCategoryDetail'));
        }


        if ($category->id == '4') {
            $vendorBusinessCategoryDetail = VendorBusinessCategoryDetail::where([
                'user_id' => Auth::id(),
                'category_id' => $categoryId,
            ])->first();


            return view('vendor.decorator.details', compact('categoryId', 'categories', 'subCategories', 'vendorBusinessCategoryDetail'));
        }



        if ($category->id == '2') {
            $vendorBusinessCategoryDetail = VendorBusinessCategoryDetail::where([
                'user_id' => Auth::id(),
                'category_id' => $categoryId,
            ])->first();


            return view('vendor.photography.details', compact('categoryId', 'categories', 'subCategories', 'vendorBusinessCategoryDetail'));
        }


        if ($category->id == '3') {
            $vendorBusinessCategoryDetail = VendorBusinessCategoryDetail::where([
                'user_id' => Auth::id(),
                'category_id' => $categoryId,
            ])->first();


            return view('vendor.makeup.details', compact('categoryId', 'categories', 'subCategories', 'vendorBusinessCategoryDetail'));
        }


        if ($category->id == '7') {
            $vendorBusinessCategoryDetail = VendorBusinessCategoryDetail::where([
                'user_id' => Auth::id(),
                'category_id' => $categoryId,
            ])->first();


            return view('vendor.invitation_card.details', compact('categoryId', 'categories', 'subCategories', 'vendorBusinessCategoryDetail'));
        }
    }

    /**
     * venue details seve
     */

    public function venueDetailSave(Request $request)
    {

        $vendorBusinessCategoryDetail = VendorBusinessCategoryDetail::with('venueSpaces')->where([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
        ])->first();


        if (empty($vendorBusinessCategoryDetail)) {
            $this->vendorBusinessCategoryDetailService->create($request);
            return back()->with('success', 'Details save successfully!');
        } else {

            $vendorVenueSpace = VendorVenueSpace::where('vendor_business_category_detail_id', $vendorBusinessCategoryDetail->id)->delete();
            $this->vendorBusinessCategoryDetailService->update($request, $vendorBusinessCategoryDetail->id);
            return back()->with('success', 'Details Update successfully!');
        }
    }




    /**
     * Catering Detail Save
     */

    public function cateringDetailSave(Request $request)
    {

        $vendorBusinessCategoryDetail = VendorBusinessCategoryDetail::where([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
        ])->first();


        if (empty($vendorBusinessCategoryDetail)) {
            $this->vendorBusinessCategoryDetailService->cateringCreate($request);
            return back()->with('success', 'Details save successfully!');
        } else {

            $this->vendorBusinessCategoryDetailService->cateringUpdate($request, $vendorBusinessCategoryDetail->id);
            return back()->with('success', 'Details Update successfully!');
        }
    }

    /**
     * Decorator Detail Save
     */

    public function decoratorDetailSave(Request $request)
    {
        $vendorBusinessCategoryDetail = VendorBusinessCategoryDetail::where([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
        ])->first();


        if (empty($vendorBusinessCategoryDetail)) {
            $this->vendorBusinessCategoryDetailService->decoratorCreate($request);
            return back()->with('success', 'Details save successfully!');
        } else {

            $this->vendorBusinessCategoryDetailService->decoratorUpdate($request, $vendorBusinessCategoryDetail->id);
            return back()->with('success', 'Details Update successfully!');
        }
    }



    /**
     * Photography Detail Save
     */


    public function photographyDetailSave(Request $request)
    {

        $vendorBusinessCategoryDetail = VendorBusinessCategoryDetail::where([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
        ])->first();


        if (empty($vendorBusinessCategoryDetail)) {
            $this->vendorBusinessCategoryDetailService->photographyCreate($request);
            return back()->with('success', 'Details save successfully!');
        } else {
            $this->vendorBusinessCategoryDetailService->photographyUpdate($request, $vendorBusinessCategoryDetail->id);
            return back()->with('success', 'Details Update successfully!');
        }
    }


    /**
     * Make Up Artist Detail Save
     */


    public function makeUpDetailSave(Request $request)
    {

        $vendorBusinessCategoryDetail = VendorBusinessCategoryDetail::where([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
        ])->first();


        if (empty($vendorBusinessCategoryDetail)) {
            $this->vendorBusinessCategoryDetailService->makeUpDetailCreate($request);
            return back()->with('success', 'Details save successfully!');
        } else {
            $this->vendorBusinessCategoryDetailService->makeUpDetailUpdate($request, $vendorBusinessCategoryDetail->id);
            return back()->with('success', 'Details Update successfully!');
        }
    }



    /**
     * Make Invitation Card Detail Save
     */


    public function invitationCardDetailSave(Request $request)
    {

        $vendorBusinessCategoryDetail = VendorBusinessCategoryDetail::where([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
        ])->first();


        if (empty($vendorBusinessCategoryDetail)) {
            $this->vendorBusinessCategoryDetailService->invitationCardDetailCreate($request);
            return back()->with('success', 'Details save successfully!');
        } else {
            $this->vendorBusinessCategoryDetailService->invitationCardDetailUpdate($request, $vendorBusinessCategoryDetail->id);
            return back()->with('success', 'Details Update successfully!');
        }
    }


    public function categoryGallery($id)
    {


        $category = Category::findOrFail($id);
        $user = Auth::user();
        $categories = $user->categories;
        $categoryId = $id;

        $vendorBusinessCategoryGalleries = VendorGallery::where([
            'user_id' => Auth::id(),
            'category_id' => $categoryId,
        ])->get();

        $vendorBusinessCategoryGalleryCount = count($vendorBusinessCategoryGalleries);

        return view('vendor.gallery', compact('categoryId', 'categories', 'vendorBusinessCategoryGalleries', 'vendorBusinessCategoryGalleryCount'));
    }




    /**
     * gallery save
     */
    public function categoryGallerySave(Request $request)
    {

        $this->galleryService->create($request);
        return back()->with('success', 'Gallery Add Successfully!');
    }


    /**
     * delete gallery
     */

    public function destroy($id)
    {
        $vendorGallery = VendorGallery::findOrFail($id);
        $vendorGallery->delete();
        return back()->with('success', 'Gallery Delete Successfully!');
    }




    /**
     * Category About
     */

    public function categoryAbout($id)
    {

        $category = Category::findOrFail($id);
        $user = Auth::user();
        $categories = $user->categories;
        $categoryId = $id;

        // if($category->name == 'Venue Categories' || $category->name == 'Catering' || $category->name == 'Decorator' || $category->name == 'Photography & Videography' || $category->name == 'Make Up Artist')
        // {
        $vendorBusinessCategoryAbout = VendorBusinessCategoryAbout::where([
            'user_id' => Auth::id(),
            'category_id' => $categoryId,
        ])->first();

        return view('vendor.venues.about', compact('categoryId', 'categories', 'vendorBusinessCategoryAbout'));
        //}

    }

    /**
     * venue about save
     */
    public function categoryAboutSave(Request $request)
    {

        $vendorBusinessCategoryAbout = VendorBusinessCategoryAbout::where([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
        ])->first();


        if (empty($vendorBusinessCategoryAbout)) {
            $this->vendorBusinessCategoryAboutService->venueCreate($request);
            return back()->with('success', 'About Add Successfully!');
        } else {
            $this->vendorBusinessCategoryAboutService->venueUpdate($request, $vendorBusinessCategoryAbout->id);
            return back()->with('success', 'About Update Successfully!');
        }
    }




    /**
     * category wise booking dates
     */
    public function bookingDate($id)
    {

        $category = Category::findOrFail($id);
        $user = Auth::user();
        $categories = $user->categories;
        $categoryId = $id;

        $prodectDetialId = VendorBusinessCategoryDetail::where(['user_id' => $user->id, 'category_id' => $categoryId])->first();

        // print_r($prodectDetialId);
        // die;


        // // if($category->name == 'Venue Categories' || $category->name == 'Catering' || $category->name == 'Decorator' || $category->name == 'Photography & Videography' || $category->name == 'Make Up Artist')
        // // {
        // $vendorBusinessCategoryAbout = VendorBusinessCategoryAbout::where([
        //     'user_id' => Auth::id(),
        //     'category_id' => $categoryId,
        // ])->first();
        $disabledDates = BookingDate::where(['status' => '1', 'user_id' => $user->id, 'category_id' =>  $categoryId])->pluck('booking_date')->toArray();

        $bookedProducts = BookingDate::where(['status' => '1', 'user_id' => $user->id, 'category_id' =>  $categoryId])->get();

        $bookedDate = [];
        foreach ($bookedProducts as $bookedProduct) {

            $bookedDate[] = [
                'title' => 'Booked',
                'start' => $bookedProduct->booking_date,
                'end' => $bookedProduct->booking_date,

            ];
        }


        return view('vendor.bookingDate', compact('categoryId', 'categories', 'disabledDates', 'bookedDate', 'prodectDetialId'));
    }

    /**
     * category wise booking dates
     */
    public function bookingDateSave(Request $request)
    {

        $user = Auth::user();
        BookingDate::create([
            'user_id' => $user->id,
            'vendor_business_category_detail_id' => $request->product_detial_id,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'booking_date' => $request->booking_date,
            'status' => '1'
        ]);

        return back()->with('success', 'your booking successfull');
    }

    /**
     * vendor Booking Inquiry
     */


    public function bookingInquiry()
    {
        $userId = Auth::id();
        $inquires = UserEnquirie::where('user_id', $userId)->orderBy('id', 'desc')->get();

        return view('vendor.bookingInquiry', compact('inquires'));
    }


    /**
     * admin Booking Inquiry
     */


    public function adminBookingInquiry()
    {

        $inquires = UserEnquirie::orderBy('id', 'desc')->get();
        return view('backend.bookingInquiry', compact('inquires'));
    }





    public function changeInquiryStatusActive($id)
    {
        $inquiry = UserEnquirie::findOrFail($id);
        $inquiry->status = '1';
        $inquiry->save();
        return back()->with('success', 'Iayment Status has been changed');
    }

    public function changeInquiryStatusInActive($id)
    {
        $inquiry = UserEnquirie::findOrFail($id);
        $inquiry->status = '0';
        $inquiry->save();
        return back()->with('success', 'Inquiry Status has been changed');
    }



    /*
      * Category About
     */

    public function package($id)
    {

        $category = Category::findOrFail($id);
        $user = Auth::user();
        $categories = $user->categories;
        $categoryId = $id;

        $package =  Package::where(['user_id' => $user->id, 'category_id' => $categoryId])->first();

        return view('vendor.packeg.create', compact('categoryId', 'categories', 'package'));
    }


    public function storePackage(Request $request)
    {
        $user = Auth::user();
        $package =  Package::where(['user_id' => $user->id, 'category_id' => $request->category_id])->first();
        if (!empty($package)) {

            if (!empty($request->file('image_path'))) {

                $packageImagePath = [];

                foreach ($request->file('image_path') as $image) {


                    $uuid = Str::uuid()->toString();
                    $extension = $image->extension();
                    $fileName = $uuid . 'package';
                    $documentPath = 'package';
                    $filePath = $documentPath . '/' . $fileName;

                    $packageImagePath[] = [
                        'file' =>  $filePath,
                        'extension' => $extension
                    ];

                    $storedFilePath = $image->storeAs($documentPath, $fileName, 'public');
                }
            }





            Package::where('id', $package->id)->update([

                'title' => $request->title,
                'image_path' => $packageImagePath ?? $package->image_path,
                'description' => $request->description,
                'price' => $request->price,
                'status' => $request->status,
            ]);

            return back()->with('success', 'Package Update successfully');
        }

        $vendorCategoryProfile = VendorCategoryProfile::where(['user_id' => $user->id, 'category_id' => $request->category_id])->first();
        if (empty($vendorCategoryProfile)) {
            return back()->with('error', 'Please Create Category Business Profile!');
        }





        if (!empty($request->file('image_path'))) {

            $packageImagePath = [];

            foreach ($request->file('image_path') as $image) {


                $uuid = Str::uuid()->toString();
                $extension = $image->extension();
                $fileName = $uuid . 'package';
                $documentPath = 'package';
                $filePath = $documentPath . '/' . $fileName;

                $packageImagePath[] = [
                    'file' =>  $filePath,
                    'extension' => $extension
                ];

                $storedFilePath = $image->storeAs($documentPath, $fileName, 'public');
            }
        }



        $slug = Str::slug($vendorCategoryProfile->business_profile_name) . '_' . Str::uuid()->toString();

        Package::create([
            'user_id' => $user->id,
            'category_id' => $request->category_id,
            'vendor_category_profile_id' => $vendorCategoryProfile->id,
            'title' => $request->title,
            'image_path' => $packageImagePath ?? null,
            'description' => $request->description,
            'price' => $request->price,
            'slug' => $slug,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Package create successfully');
    }

    public function bookingListing()
    {
        $userId = Auth::id();
        $categoryId = Auth::user()->categories->pluck('id')->toArray();
        $categories = Category::whereIn('id', $categoryId)->where('status', '1')->get();
        $orders = OrderItem::where('vendor_id', $userId)->with('order')->get();
        // print_r($orders);
        // die;
        return view('vendor.bookingListing', compact('orders', 'categories'));
    }




    public function filterOrder(Request $request)
    {

        $userId = Auth::id();
        $categoryId = Auth::user()->categories->pluck('id')->toArray();
        $categories = Category::whereIn('id', $categoryId)->where('status', '1')->get();


        if ($request->category_id == '' && $request->payment_status == '' && $request->order_status == '' && $request->from_date == '' && $request->to_date == '') {

            $orders = OrderItem::where('vendor_id', $userId)->with('order')->get();

            return view('vendor.bookingListing', compact('orders', 'categories'));
        }


        //filter by only dates
        if ($request->category_id == '' && $request->payment_status == '' && $request->order_status == '' || $request->from_date != '' || $request->to_date != '') {


            $query = BookingDate::where(['type' => 'booking', 'user_id' => $userId]);


            if (!empty($request->from_date)) {

                $query->where('booking_date', '>=', $request->from_date);
            }


            if (!empty($request->to_date)) {
                $query->where('booking_date', '<=', $request->to_date);
            }
            $orderIds = $query->pluck('order_id')->toArray();





            $orderItems = OrderItem::whereIn('order_id', $orderIds)->where('vendor_id', $userId);




            if ($request->order_status != '') {
                $orderItems->where('status', $request->order_status);
            }



            if ($request->category_id != '') {
                $orders = $orderItems->where('category_id', $request->category_id);
            }



            $orders = $orderItems->with(['order' => function ($query) use ($request) {
                if ($request->payment_status != '') {
                    $query->where('payment_status', $request->payment_status);
                }
            }])->get();






            if ($orders->isNotEmpty()) {
                // Both conditions are true, you can use $orders for further processing
                $orders = $orders;
            } else {
                // Conditions are not met, handle accordingly
                $orders = [];
            }



            return view('vendor.bookingListing', compact('orders', 'categories'));
        }



        if ($request->category_id != '' || $request->payment_status != '' || $request->order_status != '') {

            $orderItems = OrderItem::where('vendor_id', $userId);

            if ($request->order_status != '') {
                $orderItems->where('status', $request->order_status);
            }



            if ($request->category_id != '') {
                $orderItems->where('category_id', $request->category_id);
            }

            $orders = $orderItems->with(['order' => function ($query) use ($request) {

                if ($request->payment_status != '') {
                    $query->where('payment_status', $request->payment_status);
                }
            }])->get();



            return view('vendor.bookingListing', compact('orders', 'categories'));
        }



        return view('vendor.bookingListing', compact('orders', 'categories'));
    }


    /**
     * booking confirm
     */

    public function changeBookingStatusActive($id)
    {
        $orderItem = OrderItem::findOrFail($id);
        BookingDate::where([
            'user_id' => $orderItem->vendor_id,
            'category_id' => $orderItem->category_id,
            'booking_user_id' => $orderItem->user_id,
            'vendor_business_category_detail_id' => $orderItem->vendor_business_category_detail_id,
            'type' => 'booking'
        ])->update(['status' => '1']);

        $orderItem->status = '1';
        $orderItem->save();
        return back()->with('success', 'status has changed');
    }


    public function changeBookingStatusInActive($id)
    {
        $orderItem = OrderItem::findOrFail($id);
        BookingDate::where([
            'user_id' => $orderItem->vendor_id,
            'category_id' => $orderItem->category_id,
            'booking_user_id' => $orderItem->user_id,
            'vendor_business_category_detail_id' => $orderItem->vendor_business_category_detail_id,
            'type' => 'booking'
        ])->update(['status' => '0']);

        $orderItem->status = '0';
        $orderItem->save();
        return back()->with('success', 'status has changed');
    }
}
