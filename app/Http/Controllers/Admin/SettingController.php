<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /** Fields editable in BOTH Arabic and English (textual content) */
    private const BILINGUAL_FIELDS = [
        // Hero
        'hero_name', 'hero_title', 'hero_subtitle', 'hero_description',
        'hero_btn_projects', 'hero_btn_cv', 'typed_strings',
        // Stats labels
        'stat_years_label', 'stat_projects_label', 'stat_services_label',
        // About
        'about_text', 'about_tag', 'about_greeting',
        'about_btn_contact', 'about_btn_projects', 'skills',
        // Section titles
        'services_tag', 'services_title',
        'projects_tag', 'projects_title',
        'contact_tag', 'contact_title', 'contact_form_title',
        'contact_btn', 'contact_info_title',
        'filter_all', 'filter_web', 'filter_mobile',
        'featured_label', 'social_label',
        // Contact info
        'contact_location',
        // SEO
        'meta_title', 'meta_description', 'meta_keywords',
        'og_title', 'og_description',
    ];

    /** Fields stored as a single value (no translation) */
    private const SINGLE_FIELDS = [
        'cv_url', 'years_experience',
        'contact_email', 'contact_phone',
        'site_author', 'twitter_handle',
        'job_title_en',
    ];

    /** Image upload fields */
    private const IMAGE_FIELDS = [
        'hero_image', 'about_image', 'site_favicon', 'og_image',
    ];

    public function index()
    {
        // For admin, fetch raw rows so we can edit AR + EN separately
        $rows = Setting::all()->keyBy('key');
        return view('admin.settings', compact('rows'));
    }

    public function update(Request $request)
    {
        // Bilingual textual fields
        foreach (self::BILINGUAL_FIELDS as $field) {
            Setting::set(
                $field,
                $request->input($field, ''),
                $request->input($field . '_en')
            );
        }

        // Single-locale fields
        foreach (self::SINGLE_FIELDS as $field) {
            Setting::set($field, $request->input($field, ''));
        }

        // Image uploads
        foreach (self::IMAGE_FIELDS as $field) {
            if ($request->hasFile($field)) {
                $old = Setting::where('key', $field)->value('value');
                if ($old) Storage::disk('public')->delete($old);
                $path = $request->file($field)->store('settings', 'public');
                Setting::set($field, $path);
            }
        }

        // Ensure storage is accessible
        if (! is_link(public_path('storage'))) {
            Artisan::call('storage:copy');
        }

        return back()->with('success', 'تم حفظ الإعدادات بنجاح');
    }
}
