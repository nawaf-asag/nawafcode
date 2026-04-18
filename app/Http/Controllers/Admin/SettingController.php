<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key');
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $fields = [
            'hero_name', 'hero_title', 'hero_subtitle', 'hero_description',
            'about_text', 'contact_email', 'contact_phone', 'contact_location',
            'meta_title', 'meta_description', 'cv_url',
        ];

        foreach ($fields as $field) {
            Setting::set($field, $request->input($field, ''));
        }

        if ($request->hasFile('hero_image')) {
            $old = Setting::get('hero_image');
            if ($old) Storage::disk('public')->delete($old);
            $path = $request->file('hero_image')->store('settings', 'public');
            Setting::set('hero_image', $path);
        }

        if ($request->hasFile('about_image')) {
            $old = Setting::get('about_image');
            if ($old) Storage::disk('public')->delete($old);
            $path = $request->file('about_image')->store('settings', 'public');
            Setting::set('about_image', $path);
        }

        return back()->with('success', 'تم حفظ الإعدادات بنجاح');
    }
}
