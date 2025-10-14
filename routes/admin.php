<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Backend\AuthController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\Mastertable\BannerController;
use App\Http\Controllers\Backend\Mastertable\StateController;
use App\Http\Controllers\Backend\Mastertable\CityController;
use App\Http\Controllers\Backend\Mastertable\AreaController;
use App\Http\Controllers\Backend\Mastertable\PermissionsController;
use App\Http\Controllers\Backend\Mastertable\RolesController;
use App\Http\Controllers\Backend\StaffController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\AstrologerController;
use App\Http\Controllers\Backend\CmsManagementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Backend\ReviewManagementController;
use App\Http\Controllers\Backend\TestimonialController;
use App\Http\Controllers\Backend\CouponController;





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


//filter city

Route::get('/filter-city', [CityController::class, 'filterCity'])->name('filterCity');
Route::get('/filter-area', [AreaController::class, 'filteArea'])->name('filteArea');


Route::get('/admin', [AuthController::class, 'index'])->name('admin.index');


//route::get('/',[AdminController::class, 'adminLoginPage'])->name('admin.adminLoginPage');
route::post('admin/login', [AuthController::class, 'login'])->name('admin.login');
route::get('admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

//Forget and Reset Password For Admin

Route::get('admin/forget-password-form', [AuthController::class, 'forgetPasswordForm'])->name('admin.forgetPasswordForm');
Route::post('admin/forget-password', [AuthController::class, 'forgetPassword'])->name('admin.forgetPassword');
Route::get('admin/reset-password/{token}', [AuthController::class, 'resetPasswordForm'])->name('admin.resetPasswordForm');
Route::post('admin/reset-password', [AuthController::class, 'resetPassword'])->name('admin.resetPassword');



Route::group(['middleware' => ['can:isAdmin']], function () {



  //coupon 
  Route::get('/admin/coupons', [CouponController::class, 'index'])->name('admin.coupon.index');
  Route::get('/admin/coupon-create', [CouponController::class, 'create'])->name('admin.coupon.create');
  Route::post('/admin/coupon-store', [CouponController::class, 'store'])->name('admin.coupon.store');
  Route::get('/admin/coupon-edit/{id}', [CouponController::class, 'edit'])->name('admin.coupon.edit');
  Route::get('/admin/coupon-delete/{id}', [CouponController::class, 'delete'])->name('admin.coupon.delete');
  Route::post('/admin/coupon-update/{id}', [CouponController::class, 'update'])->name('admin.coupon.update');

  Route::get('/astro-profile-approve/{id}/{astro_id}', [AstrologerController::class, 'approve'])->name('profileImage.approve');






  //AstrologerController

  Route::get('/admin/astrologers', [AstrologerController::class, 'index'])->name('admin.astrologers');
  Route::get('/admin/astrologer-create', [AstrologerController::class, 'create'])->name('admin.astrologerr.create');
  Route::post('/admin/astrologer-store', [AstrologerController::class, 'store'])->name('admin.astrologerr.store');
  Route::post('/admin/astrologer/reject/{id}', [AstrologerController::class, 'reject'])->name('admin.astrologer.reject');
  
  //Astrologer Report
  
  Route::get('/admin/astrologer-report', [AstrologerController::class, 'astrologerReport'])->name('admin.astrologer.report');
  
  Route::get('admin/call-logs', [AstrologerController::class, 'callLogs']);
  
  
  


  Route::get('/admin/astrologer-delete/{id}', [AstrologerController::class, 'delete'])->name('admin.astrologer.destroy');
  Route::get('/admin/astrologer-status/{id}/{status}', [AstrologerController::class, 'active'])->name('admin.astrologer.active');
  //Route::get('/admin/astrologer-block/{id}', [AstrologerController::class, 'inActive'])->name('admin.astrologer.inActive');
  Route::get('/admin/astrologer-view/{id}', [AstrologerController::class, 'view'])->name('admin.astrologer.view');

  Route::post('/admin/astrologer-commission-percent/{id}', [AstrologerController::class, 'commissionPercent'])->name('admin.astrologer.commissionPercent');



  //user
  Route::get('/admin/user-delete/{id}', [UserController::class, 'delete'])->name('admin.user.destroy');
  Route::get('/admin/user-unblock/{id}', [UserController::class, 'active'])->name('admin.user.active');
  Route::get('/admin/user-block/{id}', [UserController::class, 'inActive'])->name('admin.user.inActive');
  Route::get('/admin/user-wallet-transaction', [AstrologerController::class, 'walletTransaction'])->name('admin.user.walletTransaction');
  Route::get('/admin/user-wallet-transaction/{id}', [AstrologerController::class, 'UserWalletTransaction'])->name('admin.user.walletTransactionId');




  //celebrities

  Route::get('/admin/celebrities', [AstrologerController::class, 'celebrityList'])->name('admin.celebrity.celebrityList');
  Route::get('/admin/celebrity-create', [AstrologerController::class, 'celebrityCreate'])->name('admin.celebrity.celebrityCreate');

  Route::post('/admin/celebrity-store', [AstrologerController::class, 'celebrityStore'])->name('admin.celebrity.celebrityStore');
  Route::get('/admin/celebrity-delete/{id}', [AstrologerController::class, 'celebrityDelete'])->name('admin.celebrity.celebrityDelete');
  Route::get('/admin/celebrity-edit/{id}', [AstrologerController::class, 'celebrityEdit'])->name('admin.celebrity.celebrityEdit');
  Route::post('/admin/celebrity-update/{id}', [AstrologerController::class, 'celebrityUpdate'])->name('admin.celebrity.celebrityUpdate');

  //Question



  Route::get('/admin/questions', [AstrologerController::class, 'onboardingQuestion'])->name('admin.question.index');
  Route::get('/admin/question-create', [AstrologerController::class, 'questionCreate'])->name('admin.question.create');
  Route::post('/admin/question-store', [AstrologerController::class, 'questionStore'])->name('admin.question.store');
  Route::get('/admin/question-delete/{id}', [AstrologerController::class, 'questionDelete'])->name('admin.question.delete');
  Route::get('/admin/question-edit/{id}', [AstrologerController::class, 'questionEdit'])->name('admin.question.edit');
  Route::post('/admin/question-update/{id}', [AstrologerController::class, 'questionUpdate'])->name('admin.question.update');
  Route::get('/admin/question-unblock/{id}', [AstrologerController::class, 'questionActive'])->name('admin.question.active');
  Route::get('/admin/question-block/{id}', [AstrologerController::class, 'questionInActive'])->name('admin.question.inActive');









  //Payment Management  paymentManagement

  Route::get('/admin/payment-filter', [AstrologerController::class, 'paymentFilter'])->name('admin.paymentFilter');
  Route::get('/admin/payouts', [AstrologerController::class, 'payout'])->name('admin.payout');
  Route::get('/admin/payout-completed/{id}', [AstrologerController::class, 'payoutCompleted'])->name('admin.payout.completed');
  Route::get('/admin/payout-pending/{id}', [AstrologerController::class, 'payoutPending'])->name('admin.payout.pending');
  Route::get('/admin/payout-filter', [AstrologerController::class, 'payoutFilter'])->name('admin.payoutFilter');
  Route::get('/admin/payout-view/{id}', [AstrologerController::class, 'payoutView'])->name('admin.payout.view');







  Route::get('/admin/payment-management', [AstrologerController::class, 'paymentManagement'])->name('admin.paymentManagement');
  Route::get('/admin/payment-completed/{id}', [AstrologerController::class, 'paymentCompleted'])->name('admin.payment.completed');
  Route::get('/admin/payment-pending/{id}', [AstrologerController::class, 'paymentPending'])->name('admin.payment.pending');
  Route::get('/admin/payment-view/{id}', [AstrologerController::class, 'paymentView'])->name('admin.payment.view');
  Route::get('/admin/payment-delete/{id}', [AstrologerController::class, 'paymentDelete'])->name('admin.payment.delete');






  //Route::post('/admin/celebrities', [AstrologerController::class, 'celebrityList'])->name('admin.celebrity.celebrityList');

  //testimonial




  Route::get('/admin/testimonials', [TestimonialController::class, 'index'])->name('admin.testimonial.index');
  Route::get('/admin/testimonial-create', [TestimonialController::class, 'create'])->name('admin.testimonial.create');
  Route::post('/admin/testimonial-store', [TestimonialController::class, 'store'])->name('admin.testimonial.store');
  Route::get('/admin/testimonial-edit/{id}', [TestimonialController::class, 'edit'])->name('admin.testimonial.edit');
  Route::post('/admin/testimonial-update/{id}', [TestimonialController::class, 'update'])->name('admin.testimonial.update');
  Route::get('/admin/testimonial-delete/{id}', [TestimonialController::class, 'delete'])->name('admin.testimonial.delete');







  Route::get('/admin/filter-orders', [DashboardController::class, 'filterOrder'])->name('admin.filterOrder');
  Route::get('/admin/order-management', [DashboardController::class, 'orderManagement'])->name('admin.order');
  Route::get('/admin/chat-history/{id}', [DashboardController::class, 'chatHistory'])->name('admin.chatHistory');




  Route::get('/admin/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');

  Route::get('/admin/change-password', [AuthController::class, 'changePassword'])->name('admin.changePassword');
  Route::post('/admin/change-password-save', [AuthController::class, 'changePasswordSave'])->name('admin.changePasswordSave');


  Route::get('/admin/profile-edit', [AuthController::class, 'profileEdit'])->name('admin.profileEdit');
  Route::post('/admin/profile-save', [AuthController::class, 'profileUpdate'])->name('admin.profileUpdate');




  //Blog

  Route::get('/admin/blogs', [BlogController::class, 'index'])->name('admin.blog.index');
  Route::get('/admin/blog-add', [BlogController::class, 'create'])->name('admin.blog.create');
  Route::post('/admin/store-blog', [BlogController::class, 'store'])->name('admin.blog.store');
  Route::get('/admin/blog-edit/{id}', [BlogController::class, 'edit'])->name('admin.blog.edit');
  Route::post('/admin/update-blog/{id}', [BlogController::class, 'update'])->name('admin.blog.update');
  Route::get('/admin/blog-delete/{id}', [BlogController::class, 'destroy'])->name('admin.blog.destroy');
  Route::get('/admin/blog-active/{id}', [BlogController::class, 'active'])->name('admin.blog.active');
  Route::get('/admin/blog-deactive/{id}', [BlogController::class, 'deActive'])->name('admin.blog.deActive');


  //CMS



  Route::get('/admin/cms', [CmsManagementController::class, 'edit'])->name('admin.cms.edit');
  Route::post('/admin/cms-update', [CmsManagementController::class, 'update'])->name('admin.cms.update');


  //contacts
  Route::get('/admin/user-queries', [CmsManagementController::class, 'userQuery'])->name('admin.contact.index');
  Route::get('/admin/contact-delete/{id}', [CmsManagementController::class, 'userQueryDelete'])->name('admin.contact.destroy');


  //review management


  Route::get('/admin/user-reviews', [ReviewManagementController::class, 'index'])->name('admin.review.index');
  Route::get('/admin/user-review-delete/{id}', [ReviewManagementController::class, 'delete'])->name('admin.review.destroy');
  Route::get('/admin/banner-approve/{id}', [ReviewManagementController::class, 'approve'])->name('admin.review.approve');
  Route::get('/admin/banner-reject/{id}', [ReviewManagementController::class, 'reject'])->name('admin.review.reject');
  
});



//Master Table

Route::group(['middleware' => ['can:isAdmin']], function () {

  //banner

  Route::get('/admin/banner', [BannerController::class, 'index'])->name('admin.masterTable.index');
  Route::get('/admin/add-banner', [BannerController::class, 'create'])->name('admin.masterTable.create');
  Route::post('/admin/store-banner', [BannerController::class, 'store'])->name('admin.masterTable.store');
  Route::get('/admin/banner-edit/{id}', [BannerController::class, 'edit'])->name('admin.masterTable.edit');
  Route::post('/admin/update-banner/{id}', [BannerController::class, 'update'])->name('admin.masterTable.update');
  Route::get('/admin/banner-delete/{id}', [BannerController::class, 'destroy'])->name('admin.masterTable.destroy');
  Route::get('/admin/banner-active/{id}', [BannerController::class, 'active'])->name('admin.masterTable.active');
  Route::get('/admin/banner-deactive/{id}', [BannerController::class, 'deActive'])->name('admin.masterTable.deActive');




  //states


  Route::get('/admin/state', [StateController::class, 'index'])->name('admin.masterTable.state.index');
  Route::get('/admin/add-state', [StateController::class, 'create'])->name('admin.masterTable.state.create');
  Route::post('/admin/store-state', [StateController::class, 'store'])->name('admin.masterTable.state.store');
  Route::get('/admin/state-edit/{id}', [StateController::class, 'edit'])->name('admin.masterTable.state.edit');
  Route::post('/admin/update-state/{id}', [StateController::class, 'update'])->name('admin.masterTable.state.update');
  Route::get('/admin/state-delete/{id}', [StateController::class, 'destroy'])->name('admin.masterTable.state.destroy');

  //Cities


  Route::get('/admin/city', [CityController::class, 'index'])->name('admin.masterTable.city.index');
  Route::get('/admin/add-city', [CityController::class, 'create'])->name('admin.masterTable.city.create');
  Route::post('/admin/store-city', [CityController::class, 'store'])->name('admin.masterTable.city.store');
  Route::get('/admin/city-edit/{id}', [CityController::class, 'edit'])->name('admin.masterTable.city.edit');
  Route::post('/admin/update-city/{id}', [CityController::class, 'update'])->name('admin.masterTable.city.update');
  Route::get('/admin/city-delete/{id}', [CityController::class, 'destroy'])->name('admin.masterTable.city.destroy');



  //Area


  Route::get('/admin/area', [AreaController::class, 'index'])->name('admin.masterTable.area.index');
  Route::get('/admin/add-area', [AreaController::class, 'create'])->name('admin.masterTable.area.create');
  Route::post('/admin/store-area', [AreaController::class, 'store'])->name('admin.masterTable.area.store');
  Route::get('/admin/area-edit/{id}', [AreaController::class, 'edit'])->name('admin.masterTable.area.edit');
  Route::post('/admin/update-area/{id}', [AreaController::class, 'update'])->name('admin.masterTable.area.update');
  Route::get('/admin/area-delete/{id}', [AreaController::class, 'destroy'])->name('admin.masterTable.area.destroy');


  //permissions


  Route::get('/admin/permissions', [PermissionsController::class, 'index'])->name('admin.masterTable.permission.index');
  Route::get('/admin/add-permission', [PermissionsController::class, 'create'])->name('admin.masterTable.permission.create');
  Route::post('/admin/store-permission', [PermissionsController::class, 'store'])->name('admin.masterTable.permission.store');
  Route::get('/admin/permission-edit/{id}', [PermissionsController::class, 'edit'])->name('admin.masterTable.permission.edit');
  Route::post('/admin/update-permission/{id}', [PermissionsController::class, 'update'])->name('admin.masterTable.permission.update');
  Route::get('/admin/permission-delete/{id}', [PermissionsController::class, 'destroy'])->name('admin.masterTable.permission.destroy');

  //Roles
  Route::get('/admin/roles', [RolesController::class, 'index'])->name('admin.masterTable.role.index');
  Route::get('/admin/add-role', [RolesController::class, 'create'])->name('admin.masterTable.role.create');
  Route::post('/admin/store-role', [RolesController::class, 'store'])->name('admin.masterTable.role.store');
  Route::get('/admin/role-edit/{id}', [RolesController::class, 'edit'])->name('admin.masterTable.role.edit');
  Route::post('/admin/update-role/{id}', [RolesController::class, 'update'])->name('admin.masterTable.role.update');
  Route::get('/admin/role-delete/{id}', [RolesController::class, 'destroy'])->name('admin.masterTable.role.destroy');
});



//Vendor Management

Route::group(['middleware' => ['can:isAdmin']], function () {


  //Route::get('/admin/list-users', [VendorAuthController::class, 'listUser'])->name('admin.listUser');

  Route::get('/admin/list-users', [UserController::class, 'index'])->name('admin.listUser');



  //admin.masterTable.user.destroy

});








//Vendor Staff

Route::group(['middleware' => ['can:isAdmin']], function () {

  Route::get('/admin/staffs', [StaffController::class, 'index'])->name('admin.staff.index');
  Route::get('/admin/staff-add', [StaffController::class, 'create'])->name('admin.staff.create');
  Route::post('/admin/store-staff', [StaffController::class, 'store'])->name('admin.staff.store');
  Route::get('/admin/staff-edit/{id}', [StaffController::class, 'edit'])->name('admin.staff.edit');
  Route::post('/admin/update-staff/{id}', [StaffController::class, 'update'])->name('admin.staff.update');
  Route::get('/admin/staff-delete/{id}', [StaffController::class, 'destroy'])->name('admin.staff.destroy');
  Route::get('/admin/staff-active/{id}', [StaffController::class, 'active'])->name('admin.staff.active');
  Route::get('/admin/staff-deactive/{id}', [StaffController::class, 'deActive'])->name('admin.staff.deActive');
});
