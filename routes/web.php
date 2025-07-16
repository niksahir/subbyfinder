<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController as AuthRegisterController;
use App\Http\Controllers\Contractor\BookmarkController;
use App\Http\Controllers\Contractor\ChatController;
use App\Http\Controllers\Contractor\HomeController;
use App\Http\Controllers\Contractor\LoginController as ContractorLoginController;
use App\Http\Controllers\Contractor\NoteController as ContractorNoteController;
use App\Http\Controllers\Contractor\ProjectController;
use App\Http\Controllers\Contractor\RegisterController as ContractorRegisterController;
use App\Http\Controllers\Contractor\ReviewsController;
use App\Http\Controllers\Contractor\SettingController;
use App\Http\Controllers\Contractor\WalletController;
use App\Http\Controllers\Front\HomeController as FrontHomeController;
use App\Http\Controllers\Front\RegisterController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SubContractor\BookmarkController as SubContractorBookmarkController;
use App\Http\Controllers\SubContractor\HomeController as SubContractorHomeController;
use App\Http\Controllers\SubContractor\LoginController as SubContractorLoginController;
use App\Http\Controllers\SubContractor\MassageController;
use App\Http\Controllers\SubContractor\NoteController;
use App\Http\Controllers\SubContractor\ProjectController as SubContractorProjectController;
use App\Http\Controllers\SubContractor\RegisterController as SubContractorRegisterController;
use App\Http\Controllers\SubContractor\ReviewController;
use App\Http\Controllers\SubContractor\SettingController as SubContractorSettingController;
use App\Http\Controllers\SubContractor\WalletController as SubContractorWalletController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\SubContractor\ProtfolioController;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::any('api/firebase-login', [FirebaseAuthController::class, 'login']);
Route::get('create-account', [RegisterController::class, 'index'])->name('front.createaccount');

Route::get('/', [FrontHomeController::class, 'index'])->name('front.home');
Route::get('subcontractor', [FrontHomeController::class, 'subcontractor'])->name('front.subcontractor');
Route::get('contractor', [FrontHomeController::class, 'contractor'])->name('front.contractor');
Route::get('project-search', [FrontHomeController::class, 'projectSearch'])->name('front.projectSearch');
Route::get('project-details/{id}', [FrontHomeController::class, 'projectDetails'])->name('front.projectDetils');
Route::get('project-details-lock/{id}', [FrontHomeController::class, 'projectdetilslock'])->name('front.projectdetilslock');
Route::get('unlock-project/{id}', [FrontHomeController::class, 'unlockproject'])->name('front.unlockproject');
Route::get('unlock-subcontractor/{id}', [FrontHomeController::class, 'unlockSubcontractorProject'])->name('front.contractor.unlockproject');
Route::get('subcontractor-search', [FrontHomeController::class, 'subcontractorsearch'])->name('front.subcontractorsearch');
Route::get('subcontractor-details-lock/{id}', [FrontHomeController::class, 'subcontractorprojectdetilslock'])->name('front.subcontractorprojectdetilslock');
Route::get('subcontractor-details/{id}', [FrontHomeController::class, 'subcontractorprojectdetils'])->name('front.subcontractorprojectdetils');
Route::get('pricing', [FrontHomeController::class, 'showPlans'])->name('front.pricing');
Route::get('job-search', [FrontHomeController::class, 'jobSearch'])->name('front.jobsearch');
Route::post('send-enquiry-mail', [FrontHomeController::class, 'sendEnquiryMail'])->name('front.sendEnquiryMail');
Route::get('handleStripePayment', [FrontHomeController::class, 'handleStripePayment'])->name('front.handleStripePayment');
Route::get('handleStripePaymentProject', [FrontHomeController::class, 'handleStripePaymentProject'])->name('front.handleStripePaymentProject');
Route::get('/contractor/notifications/mark-all-read', [FrontHomeController::class, 'markAllAsRead'])->name('contractor.notifications.markAllAsRead');
Route::get('/subcontractor/notifications/mark-all-read', [FrontHomeController::class, 'subContractorMarkAllAsRead'])->name('subcontractor.notifications.markAllAsRead');


Route::get('/front', [App\Http\Controllers\HomeController::class, 'index'])->name('front');

