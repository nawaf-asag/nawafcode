<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SeoController extends Controller
{
    /** SEO fields editable in BOTH Arabic and English */
    private const BILINGUAL_FIELDS = [
        'meta_title', 'meta_description', 'meta_keywords',
        'og_title', 'og_description',
    ];

    /** Single-value SEO / identity / integration fields */
    private const SINGLE_FIELDS = [
        'site_author', 'twitter_handle', 'job_title_en',
        'ga4_id', 'gsc_verification', 'bing_verification',
    ];

    /** Image upload fields (favicon + social share image) */
    private const IMAGE_FIELDS = [
        'site_favicon', 'og_image',
    ];

    public function index()
    {
        $rows     = Setting::all()->keyBy('key');
        $services = Service::active()->ordered()->get(['id', 'title', 'title_en', 'slug']);

        return view('admin.seo', compact('rows', 'services'));
    }

    public function update(Request $request)
    {
        foreach (self::BILINGUAL_FIELDS as $field) {
            Setting::set($field, $request->input($field, ''), $request->input($field . '_en'));
        }

        foreach (self::SINGLE_FIELDS as $field) {
            Setting::set($field, trim((string) $request->input($field, '')));
        }

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

        if (! is_link(public_path('storage'))) {
            Artisan::call('storage:copy');
        }

        return back()->with('success', 'تم حفظ إعدادات SEO بنجاح');
    }
}
