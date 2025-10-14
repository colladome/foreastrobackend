<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Vendor\AuthController;
use App\Http\Controllers\Vendor\DashboardController;
use App\Http\Controllers\Vendor\VendorCategoryController;
use App\Http\Controllers\BookingEnquirieController;




Route::get('/vendor', [AuthController::class, 'index'])->name('vendor.index');
Route::get('/vendor/regester', [AuthController::class, 'regester'])->name('vendor.regester');
Route::post('/vendor/regester-store', [AuthController::class, 'store'])->name('vendor.store');



//route::get('/',[AdminController::class, 'adminLoginPage'])->name('admin.adminLoginPage');
route::post('vendor/login', [AuthController::class, 'login'])->name('vendor.login');
route::get('vendor/logout', [AuthController::class, 'logout'])->name('vendor.logout');

Route::group(['middleware' => ['vendor']], function () {
    Route::get('/vendor/dashboard', [DashboardController::class, 'dashboard'])->name('vendor.dashboard');
    Route::get('/vendor/profile', [DashboardController::class, 'profile'])->name('vendor.profile');
    Route::post('/vendor/profile-update/{id}', [DashboardController::class, 'profileUpdate'])->name('vendor.profileUpdate');
    Route::get('/vendor/category-listing', [VendorCategoryController::class, 'categoryListing'])->name('vendor.categoryListing');
    Route::get('/vendor/category-profile', [VendorCategoryController::class, 'categoryProfile'])->name('vendor.categoryProfile');
    Route::post('/vendor/category-profile-save', [VendorCategoryController::class, 'categoryProfileSave'])->name('vendor.categoryProfileSave');

    //vendor category Detail

    Route::get('/vendor/category-Detail/{id}', [VendorCategoryController::class, 'categoryDetail'])->name('vendor.categoryDetail');

    Route::post('/vendor/venue-detail-save', [VendorCategoryController::class, 'venueDetailSave'])->name('vendor.categoryDetailSave');

    Route::post('/vendor/catering-detail-save', [VendorCategoryController::class, 'cateringDetailSave'])->name('vendor.cateringDetailSave');

    Route::post('/vendor/decorator-detail-save', [VendorCategoryController::class, 'decoratorDetailSave'])->name('vendor.decoratorDetailSave');

    Route::post('/vendor/photography-detail-save', [VendorCategoryController::class, 'photographyDetailSave'])->name('vendor.photographyDetailSave');

    Route::post('/vendor/make-up-detail-save', [VendorCategoryController::class, 'makeUpDetailSave'])->name('vendor.makeUpDetailSave');

    Route::post('/vendor/invitation-card-detail-save', [VendorCategoryController::class, 'invitationCardDetailSave'])->name('vendor.invitationCardDetailSave');

    Route::get('/vendor/category-about/{id}', [VendorCategoryController::class, 'categoryAbout'])->name('vendor.categoryAbout');

    Route::post('/vendor/category-about-save', [VendorCategoryController::class, 'categoryAboutSave'])->name('vendor.categoryAboutSave');

    Route::get('/vendor/category-gallery/{id}', [VendorCategoryController::class, 'categoryGallery'])->name('vendor.categoryGallery');

    Route::post('/vendor/category-gallery-save', [VendorCategoryController::class, 'categoryGallerySave'])->name('vendor.categoryGallerySave');

    Route::get('/vendor/category-gallery-delete/{id}', [VendorCategoryController::class, 'destroy'])->name('vendor.gallery.destroy');

    Route::get('/vendor/category-booking-date/{id}', [VendorCategoryController::class, 'bookingDate'])->name('vendor.bookingDate');
    Route::post('/vendor/category-booking-date-save', [VendorCategoryController::class, 'bookingDateSave'])->name('vendor.bookingDateSave');
    Route::get('/booking-inquiry', [VendorCategoryController::class, 'bookingInquiry'])->name('vendor.bookingInquiry');
    Route::get('/inquiry-pending/{id}', [BookingEnquirieController::class, 'inquiryPending'])->name('inquiry.pending');
    Route::get('/inquiry-done/{id}', [BookingEnquirieController::class, 'inquiryDone'])->name('inquiry.done');

    Route::get('/vendor/package/{id}', [VendorCategoryController::class, 'package'])->name('vendor.package');

    Route::post('/vendor/save-package', [VendorCategoryController::class, 'storePackage'])->name('vendor.storePackage');
    Route::get('/vendor/booking-listing', [VendorCategoryController::class, 'bookingListing'])->name('vendor.bookingListing');
    Route::get('/vendor/change-booking-status-complete/{id}', [VendorCategoryController::class, 'changeBookingStatusActive'])->name('vendor.changeBookingStatusActive');
    Route::get('/vendor/change-booking-status-pending/{id}', [VendorCategoryController::class, 'changeBookingStatusInActive'])->name('vendor.changeBookingStatusInActive');
});
Route::get('/vendor/filter-order', [VendorCategoryController::class, 'filterOrder'])->name('vendor.filterOrder');
