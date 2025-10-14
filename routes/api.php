<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\VendorController;
use App\Http\Controllers\Api\AstrologerController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CommunicationController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


//astro

Route::post('/astro-login', [AstrologerController::class, 'login']);
Route::get('/astro-login-error', [AstrologerController::class, 'loginError'])->name('astro.login');

Route::post('/login-verify-otp', [AstrologerController::class, 'loginVerifyOtp']);

//Route::get('/data-migration', [UserController::class, 'dataMigration']);

   
    Route::post('/communication-charges-update', [UserController::class, 'communicationChargesUpdate']);


Route::middleware(['auth:sanctum', 'astrologer.online'])->group(function () {
    // apk version update
    Route::post('/astro-version-update', [AstrologerController::class, 'versionUpdate']);
    Route::post('/user-version-update', [UserController::class, 'versionUpdate']);
        
    Route::get('/get-communication-request', [CommunicationController::class, 'getCommunicationRequest']);
    Route::post('/astro-create-profile', [AstrologerController::class, 'createProfile']);
    Route::get('/astro-profile', [AstrologerController::class, 'profile']);
    Route::get('/user-profile-data', [UserController::class, 'profile']);
    Route::get('/astro-logout', [AstrologerController::class, 'logout']);
    Route::post('/astro-personal-details', [AstrologerController::class, 'personalDetail']);
    Route::post('/astro-professional-details', [AstrologerController::class, 'professionalDetail']);
    Route::post('/astro-bank-details', [AstrologerController::class, 'bankDetail']);
    Route::post('/astro-profile-image-update', [AstrologerController::class, 'profileImageUpdate']);
    Route::post('/astro-profile-update', [AstrologerController::class, 'profileUpdate']);
    Route::post('/astro-certificate-delete', [AstrologerController::class, 'certificateDelete']);
    Route::post('/astro-ramedy-create', [AstrologerController::class, 'ramedyCreate']);
    

    






    //bank
    Route::post('/astro-add-bank', [AstrologerController::class, 'addBank']);
    Route::get('/astro-banks', [AstrologerController::class, 'bank']);
    Route::post('/astro-update-bank', [AstrologerController::class, 'UpdateBank']);
    Route::post('/astro-bank-delete', [AstrologerController::class, 'deleteBank']);
    Route::post('/astro-bank-primary', [AstrologerController::class, 'primaryBank']);

    Route::post('/astro-notifaction-token', [AstrologerController::class, 'sendAstroNotifactionToken']);
    Route::post('/update-certificates', [AstrologerController::class, 'updateCertificate']);
    //review list
    Route::get('/astro-review-list', [AstrologerController::class, 'astroReviewListing']);
    Route::get('/my-follower', [AstrologerController::class, 'myFollower']);


    //payout

    Route::get('/astrologer-payouts', [AstrologerController::class, 'payout']);



    //Onboarding Questions

    Route::get('/onboarding-questions', [AstrologerController::class, 'onboardingQuestions']);
    Route::post('/onboarding-answer', [AstrologerController::class, 'onboardingAnswer']);

    //coupon
    Route::get('/list-coupon', [AstrologerController::class, 'couponList']);
    Route::post('/coupon-active', [AstrologerController::class, 'activeCoupon']);
    Route::post('/coupon-de-active', [AstrologerController::class, 'deActiveCoupon']);

    //get communication request




    Route::get('/all-communication-request', [CommunicationController::class, 'allCommunicationRequest']);

    //Route::get('/get-communication-call-request', [CommunicationController::class, 'getCommunicationCallRequest']);

    Route::post('/update-communication-status', [CommunicationController::class, 'updateCommunicationStatus']);
    Route::get('/todat-communication-log', [CommunicationController::class, 'todayCommunicationLog']);
    Route::get('/chat-log', [CommunicationController::class, 'chatLog']);

    Route::get('/call-log', [CommunicationController::class, 'callLog']);

    Route::post('/mark-online-or-offline', [AstrologerController::class, 'markOnlineOrOffline']);
    //
    Route::get('/user-profile-details', [UserController::class, 'profile']);
    Route::get('/filter-pending-user', [UserController::class, 'filterPendinUser']);
    Route::get('/my-payment-history', [CommunicationController::class, 'myPaymentHistory']);
    Route::post('/raise-an-issue', [AstrologerController::class, 'raiseAnIssue']);

    Route::get('/astrologer-communicatin-all-data-count', [CommunicationController::class, 'astrologerRecords']);

    //Astrologer histroy store
    Route::post('/astrologer-live-charges', [AstrologerController::class, 'astrologerLive']);
    Route::get('/astrologer-live-histories', [AstrologerController::class, 'astrologerLiveHistory']);
    Route::post('/astrologer-boost', [AstrologerController::class, 'astrologerBoost']);
    Route::post('/astro-signal-notifaction-send', [AstrologerController::class, 'signalNotifaction']);
    
    //communication charges update


    
    

});




