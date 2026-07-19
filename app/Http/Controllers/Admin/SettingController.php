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
    ];

    /** Fields stored as a single value (no translation) */
    private const SINGLE_FIELDS = [
        'cv_url', 'years_experience',
        'contact_email', 'contact_phone',
    ];

    /** Image upload fields */
    private const IMAGE_FIELDS = [
        'hero_image', 'about_image',
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

        // Image fields — accept either uploaded file OR a path picked from media library
        foreach (self::IMAGE_FIELDS as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $path = $file->store('media', 'public');
                \App\Models\Media::create([
                    'original_name' => $file->getClientOriginalName(),
                    'path'          => $path,
                    'mime_type'     => $file->getMimeType(),
                    'size'          => $file->getSize(),
                ]);
                Setting::set($field, $path);
            } elseif ($request->has($field . '_path')) {
                Setting::set($field, $request->input($field . '_path') ?: '');
            }
        }

        // CV file (PDF/DOC) — uploaded document takes priority over the external link
        if ($request->hasFile('cv_file')) {
            $request->validate(['cv_file' => 'file|mimes:pdf,doc,docx|max:8192']);
            $path = $request->file('cv_file')->store('cv', 'public');
            Setting::set('cv_file', $path);
        } elseif ($request->boolean('cv_file_remove')) {
            Setting::set('cv_file', '');
        }

        // Ensure storage is accessible
        if (! is_link(public_path('storage'))) {
            Artisan::call('storage:copy');
        }

        return back()->with('success', 'تم حفظ الإعدادات بنجاح');
    }
}
