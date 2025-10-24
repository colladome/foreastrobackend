<?php

namespace App\Http\Controllers;

use App\Models\Astrologer;
use App\Models\Backend\Area;
use App\Models\Backend\Banner;
use App\Models\Backend\Category;
use App\Models\Vendor\VendorBusinessCategoryDetail;
use App\Models\Backend\Blog;
use App\Models\Backend\City;
use App\Models\Backend\Photo;
use App\Models\Backend\RealWedding;
use App\Models\Backend\State;
use App\Models\BookingDate;
use App\Models\Cart;
use App\Models\CmsManagement;
use App\Models\User;
use App\Models\Contact;
use App\Models\Review;
use App\Models\Testimonial;
use App\Models\Wishlist;
use App\Models\UserProfile;
use App\Models\Vendor\Package;

use App\Models\AstrologerLive;
use App\Models\Boost;
use App\Models\Payout;

use Illuminate\Http\Request;
use App\Models\File;
use Illuminate\Support\Facades\Auth;
use App\Models\Vendor\VendorCategoryProfile;
use App\Models\Vendor\VendorGallery;
use App\Models\Communication;
use App\Models\Vendor\VendorBusinessCategoryAbout;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{

    /**
     * home page
     */

    public function index()
    {



        $astrologers = Astrologer::where('profile_status', 'approved')->inRandomOrder()->limit(20)->get();

        $listAstrologer1 = [];
        $listAstrologer2 = [];

        foreach ($astrologers as $astrologer) {
            
            
            
            
          
            
            
            
            
            
            
             $imageFile = File::where(['type' => 'astro_profile_image', 'other_id' => $astrologer->id, 'status' => '1'])->first();
            if (!empty($imageFile)) {
                $profileImage = url(Storage::url($imageFile->path));
            } else {
                $profileImage = 'https://foreastro.com/assets/frontend/img/logo.png';
            }


            $currentTime = Carbon::now();
            $timeToCompare = Carbon::parse($astrologer->expire_at);

            if (isset($astrologer->expire_at) && $timeToCompare->greaterThan($currentTime) && $astrologer->is_online == 'online') {


                $astrologerOnlineStatus  = 'online';
                $listAstrologer1[] = [
                    'id' => $astrologer->id,
                    'name' => $astrologer->name,
                    'profile_img' => $profileImage,
                    'experience' => $astrologer->experience,
                    'rating' => '0.0',
                    'languaage' => $astrologer->languaage,
                    'specialization' =>  $astrologer->specialization,
                    'chat_charges_per_min' =>  $astrologer->chat_charges_per_min,
                    'call_charges_per_min' =>  $astrologer->call_charges_per_min,
                    'video_charges_per_min' =>  $astrologer->video_charges_per_min,
                    'is_online' => $astrologerOnlineStatus,

                    'notifaction_token' => $astrologer->notifaction_token

                ];


                // online
                //Astrologer online status Expired

            } else {
                // offline
                //Astrologer online status Expired
                $astrologerOnlineStatus  = 'ofnline';

                $listAstrologer2[] = [
                    'id' => $astrologer->id,
                    'name' => $astrologer->name,
                    'profile_img' => $profileImage,
                    'experience' => $astrologer->experience,
                    'rating' => $astrologer->total_rating,
                    'languaage' => $astrologer->languaage,
                    'specialization' =>  $astrologer->specialization,
                    'chat_charges_per_min' =>  $astrologer->chat_charges_per_min,
                    'call_charges_per_min' =>  $astrologer->call_charges_per_min,
                    'video_charges_per_min' =>  $astrologer->video_charges_per_min,
                    'is_online' => $astrologerOnlineStatus,

                    'notifaction_token' => $astrologer->notifaction_token

                ];
            }
        }

        $listAstrologers = array_merge($listAstrologer1, $listAstrologer2);




        //testmoinal


        $testimonials = Testimonial::orderBy('id', 'desc')->get();

        $testimonialList = [];

        foreach ($testimonials as $testimonial) {

            $testimonialList[] = [
                'name' => $testimonial->name,
                'imagee' => url(Storage::url($testimonial->image)),
                'rating' => $testimonial->rating,
                'comment' => $testimonial->descreption,
            ];
        }

        $blogs = Blog::where('status', '1')->orderBy('id', 'desc')->take(3)->get();


        $blogListing = [];

        foreach ($blogs as $blog) {
            $blogListing[] =  [
                'id' => $blog->id,
                'title' => $blog->title,
                'description' => $blog->description,
                'slug' => $blog->slug,
                'image' => url(Storage::url($blog->image['file'])),
                'date' => Carbon::parse($blog->created_at)->format('j M Y')

            ];
        }

        return view('frontend.home', compact('listAstrologers', 'testimonialList', 'blogListing'));
    }
    
    
    
    
    public function refund()
    {
    return view('frontend.refund');

    }









    public function privacy()
    {
        $cms = CmsManagement::orderby('id', 'desc')->first();
        return view('frontend.privacy', compact('cms'));
    }



    public function userPrivacy()
    {
        $cms = CmsManagement::orderby('id', 'desc')->first();
        return view('frontend.userprivacy', compact('cms'));
    }



    


    public function terms()
    {
        $cms = CmsManagement::orderby('id', 'desc')->first();
        return view('frontend.terms', compact('cms'));
    }


    /**
     * aubot us
     */

    public function aboutUs()
    {
        return view('frontend.aboutUs');
    }




    public function productAndSolution()
    {
        return view('frontend.product_and_solution');
    }

    /**
     * Blogs
     */

    public function blog(Request $request)
    {
        $blogs = Blog::where('status', '1')->orderBy('id', 'desc')->get();


        $blogListing = [];

        foreach ($blogs as $blog) {
            $blogListing[] =  [
                'id' => $blog->id,
                'title' => $blog->title,
                'description' => $blog->description,
                'slug' => $blog->slug,
                'image' => url(Storage::url($blog->image['file'])),
                'date' => Carbon::parse($blog->created_at)->format('j M Y')

            ];
        }



        return view('frontend.blog', compact('blogListing'));
    }


    public function blogDetail($slug)
    {

        $blog = Blog::where('slug', $slug)->first();
        $metaTitle = $blog->meta_title ?: config('app.name');
        $image = url(Storage::url($blog->image['file']));
        $date = Carbon::parse($blog->created_at)->format('j M Y');
        
        
         $blogs = Blog::where('status', '1')->orderBy('id', 'desc')->take(3)->get();


        $blogListing = [];

        foreach ($blogs as $blog) {
            $blogListing[] =  [
                'id' => $blog->id,
                'title' => $blog->title,
                'description' => $blog->description,
                'slug' => $blog->slug,
                'image' => url(Storage::url($blog->image['file'])),
                'date' => Carbon::parse($blog->created_at)->format('j M Y')

            ];
        }
        
        
        
        return view('frontend.blogdeatial', compact('blog', 'image', 'date','blogListing'));
    }


    /**
     * contact us
     */

    public function contactUs(Request $request)
    {

        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'descreption' => $request->descreption,

        ]);

        return back()->with('success', 'We contact you shortly!');
    }

    public function contactPage()
    {
        return view('frontend.contact');
    }

    public function profile()
    {
        $user = Auth::user();
        $user = User::where('id', $user->id)->with('userProfile')->first();
        $states = State::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $areas = Area::orderBy('name')->get();
        return view('frontend.profile', compact('user', 'states', 'cities', 'areas'));
    }

    public function profileUpdate(Request $request, $id)
    {



        User::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile_number' => $request->mobile_number,
        ]);



        UserProfile::where('user_id', $id)->update([
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'area_id' => $request->area_id,
            'address' => $request->address,
            'pin_code' => $request->pin_code,
        ]);

        return back()->with('success', 'Profile update successfully!');
    }








    public function realWedding()
    {
        $user = Auth::user();
        $realWeddings = RealWedding::orderBy('id', 'Desc')->get();
        return view('frontend.realWedding', compact('user', 'realWeddings'));
    }


    public function vendorListing()
    {
        $categories = Category::orderBy('name')->get();
        $category = Category::where('name', 'Venue Categories')->first();
        $decorator = Category::where('name', 'Decorator')->first();

        $venueCategories = VendorBusinessCategoryDetail::with('venueSpaces', 'vendorBusinessProfile')->where('category_id', $category->id)->get();
        $decoratorCategories = VendorBusinessCategoryDetail::with('vendorBusinessProfile')->where('category_id', $decorator->id)->get();

        return view('frontend.vendor', compact('categories', 'venueCategories', 'decoratorCategories'));
    }

    /**
     * product detials
     */
    public function productDetial($id)
    {
        $userId = Auth::id();
        $productDetial = VendorBusinessCategoryDetail::with('venueSpaces', 'vendorBusinessProfile', 'category')->where('id', $id)->first();
        $vendorAbout = VendorBusinessCategoryAbout::where(['user_id' => $productDetial->user_id, 'category_id' => $productDetial->category_id])->first();
        $galleries = VendorGallery::where(['user_id' => $productDetial->user_id, 'category_id' => $productDetial->category_id])->get();

        $disabledDates = BookingDate::where(['vendor_business_category_detail_id' => $id, 'status' => '1'])->pluck('booking_date')->toArray();
        $review = Review::where(['user_id' =>  $userId, 'vendor_business_category_detail_id' => $id])->first();



        $avregeReview = Review::where(['vendor_business_category_detail_id' => $id, 'status' => '1'])->average('rating');
        $reviewCount = Review::where(['vendor_business_category_detail_id' => $id, 'status' => '1'])->count();
        $allRating = Review::where(['vendor_business_category_detail_id' => $id, 'status' => '1'])->count();
        //one star rating percentage
        $oneStarRating = Review::where(['vendor_business_category_detail_id' => $id, 'status' => '1', 'rating' => '1'])->count();



        $totalOneRatingPer = $allRating != 0 ? ($oneStarRating * 100) / $allRating : 0;




        //two star rating percentage
        $twoStarRating = Review::where(['vendor_business_category_detail_id' => $id, 'status' => '1', 'rating' => '2'])->count();

        $totalTwoRatingPer =  $allRating != 0 ? ($twoStarRating * 100) / $allRating : 0;


        //three star rating percentage
        $threeStarRating = Review::where(['vendor_business_category_detail_id' => $id, 'status' => '1', 'rating' => '3'])->count();

        $totalThreeRatingPer =  $allRating != 0 ? ($threeStarRating * 100) / $allRating : 0;


        //four star rating percentage
        $fourStarRating = Review::where(['vendor_business_category_detail_id' => $id, 'status' => '1', 'rating' => '4'])->count();

        $totalFourRatingPer =  $allRating != 0 ? ($fourStarRating * 100) / $allRating : 0;


        //five star rating percentage

        $fiveStarRating = Review::where(['vendor_business_category_detail_id' => $id, 'status' => '1', 'rating' => '4'])->count();

        $totalFiveRatingPer =  $allRating != 0 ? ($fiveStarRating * 100) / $allRating : 0;

        $reviewComments = Review::where(['vendor_business_category_detail_id' => $id, 'status' => '1'])->with('user')->orderBy('id', 'desc')->get();



        return view('frontend.productDetial', compact(
            'productDetial',
            'vendorAbout',
            'galleries',
            'disabledDates',
            'review',
            'avregeReview',
            'reviewCount',
            'oneStarRating',
            'twoStarRating',
            'threeStarRating',
            'fourStarRating',
            'fiveStarRating',
            'totalOneRatingPer',
            'totalTwoRatingPer',
            'totalThreeRatingPer',
            'totalFourRatingPer',
            'totalFiveRatingPer',
            'allRating',
            'reviewComments'
        ));
    }

    /**
     * product Wishlist Add or remove
     */


    public function toggleWishlist(Request $request)
    {


        $user = Auth::user();

        $productId = $request->input('product_id');
        $user = auth()->user();
        $wishlistItem = Wishlist::where('user_id', $user->id)->where('vendor_business_category_detail_id', $productId)->first();

        if ($wishlistItem) {

            $wishlistItem->delete();
            $isInWishlist = false;
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'vendor_business_category_detail_id' => $productId,
            ]);
            $isInWishlist = true;
        }

        return response()->json(['is_in_wishlist' => $isInWishlist]);
    }


    /**
     * venue
     */

    public function userWishlist()
    {
        $user = Auth::user();
        $wishlistId = Wishlist::where('user_id', $user->id)->pluck('vendor_business_category_detail_id')->toArray();
        $venueCategories = VendorBusinessCategoryDetail::with('venueSpaces', 'vendorBusinessProfile', 'wishlist')->whereIn('id', $wishlistId)->get();
        $countVenue = count($venueCategories);


        return view('frontend.wishlist', compact('venueCategories', 'countVenue'));
    }


    /**
     * product filter
     */

    public function productFilter(Request $request)
    {


        //filter using category and city and date
        $bookingDate =  BookingDate::where(['category_id' => $request->category_id, 'status' => '1', 'booking_date' => $request->date])->pluck('vendor_business_category_detail_id')->toArray();

        $productIds = VendorBusinessCategoryDetail::whereNotIn('id', $bookingDate)->pluck('vendor_category_profile_id')->toArray();


        if (!empty($request->category_id) && !empty($request->city_id) && !empty($request->date)) {
            $products = VendorCategoryProfile::whereIn('id', $productIds)->where(['category_id' => $request->category_id, 'city_id' => $request->city_id])
                ->with(['vendorBusinessCategoryDetail' => function ($query) {
                    $query->with('venueSpaces');
                }, 'city', 'category'])->get();
        }

        //filter using category and city


        if (!empty($request->category_id) && !empty($request->city_id) && !isset($request->date)) {
            $products = VendorCategoryProfile::where(['category_id' => $request->category_id, 'city_id' => $request->city_id])
                ->with(['vendorBusinessCategoryDetail' => function ($query) {
                    $query->with('venueSpaces');
                }, 'city', 'category'])->get();
        }



        if (!empty($request->category)) {
            $category = Category::where('name', $request->category)->first();
            $products = VendorCategoryProfile::where(['category_id' => $category->id])
                ->with(['vendorBusinessCategoryDetail' => function ($query) {
                    $query->with('venueSpaces');
                }, 'city', 'category'])->get();
        }

        if ($request->category == 'Venue Categories') {
            if (!empty($request->category) && !empty($request->sub_category)) {
                $subCategory = $request->sub_category;
                $category = Category::where('name', $request->category)->first();
                $products = VendorCategoryProfile::where(['category_id' => $category->id])
                    ->with(['vendorBusinessCategoryDetail' => function ($query) use ($subCategory) {
                        $query->whereJsonContains('venue_criteria', $subCategory)->with('venueSpaces');
                    }, 'city', 'category'])->get();
            }
        } else {


            if (!empty($request->category) && !empty($request->sub_category)) {
                $subCategory = $request->sub_category;
                $category = Category::where('name', $request->category)->first();
                $products = VendorCategoryProfile::where(['category_id' => $category->id])
                    ->with(['vendorBusinessCategoryDetail' => function ($query) use ($subCategory) {
                        $query->whereJsonContains('cuisine_type', $subCategory)->with('venueSpaces');
                    }, 'city', 'category'])->get();
            }
        }

        //$productCount = count($products);


        // die;
        return view('frontend.filter', compact('products'));
    }


    /**
     * Package Listing
     */

    public function packageListing()
    {
        $packeges = Package::with(['vendorBusinessProfile' => function ($query) {
            $query->with('city');
        }])->get();



        $count = count($packeges);

        return view('frontend.packagelist', compact('packeges', 'count'));
    }

    public function packageDetial($pagkage, $slug)
    {
        $packege = Package::where('slug', $slug)->orderBy('id', 'desc')->with(['vendorBusinessProfile' => function ($query) {
            $query->with('city');
        }])->first();

        return view('frontend.packagedetial', compact('packege'));
    }

    public function venueFilter(Request $request)
    {

        $category = Category::where('name', 'Venue Categories')->first();
        // if (isset($request->per_plate)) {
        //     list($minPerPlate, $maxPerPlate) = explode("-", $request->per_plate);
        //     $minPerPlate = (int)$minPerPlate;
        //     $maxPerPlate = (int)$maxPerPlate;
        // }



        if (empty($request->input('venue_criteria'))) {
            $venueCategories = VendorBusinessCategoryDetail::where('venue_criteria', '!=', null)->with('vendorBusinessProfile', 'wishlist')
                ->where('category_id', $category->id)
                ->where(function ($query) use ($request) {
                    $query->orWhereHas('venueSpaces', function ($subQuery) use ($request) {
                        if ($request->has('seating_pax') && $request->input('seating_pax')) {
                            $subQuery->where('seating_pax', $request->input('seating_pax'));
                        }

                        if ($request->has('venue_rent') && $request->input('venue_rent')) {
                            list($min, $max) = explode("-", $request->venue_rent);

                            // Convert the values to integers
                            $min = (int)$min;
                            $max = (int)$max;
                            $subQuery->whereBetween('venue_rent', [$min, $max]);
                        }

                        if ($request->has('venu_type') && $request->input('venu_type')) {
                            $subQuery->where('venu_type', $request->input('venu_type'));
                        }
                    });
                })->orWhereJsonContains('venue_criteria', $request->input('venue_criteria'))
                ->get();
        } else {


            $venueCategories = VendorBusinessCategoryDetail::where('venue_criteria', '!=', null)->with('vendorBusinessProfile', 'wishlist')
                ->where('category_id', $category->id)
                ->where(function ($query) use ($request) {
                    $query->orWhereHas('venueSpaces', function ($subQuery) use ($request) {
                        if ($request->has('seating_pax') && $request->input('seating_pax')) {
                            $subQuery->where('seating_pax', $request->input('seating_pax'));
                        }

                        if ($request->has('venue_rent') && $request->input('venue_rent')) {
                            list($min, $max) = explode("-", $request->venue_rent);

                            // Convert the values to integers
                            $min = (int)$min;
                            $max = (int)$max;
                            $subQuery->whereBetween('venue_rent', [$min, $max]);
                        }

                        if ($request->has('venu_type') && $request->input('venu_type')) {
                            $subQuery->where('venu_type', $request->input('venu_type'));
                        }
                    });
                })->whereJsonContains('venue_criteria', $request->input('venue_criteria'))
                ->get();
        }

        $countVenue = count($venueCategories);


        return view('frontend.venue', compact('venueCategories', 'countVenue'));
    }

    public function filterProductWise($categoryName)
    {

        $category = Category::where('name', $categoryName)->first();
        $products = VendorCategoryProfile::where(['category_id' => $category->id])
            ->with(['vendorBusinessCategoryDetail' => function ($query) {
                $query->with('venueSpaces');
            }, 'city', 'category'])->get();

        return view('frontend.filter', compact('products'));
    }

    //Vendor Product 
    public function vendorProduct($id)
    {

        $products = VendorCategoryProfile::where(['id' => $id])
            ->with(['vendorBusinessCategoryDetail' => function ($query) {
                $query->with('venueSpaces');
            }, 'city', 'category'])->get();

        return view('frontend.filter', compact('products'));
    }



    public function photo()
    {
        $categories = Category::orderBy('name')->get();
        $photos = Photo::get();

        return view('frontend.photo', compact('categories', 'photos'));
    }


    public function filterPhoto($id)
    {
        $categories = Category::orderBy('name')->get();
        $photos = Photo::where('category_id', $id)->get();

        return view('frontend.photo', compact('categories', 'photos'));
    }


    public function RealWeddingDetialPage($id)
    {
        $realWedding = RealWedding::findOrFail($id);
        return view('frontend.realWeddingDetial', compact('realWedding'));
    }

    public function writeReview(Request $request)
    {

        $userId = Auth::id();
        $review = Review::where(['user_id' => $userId, 'vendor_business_category_detail_id' => $request->vendor_business_category_detail_id])->first();

        if (!empty($review)) {
            $review->rating = $request->rating;
            $review->comment = $request->comment;
            $review->save();
            return back()->with('success', 'Thanks For The Review, your Review has been updated!');
        }

        Review::create([
            'user_id' => $userId,
            'vendor_id' => $request->vendor_id,
            'vendor_business_category_detail_id' => $request->vendor_business_category_detail_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Thanks For The Review');
    }

    public function filterVanueWithDate(Request $request)
    {
        $bookingDate =  BookingDate::where(['category_id' => '1', 'status' => '1', 'booking_date' => $request->date])->pluck('vendor_business_category_detail_id')->toArray();

        $venueCategories = VendorBusinessCategoryDetail::whereNotIn('id', $bookingDate)->where('venue_criteria', '!=', null)->with('vendorBusinessProfile', 'wishlist', 'venueSpaces')->get();


        $countVenue = count($venueCategories);
        return view('frontend.venue', compact('venueCategories', 'countVenue'));
    }
}
