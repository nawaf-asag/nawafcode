<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\SocialLinkController;
use App\Http\Controllers\Admin\SettingController;

// Frontend
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/contact', [HomeController::class, 'contact'])->name('contact');

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
