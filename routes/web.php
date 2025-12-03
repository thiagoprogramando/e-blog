<?php

use App\Http\Controllers\Access\ForgoutController;
use App\Http\Controllers\Access\LoginController;
use App\Http\Controllers\Access\RegisterController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\Blog\PostController;
use App\Http\Controllers\Finance\BuyController;
use App\Http\Controllers\Finance\CouponController;
use App\Http\Controllers\Finance\InvoiceController;
use App\Http\Controllers\Finance\PlanController;
use App\Http\Controllers\Letter\GroupController;
use App\Http\Controllers\Letter\LeadController;
use App\Http\Controllers\Media\MediaController;
use App\Http\Controllers\Token\EmailController;
use App\Http\Controllers\Token\TokenController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/logon', [LoginController::class, 'store'])->name('logon');

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/registrer', [RegisterController::class, 'store'])->name('registrer');

Route::get('/forgout/{code?}', [ForgoutController::class, 'index'])->name('forgout');
Route::post('/forgout-password', [ForgoutController::class, 'store'])->name('forgout-password');
Route::post('/recover-password/{code}', [ForgoutController::class, 'update'])->name('recover-password');

Route::get('/register-lead/{uuid}', [LeadController::class, 'store'])->name('register-lead');

Route::middleware(['auth'])->group(function () {

    Route::get('/app', [AppController::class, 'index'])->name('app');

    Route::get('/buy', [BuyController::class, 'index'])->name('buy');
    Route::post('/created-buy/{plan}', [BuyController::class, 'store'])->name('created-buy');

    Route::middleware(['checkMonthly'])->group(function () { 

        Route::get('/posts', [PostController::class, 'index'])->name('posts');
        Route::get('/post/{uuid}', [PostController::class, 'show'])->name('post');
        Route::post('/created-post', [PostController::class, 'store'])->name('created-post');
        Route::post('/updated-post/{uuid}', [PostController::class, 'update'])->name('updated-post');
        Route::post('/deleted-post/{uuid}', [PostController::class, 'destroy'])->name('deleted-post');
        Route::post('/deleted-post-attachment/{uuid}', [PostController::class, 'destroyAttachment'])->name('deleted-post-attachment');

        Route::get('/medias', [MediaController::class, 'index'])->name('medias');
        Route::post('/created-media', [MediaController::class, 'store'])->name('created-media');
        Route::post('/deleted-media/{uuid}', [MediaController::class, 'destroy'])->name('deleted-media');

        Route::get('/tokens', [TokenController::class, 'index'])->name('tokens');
        Route::post('/created-token', [TokenController::class, 'store'])->name('created-token');
        Route::post('/updated-token/{token}', [TokenController::class, 'update'])->name('updated-token');
        Route::post('/deleted-token/{token}', [TokenController::class, 'destroy'])->name('deleted-token');

        Route::get('/emails', [EmailController::class, 'index'])->name('emails');
        Route::post('/created-email', [EmailController::class, 'store'])->name('created-email');
        Route::post('/updated-email/{uuid}', [EmailController::class, 'update'])->name('updated-email');
        Route::post('/deleted-email/{uuid}', [EmailController::class, 'destroy'])->name('deleted-email');

        Route::get('/leads', [LeadController::class, 'index'])->name('leads');
        Route::post('/created-lead', [LeadController::class, 'store'])->name('created-lead');
        Route::post('/updated-lead/{uuid}', [LeadController::class, 'update'])->name('updated-lead');
        Route::post('/deleted-lead/{uuid}', [LeadController::class, 'destroy'])->name('deleted-lead');

        Route::get('/groups', [GroupController::class, 'index'])->name('groups');
        Route::post('/created-group', [GroupController::class, 'store'])->name('created-group');
        Route::post('/updated-group/{uuid}', [GroupController::class, 'update'])->name('updated-group');
        Route::post('/deleted-group/{uuid}', [GroupController::class, 'destroy'])->name('deleted-group');

        Route::get('/letters', [LetterController::class, 'index'])->name('letters');
        Route::get('/letter/{uuid}', [LetterController::class, 'show'])->name('letter');
        Route::post('/created-letter', [LetterController::class, 'store'])->name('created-letter');
        Route::post('/updated-letter/{uuid}', [LetterController::class, 'update'])->name('updated-letter');
        Route::post('/deleted-letter/{uuid}', [LetterController::class, 'destroy'])->name('deleted-letter');

    });

    Route::middleware(['checkAdmin'])->group(function () { 

        Route::get('/plans', [PlanController::class, 'index'])->name('plans');
        Route::get('/plan/{uuid}', [PlanController::class, 'show'])->name('plan');
        Route::post('/created-plan', [PlanController::class, 'store'])->name('created-plan');
        Route::post('/updated-plan/{uuid}', [PlanController::class, 'update'])->name('updated-plan');
        Route::post('/deleted-plan/{uuid}', [PlanController::class, 'destroy'])->name('deleted-plan');

        Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices');
        Route::post('/updated-invoice/{uuid}', [InvoiceController::class, 'update'])->name('updated-invoice');
        Route::post('/deleted-invoice/{uuid}', [InvoiceController::class, 'destroy'])->name('deleted-invoice');

        Route::get('/coupons', [CouponController::class, 'index'])->name('coupons');
        Route::post('/created-coupon', [CouponController::class, 'store'])->name('created-coupon');
        Route::post('/updated-coupon/{uuid}', [CouponController::class, 'update'])->name('updated-coupon');
        Route::post('/deleted-coupon/{uuid}', [CouponController::class, 'destroy'])->name('deleted-coupon');
    });

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});