//user 



Route::post('/user-login', [UserController::class, 'login']);
Route::post('/user-login-verify-otp', [UserController::class, 'loginVerifyOtp']);
Route::post('/user-resend-otp', [UserController::class, 'userResendOtp']);
Route::post('app-version', [UserController::class, 'version']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user-profile', [UserController::class, 'profile']);
    Route::post('/user-create-profile', [UserController::class, 'createProfile']);
    Route::post('/user-logout', [UserController::class, 'logout']);
    Route::get('/list-user', [UserController::class, 'listUser']);
    Route::post('/user-signal-notifaction-send', [UserController::class, 'signalNotifaction']);
    
    Route::post('/user-profile-update', [UserController::class, 'profileUpdate']);
    Route::get('/banners', [UserController::class, 'banner']);
    Route::get('/blogs', [UserController::class, 'blog']);
    Route::post('/blog-details', [UserController::class, 'blogDetails']);
    Route::get('/list-astrologer', [UserController::class, 'listAstrologer']);
    Route::get('/online-astrologer', [UserController::class, 'onlineAstrologer']);
    Route::post('/astrologer-details', [UserController::class, 'astrologerDetails']);
    Route::post('/give-review', [UserController::class, 'givReview']);
    Route::post('/contact-us', [UserController::class, 'contact']);
    Route::post('/follow', [UserController::class, 'follow']);
    Route::post('/my-following', [UserController::class, 'myFollowing']);
    Route::post('/send-user-notifaction-token', [UserController::class, 'sendUserNotifactionToken']);
    Route::post('/unfollow', [UserController::class, 'unfollow']);
    Route::get('/list-celebrity', [UserController::class, 'celebrity']);

    //CommunicationController

    Route::post('/wallet-payment', [UserController::class, 'createPayment']);
    Route::post('/user-wallet-history', [UserController::class, 'walletHistory']);


    //testmonial


    Route::get('/list-testimonial', [UserController::class, 'testimonial']);

    Route::get('/user-call-log', [UserController::class, 'userCallLog']);

    //ramedy
    Route::get('/list-ramedy', [UserController::class, 'listRamedy']);
    
    
    Route::post('/communication-charges', [UserController::class, 'communicationCharges']);
    Route::post('/send-communication-request', [CommunicationController::class, 'sendRequest']);
    
    Route::get('/user-pending-request', [UserController::class, 'userPendingRequest']);
    
    Route::post('/user-pending-request-cancel', [UserController::class, 'userPendingRequestCancel']);
    Route::get('/user-chat-log', [UserController::class, 'userChatLog']);

    
});

//login with google

Route::post('/login-with-google', [UserController::class, 'loginWithGoogle']);
Route::post('/login-with-facebook', [UserController::class, 'loginWithFacebook']);






//////////////////////////////////////////////////////////////////////

//Route::post('/vendor-login', [AuthController::class, 'vendorLogin']);











//vendor end

//user register
//Route::post('/user-register', [AuthController::class, 'register']);

// //login with otp
// Route::post('/login-with-otp', [AuthController::class, 'loginWithOtp']);
// Route::post('/login-verify-otp', [AuthController::class, 'loginVerifyOtp']);

//Home Page

