<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\SocialLinkController;
use App\Http\Controllers\Admin\SettingController;

// Frontend
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/contact', [HomeController::class, 'contact'])->name('contact');

// Language switcher
Route::get('/lang/{locale}', [LanguageController::class, 'switch'])
    ->whereIn('locale', ['ar', 'en'])
    ->name('lang.switch');

// Auth
Route::get('/admin/login', function () { return view('admin.login'); })->name('admin.login')->middleware('guest');
Route::post('/admin/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);
    if (auth()->attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        return redirect()->route('admin.dashboard');
    }
    return back()->withErrors(['email' => 'البيانات غير صحيحة']);
})->name('admin.login.post')->middleware('guest');

Route::post('/admin/logout', function (\Illuminate\Http\Request $request) {
    auth()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('admin.login');
})->name('admin.logout');

// Admin Panel (protected)
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('services', ServiceController::class)->except(['show']);
    Route::resource('projects', ProjectController::class)->except(['show']);
    Route::resource('brands',   BrandController::class)->except(['show']);

    // Media library
    Route::get   ('media',                  [MediaController::class, 'index'])  ->name('media.index');
    Route::post  ('media',                  [MediaController::class, 'store'])  ->name('media.store');
    Route::delete('media/{medium}',         [MediaController::class, 'destroy'])->name('media.destroy');
    Route::get   ('media/picker/list',      [MediaController::class, 'pickerList'])  ->name('media.picker.list');
    Route::post  ('media/picker/upload',    [MediaController::class, 'pickerUpload'])->name('media.picker.upload');

    Route::get('contacts',          [ContactController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{contact}',[ContactController::class, 'show'])->name('contacts.show');
    Route::delete('contacts/{contact}',[ContactController::class, 'destroy'])->name('contacts.destroy');

    Route::get('socials',               [SocialLinkController::class, 'index'])->name('socials.index');
    Route::get('socials/create',        [SocialLinkController::class, 'create'])->name('socials.create');
    Route::post('socials',              [SocialLinkController::class, 'store'])->name('socials.store');
    Route::get('socials/{social}/edit', [SocialLinkController::class, 'edit'])->name('socials.edit');
    Route::put('socials/{social}',      [SocialLinkController::class, 'update'])->name('socials.update');
    Route::delete('socials/{social}',   [SocialLinkController::class, 'destroy'])->name('socials.destroy');

    Route::get('settings',  [SettingController::class, 'index'])->name('settings');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
});