Route::prefix('contractor')->name('contractor.')->group(function () {
    Route::resource('login', ContractorLoginController::class);
    Route::resource('register', ContractorRegisterController::class);
    Route::post('check-email', [ContractorRegisterController::class, 'checkEmail'])->name('checkEmail');
    Route::middleware(['auth:contractor,subcontractor'])->group(function () {
        Route::resource('bookmark', BookmarkController::class);
    });
    Route::middleware(['auth:contractor'])->group(function () {
        Route::resource('dashboard', HomeController::class);
        Route::resource('messages', ChatController::class);
        Route::resource('reviews', ReviewsController::class);
        Route::resource('projects', ProjectController::class);
        Route::resource('wallet', WalletController::class);
        Route::resource('setting', SettingController::class);
        Route::post('logout', [\App\Http\Controllers\Contractor\LoginController::class, 'logout'])->name('logout');
        Route::get('unlockPostProject', [ProjectController::class, 'unlockPostProject'])->name('unlockPostProject');
        Route::get('handleStripePaymentProject', [ProjectController::class, 'handleStripePaymentProject'])->name('handleStripePaymentProject');
        Route::resource('note', ContractorNoteController::class);
        // routes/web.php
        Route::get(
            '/dashboard/profile-views/data',  // GET because we’re only reading
            [HomeController::class, 'profileViewsData']
        )->name('dashboard.profileViewsData');
    });
});
Route::middleware(['auth:contractor,subcontractor'])->group(function () {
    Route::post('/update-email-alerts', [FrontHomeController::class, 'updateEmailAlerts'])->name('updateEmailAlerts');
    Route::post('/send-message', [MessageController::class, 'send'])->name('sendMessage');
    Route::get('/get-messages', [MessageController::class, 'getMessages']);
    Route::post('/send-image', [MessageController::class, 'sendImage']);
    Route::post('/mark-as-seen', [MessageController::class, 'markAsSeen']);
    Route::get('/unseen-count', [MessageController::class, 'unseenCount'])->name('message.unseenCount');
    Route::delete('/delete-message/{id}', [MessageController::class, 'destroy'])->name('messages.destroy');
    Route::delete('/delete-all-messages/{chatId}', [MessageController::class, 'deleteAll']);
});
Route::prefix('sub-contractor')->name('subcontractor.')->group(function () {
    Route::resource('login', SubContractorLoginController::class);
    Route::resource('register', SubContractorRegisterController::class);
    Route::post('check-email', [SubContractorRegisterController::class, 'checkEmail'])->name('checkEmail');
    Route::middleware(['auth:contractor,subcontractor'])->group(function () {
        Route::resource('bookmark', SubContractorBookmarkController::class);
    });
    Route::middleware(['auth:subcontractor'])->group(function () {
        Route::resource('dashboard', SubContractorHomeController::class);
        Route::resource('messages', MassageController::class);
        Route::resource('reviews', ReviewController::class);
        Route::resource('wallet', SubContractorWalletController::class);
        Route::resource('setting', SubContractorSettingController::class);
        Route::resource('protfolio', ProtfolioController::class);
        Route::resource('note', NoteController::class);
        Route::post('logout', [\App\Http\Controllers\SubContractor\LoginController::class, 'logout'])->name('logout');
        Route::get(
            '/dashboard/profile-views/data',  // GET because we’re only reading
            [\App\Http\Controllers\SubContractor\HomeController::class, 'profileViewsData']
        )->name('dashboard.profileViewsDatas');
    });
    Route::middleware(['auth:subcontractor'])->group(function () {
        Route::resource('dashboard', SubContractorHomeController::class);
        Route::resource('messages', MassageController::class);
        Route::resource('reviews', ReviewController::class);
        Route::resource('wallet', SubContractorWalletController::class);
        Route::resource('setting', SubContractorSettingController::class);
        Route::resource('protfolio', ProtfolioController::class);
    });
});

Route::post('checkout', [StripeController::class, 'checkout'])->name('stripe.checkout');
Route::get('success', [StripeController::class, 'success'])->name('stripe.success');
Route::get('cancel', [StripeController::class, 'cancel'])->name('stripe.cancel');