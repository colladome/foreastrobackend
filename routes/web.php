<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\BookingEnquirieController;
use App\Http\Controllers\AstrologerController;







/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


//login with google

Route::get('/auth/google', [UserAuthController::class, 'loginWithGoogle'])->name('loginWithGoogle');
Route::get('/auth/google/callback', [UserAuthController::class, 'callbackFromGoogle'])->name('callbackFromGoogle');
//auth

    Route::get('/refund-policy', [HomeController::class, 'refund'])->name('refund');


Route::get('/user-login-page', [UserAuthController::class, 'index'])->name('login');
Route::post('/user-otp-page', [UserAuthController::class, 'otp'])->name('otp');
Route::post('/user-otp-verify', [UserAuthController::class, 'verifyOtp'])->name('verifyOtp');
Route::group(['middleware' => ['user']], function () {
    Route::get('/user-dashboard', [UserAuthController::class, 'userDashboard'])->name('userDashboard');
    Route::get('/user-logout', [UserAuthController::class, 'logout'])->name('user.logout');
    Route::get('/user-profile', [HomeController::class, 'profile'])->name('profile');
    Route::post('/user-profile-update/{id}', [HomeController::class, 'profileUpdate'])->name('profileUpdate');
    Route::get('/user-purchase', [BookingEnquirieController::class, 'purchase'])->name('purchase');
    Route::post('/toggle-wishlist', [HomeController::class, 'toggleWishlist'])->name('toggleWishlist');
    Route::get('/user-wishlist', [HomeController::class, 'userWishlist'])->name('userWishlist');
    Route::post('/user-enquirie', [BookingEnquirieController::class, 'create'])->name('userUnquirie.create');
    //cart
    Route::post('/add-to-cart', [BookingEnquirieController::class, 'addCart'])->name('addCart');
    Route::get('/cart', [BookingEnquirieController::class, 'cart'])->name('cart');
    Route::get('/remove-item/{id}', [BookingEnquirieController::class, 'removeItem'])->name('removeItem');
    Route::get('/checkout', [BookingEnquirieController::class, 'checkout'])->name('checkout');
    Route::post('/items-order', [BookingEnquirieController::class, 'itemsOrder'])->name('itemsOrder');
    Route::post('/write-review', [HomeController::class, 'writeReview'])->name('writeReview');





    // itemsOrder
});

Route::get('/user-real-weddings', [HomeController::class, 'realWedding'])->name('realWedding');
Route::get('/user-real-wedding-detial/{id}', [HomeController::class, 'RealWeddingDetialPage'])->name('RealWeddingDetialPage');

Route::get('/user-vendor-listing', [HomeController::class, 'vendorListing'])->name('vendorListing');
Route::get('/product-detial/{id}', [HomeController::class, 'productDetial'])->name('productDetial');

Route::get('/packages', [HomeController::class, 'packageListing'])->name('packageListing');
Route::get('/package-detial/{package}/{id}', [HomeController::class, 'packageDetial'])->name('packageDetial');
Route::get('/filter-product-wise/{category}', [HomeController::class, 'filterProductWise'])->name('filterProductWise');




//vendorProduct






Route::post('/user-store', [UserAuthController::class, 'store'])->name('user.store');


Route::get('/venue-filter', [HomeController::class, 'venueFilter'])->name('venueFilter');



Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/terms-of-use', [HomeController::class, 'terms'])->name('terms');
Route::get('/privacy-policy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/user-privacy-policy', [HomeController::class, 'userPrivacy'])->name('userPrivacy');

Route::get('/about-us', [HomeController::class, 'aboutUs'])->name('aboutUs');


Route::get('/our-services', [HomeController::class, 'productAndSolution'])->name('productAndSolution');


Route::get('/blogs', [HomeController::class, 'blog'])->name('blog');
Route::get('/blog-detail/{slug}', [HomeController::class, 'blogDetail'])->name('blogDetail');
Route::get('/contact-us', [HomeController::class, 'contactPage'])->name('contactPage');
Route::post('/user-contact', [HomeController::class, 'contactUs'])->name('contactUs');
Route::get('/photos', [HomeController::class, 'photo'])->name('photo');
Route::get('/filter-photos/{id}', [HomeController::class, 'filterPhoto'])->name('filterPhoto');
Route::get('/filter-venu-date', [HomeController::class, 'filterVanueWithDate'])->name('filterVanueWithDate');
Route::get('/vendor-product/{id}', [HomeController::class, 'vendorProduct'])->name('vendorProduct');
Route::get('/product-filter', [HomeController::class, 'productFilter'])->name('productFilter');
//for change
