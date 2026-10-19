<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BloodController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// আমাদের সম্পর্কে
Route::prefix('about')->group(function () {
    Route::get('/intro', [AboutController::class, 'intro'])->name('about.intro');
    Route::get('/rules', [AboutController::class, 'rules'])->name('about.rules');
    Route::get('/mission', [AboutController::class, 'mission'])->name('about.mission');
    Route::get('/faq', [AboutController::class, 'faq'])->name('about.faq');
});

// কমিটি
Route::prefix('committee')->group(function () {
    Route::get('/advisors', [CommitteeController::class, 'advisors'])->name('committee.advisors');
    Route::get('/executives', [CommitteeController::class, 'executives'])->name('committee.executives');
    Route::get('/list', [CommitteeController::class, 'list'])->name('committee.list');
});

// সদস্য পোর্টাল
Route::prefix('member')->group(function () {
    Route::get('/register', [MemberController::class, 'create'])->name('member.register');
    Route::post('/register', [MemberController::class, 'store'])->name('member.store');
    Route::get('/search', [MemberController::class, 'search'])->name('member.search');
    Route::get('/ledger', [MemberController::class, 'ledger'])->name('member.ledger');
    Route::post('/lookup', [MemberController::class, 'lookup'])->name('member.lookup');
});

// রক্তদান
Route::prefix('blood')->group(function () {
    Route::get('/board', [BloodController::class, 'board'])->name('blood.board');
    Route::get('/donors', [BloodController::class, 'donors'])->name('blood.donors');
    Route::get('/donor-register', [BloodController::class, 'createDonor'])->name('blood.donor.register');
    Route::post('/donor-register', [BloodController::class, 'storeDonor'])->name('blood.donor.store');
    Route::get('/donation-report', [BloodController::class, 'createDonation'])->name('blood.donation.report');
    Route::post('/donation-report', [BloodController::class, 'storeDonation'])->name('blood.donation.store');
});

// চাঁদা ও অনুদান
Route::get('/payment', [PaymentController::class, 'index'])->name('member.payment');
Route::post('/payment', [PaymentController::class, 'store'])->name('member.payment.store');
Route::get('/donation', [PaymentController::class, 'donation'])->name('donation');
Route::post('/donation', [PaymentController::class, 'storeDonation'])->name('donation.store');

// মিডিয়া
Route::prefix('media')->group(function () {
    Route::get('/photos', [MediaController::class, 'photos'])->name('media.photos');
    Route::get('/videos', [MediaController::class, 'videos'])->name('media.videos');
    Route::get('/news', [MediaController::class, 'news'])->name('media.news');
    Route::get('/press', [MediaController::class, 'press'])->name('media.press');
    Route::get('/awards', [MediaController::class, 'awards'])->name('media.awards');
});

// প্রকল্প ও যোগাযোগ
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('project.view');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// অ্যাডমিন প্যানেল
Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login');
});