// Route::get('/banner', [HomeController::class, 'banner']);
// Route::get('/vendor-categories', [HomeController::class, 'vendorCategorie']);
// Route::get('/sub-categories', [HomeController::class, 'subCategorie']);
// Route::get('/trusted-vendor', [HomeController::class, 'trustedVendor']);
// Route::get('/blogs', [HomeController::class, 'blog']);
// Route::get('/blog-details', [HomeController::class, 'blogDetails']);
// Route::get('/states', [HomeController::class, 'state']);
// Route::get('/cities', [HomeController::class, 'city']);
// Route::get('/areas', [HomeController::class, 'area']);
// Route::get('/real-weddings', [HomeController::class, 'realWedding']);
// Route::get('/real-wedding-details', [HomeController::class, 'realWeddingDetails']);
// Route::get('/venues', [HomeController::class, 'venue']);
// Route::get('/product-detial', [HomeController::class, 'productDetial']);
// Route::post('/contact-us', [HomeController::class, 'contactUs']);
// Route::get('/products', [HomeController::class, 'product']);
// Route::get('/product-filter', [HomeController::class, 'productFilter']);






// Route::get('/sub-category-wise-filter', [HomeController::class, 'subCategoryFilter']);




// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/add-product-review', [HomeController::class, 'addProductReview']);
//     Route::post('/add-to-cart', [HomeController::class, 'addToCart']);
//     Route::get('/list-user-cart-item', [HomeController::class, 'userCartItemList']);
//     Route::get('/remove-item-to-cart', [HomeController::class, 'removeItem']);

//     Route::post('/wishlist', [HomeController::class, 'wishlist']);
//     Route::get('/user-wishlist-listing', [HomeController::class, 'userWishlistListing']);
//     Route::get('/user-details', [HomeController::class, 'userDetail']);
//     Route::post('/user-profile-update', [HomeController::class, 'updateUserDetail']);
//     Route::post('/order-item', [HomeController::class, 'itemsOrder']);
//     Route::get('/purchased-items', [HomeController::class, 'purchase']);
//     Route::get('/user-logout', [AuthController::class, 'logout']);


//vendor start


// Route::get('/vendor-category-listing', [VendorController::class, 'categoryListing']);
// Route::post('/business-about', [VendorController::class, 'categoryAboutSave']);
// Route::get('/get-about-about', [VendorController::class, 'getAboutSection']);
// Route::post('/vendor-category-profile-save', [VendorController::class, 'categoryProfileSave']);
// Route::get('/get-category-profile', [VendorController::class, 'getCategoryProfile']);
// Route::post('/save-gallery-image', [VendorController::class, 'saveGallery']);
// Route::get('/get-business-category-gallery', [VendorController::class, 'getBusinessCategoryGallery']);
// Route::get('/destroy-gallery', [VendorController::class, 'destroyGallery']);



//save business detial
//     Route::post('/venue-business-detial-save', [VendorController::class, 'venueBusinessDetialSave']);
//     Route::get('/get-venue-business-detial', [VendorController::class, 'getVenueBusinessDetial']);
//     Route::post('/decorator-detail-save', [VendorController::class, 'decoratorDetailSave']);
//     Route::get('/get-decorator-detail', [VendorController::class, 'getDecoratorDetial']);
//     Route::post('/catering-detail-save', [VendorController::class, 'cateringDetailSave']);
//     Route::get('/get-catering-detail', [VendorController::class, 'getCateringDetial']);
//     Route::post('/invitation-card-detail-save', [VendorController::class, 'invitationCardDetailSave']);
//     Route::get('/get-invitation-card-detai', [VendorController::class, 'invitationCardDetai']);
//     Route::post('/make-up-detail-save', [VendorController::class, 'makeUpDetailSave']);
//     Route::get('/get-make-up-detail', [VendorController::class, 'makeUpDetail']);
//     Route::post('/photography-detail-save', [VendorController::class, 'photographyDetailSave']);
//     Route::get('/get-photography-detail', [VendorController::class, 'photographyDetail']);
//     Route::post('/booking-date-save', [VendorController::class, 'bookingDateSave']);
//     Route::get('/get-booking-date', [VendorController::class, 'bookingDate']);
//     Route::get('/get-booking-listing', [VendorController::class, 'bookingListing']);
//     Route::get('/filter-vendor-order', [VendorController::class, 'filterVendorOrder']);
//     Route::post('/change-booking-status', [VendorController::class, 'changeBookingStatus']);
//     Route::post('/save-package', [VendorController::class, 'savePackage']);
//     Route::get('/get-package', [VendorController::class, 'getPackage']);



//     //vendor end
// });


//venue filter
//Route::get('/venue-filter-list', [HomeController::class, 'venueFilter']);
