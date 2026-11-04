<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\InsightController;
use App\Http\Controllers\MentorshipController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\WaitlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/work', [PageController::class, 'work'])->name('work.index');
Route::get('/work/{slug}', [PageController::class, 'caseStudy'])->name('work.show');
Route::get('/speaking', [PageController::class, 'speaking'])->name('speaking');
Route::get('/programmes', [PageController::class, 'programmes'])->name('programmes');
Route::get('/leadership-impact', [PageController::class, 'impact'])->name('impact');
Route::get('/media', [PageController::class, 'media'])->name('media');
Route::get('/book', [PageController::class, 'book'])->name('book');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/podcast', [PageController::class, 'podcast'])->name('podcast.index');
Route::get('/podcast/{episode}', [PageController::class, 'episode'])->name('podcast.show');
Route::get('/resources', [PageController::class, 'resources'])->name('resources');

Route::get('/insights', [InsightController::class, 'index'])->name('insights.index');
Route::get('/insights/{article}', [InsightController::class, 'show'])->name('insights.show');

Route::get('/programmes/mentorship', [MentorshipController::class, 'show'])->name('mentorship');
Route::post('/programmes/mentorship/apply', [MentorshipController::class, 'apply'])->middleware('throttle:5,1')->name('mentorship.apply');

Route::post('/enquiries', [EnquiryController::class, 'store'])->middleware('throttle:5,1')->name('enquiries.store');
Route::post('/book/waitlist', [WaitlistController::class, 'store'])->middleware('throttle:5,1')->name('waitlist.store');
Route::post('/subscribe', [SubscriberController::class, 'store'])->middleware('throttle:5,1')->name('subscribe');
Route::get('/unsubscribe/{token}', [SubscriberController::class, 'unsubscribe'])->name('unsubscribe');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [Admin\AuthController::class, 'create'])->name('login');
        Route::post('/login', [Admin\AuthController::class, 'store'])->name('login.store');
    });

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [Admin\AuthController::class, 'destroy'])->name('logout');
        Route::get('/', Admin\DashboardController::class)->name('dashboard');

        Route::middleware('can:manage-content')->group(function () {
            Route::resource('articles', Admin\ArticleController::class)->except('show');
            Route::get('/articles/{article}/preview', [Admin\ArticleController::class, 'preview'])->name('articles.preview');
            Route::resource('testimonials', Admin\TestimonialController::class)->except('show');

            Route::get('/pages', [Admin\PageContentController::class, 'index'])->name('pages.index');
            Route::get('/pages/{group}', [Admin\PageContentController::class, 'edit'])->name('pages.edit');
            Route::put('/pages/{group}', [Admin\PageContentController::class, 'update'])->name('pages.update');

            Route::get('/lists', [Admin\ItemController::class, 'overview'])->name('items.overview');
            Route::get('/lists/{type}', [Admin\ItemController::class, 'index'])->name('items.index');
            Route::get('/lists/{type}/create', [Admin\ItemController::class, 'create'])->name('items.create');
            Route::post('/lists/{type}', [Admin\ItemController::class, 'store'])->name('items.store');
            Route::get('/lists/{type}/{item:id}/edit', [Admin\ItemController::class, 'edit'])->name('items.edit');
            Route::put('/lists/{type}/{item:id}', [Admin\ItemController::class, 'update'])->name('items.update');
            Route::delete('/lists/{type}/{item:id}', [Admin\ItemController::class, 'destroy'])->name('items.destroy');
            Route::post('/lists/{type}/{item:id}/move', [Admin\ItemController::class, 'move'])->name('items.move');

            Route::get('/media', [Admin\MediaController::class, 'index'])->name('media.index');
            Route::post('/media', [Admin\MediaController::class, 'store'])->name('media.store');
            Route::get('/media/{media}', [Admin\MediaController::class, 'edit'])->name('media.edit');
            Route::put('/media/{media}', [Admin\MediaController::class, 'update'])->name('media.update');
            Route::delete('/media/{media}', [Admin\MediaController::class, 'destroy'])->name('media.destroy');

            Route::get('/cohort', [Admin\CohortController::class, 'edit'])->name('cohort.edit');
            Route::put('/cohort', [Admin\CohortController::class, 'update'])->name('cohort.update');
        });

        Route::middleware('can:manage-inbox')->group(function () {
            Route::get('/enquiries', [Admin\EnquiryController::class, 'index'])->name('enquiries.index');
            Route::get('/enquiries/{enquiry}', [Admin\EnquiryController::class, 'show'])->name('enquiries.show');
            Route::put('/enquiries/{enquiry}', [Admin\EnquiryController::class, 'update'])->name('enquiries.update');
            Route::post('/enquiries/{enquiry}/notes', [Admin\EnquiryController::class, 'note'])->name('enquiries.note');
            Route::get('/enquiries-export', [Admin\EnquiryController::class, 'export'])->name('enquiries.export');
            Route::get('/applications', [Admin\ApplicationController::class, 'index'])->name('applications.index');
            Route::get('/applications/export', [Admin\ApplicationController::class, 'export'])->name('applications.export');
            Route::get('/applications/{application}', [Admin\ApplicationController::class, 'show'])->name('applications.show');
            Route::put('/applications/{application}', [Admin\ApplicationController::class, 'update'])->name('applications.update');
            Route::post('/applications/{application}/notes', [Admin\ApplicationController::class, 'note'])->name('applications.note');
            Route::get('/waitlist', [Admin\WaitlistController::class, 'index'])->name('waitlist.index');
            Route::get('/waitlist/export', [Admin\WaitlistController::class, 'export'])->name('waitlist.export');
            Route::get('/subscribers', [Admin\SubscriberController::class, 'index'])->name('subscribers.index');
            Route::get('/subscribers/export', [Admin\SubscriberController::class, 'export'])->name('subscribers.export');
            Route::delete('/subscribers/{subscriber}', [Admin\SubscriberController::class, 'destroy'])->name('subscribers.destroy');
        });

        Route::middleware('can:manage-settings')->group(function () {
            Route::get('/settings', [Admin\SettingsController::class, 'edit'])->name('settings.edit');
            Route::put('/settings', [Admin\SettingsController::class, 'update'])->name('settings.update');
            Route::get('/team', [Admin\TeamController::class, 'index'])->name('team.index');
            Route::post('/team', [Admin\TeamController::class, 'store'])->name('team.store');
            Route::delete('/team/{user}', [Admin\TeamController::class, 'destroy'])->name('team.destroy');
        });

        Route::get('/account', [Admin\AccountController::class, 'edit'])->name('account.edit');
        Route::put('/account', [Admin\AccountController::class, 'update'])->name('account.update');
    });
});
