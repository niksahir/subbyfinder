<?php

use App\Http\Controllers\Auth\RegisterController as AuthRegisterController;
use App\Http\Controllers\Contractor\BookmarkController;
use App\Http\Controllers\Contractor\ChatController;
use App\Http\Controllers\Contractor\HomeController;
use App\Http\Controllers\Contractor\LoginController as ContractorLoginController;
use App\Http\Controllers\Contractor\ProjectController;
use App\Http\Controllers\Contractor\RegisterController as ContractorRegisterController;
use App\Http\Controllers\Contractor\ReviewsController;
use App\Http\Controllers\Contractor\SettingController;
use App\Http\Controllers\Contractor\WalletController;
use App\Http\Controllers\Front\HomeController as FrontHomeController;
use App\Http\Controllers\Front\RegisterController;
use App\Http\Controllers\SubContractor\BookmarkController as SubContractorBookmarkController;
use App\Http\Controllers\SubContractor\HomeController as SubContractorHomeController;
use App\Http\Controllers\SubContractor\LoginController as SubContractorLoginController;
use App\Http\Controllers\SubContractor\MassageController;
use App\Http\Controllers\SubContractor\ProjectController as SubContractorProjectController;
use App\Http\Controllers\SubContractor\RegisterController as SubContractorRegisterController;
use App\Http\Controllers\SubContractor\ReviewController;
use App\Http\Controllers\SubContractor\SettingController as SubContractorSettingController;
use App\Http\Controllers\SubContractor\WalletController as SubContractorWalletController;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('create-account', [RegisterController::class, 'index'])->name('front.createaccount');

Route::get('/', [FrontHomeController::class, 'index'])->name('front.home');
Route::get('subcontractor', [FrontHomeController::class, 'subcontractor'])->name('front.subcontractor');
Route::get('contractor', [FrontHomeController::class, 'contractor'])->name('front.contractor');
Route::get('project-search', [FrontHomeController::class, 'projectSearch'])->name('front.projectSearch');
Route::get('project-details', [FrontHomeController::class, 'projectDetils'])->name('front.projectDetils');
Route::get('project-details-lock/{id}', [FrontHomeController::class, 'projectdetilslock'])->name('front.projectdetilslock');
Route::get('subcontractor-search', [FrontHomeController::class, 'subcontractorsearch'])->name('front.subcontractorsearch');
Route::get('subcontractor-project-details-lock', [FrontHomeController::class, 'subcontractorprojectdetilslock'])->name('front.subcontractorprojectdetilslock');
Route::get('subcontractor-project-details', [FrontHomeController::class, 'subcontractorprojectdetils'])->name('front.subcontractorprojectdetils');

Route::get('subcontractor-search', [FrontHomeController::class, 'subcontractorsearch'])->name('front.subcontractorsearch');

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
   });
});
Route::middleware(['auth:contractor,subcontractor'])->group(function () {
    Route::post('/update-email-alerts', [FrontHomeController::class, 'updateEmailAlerts'])->name('updateEmailAlerts');
});
Route::prefix('sub-contractor')->name('subcontractor.')->group(function () {
   Route::resource('login', SubContractorLoginController::class);
   Route::resource('register', SubContractorRegisterController::class);
   Route::post('check-email', [SubContractorRegisterController::class, 'checkEmail'])->name('checkEmail');
   Route::middleware(['auth:subcontractor'])->group(function () {
      Route::resource('dashboard', SubContractorHomeController::class);
      Route::resource('messages', MassageController::class);
      Route::resource('reviews', ReviewController::class);
      Route::resource('bookmark', SubContractorBookmarkController::class);
      Route::resource('wallet', SubContractorWalletController::class);
      Route::resource('setting', SubContractorSettingController::class);
   });
});
