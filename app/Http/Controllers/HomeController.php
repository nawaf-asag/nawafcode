<?php
namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Project;
use App\Models\Brand;
use App\Models\Contact;
use App\Models\SocialLink;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $services    = Service::active()->ordered()->get();
        $projects    = Project::active()->ordered()->get();
        $brands      = Brand::active()->ordered()->get();
        $socialLinks = SocialLink::active()->ordered()->get();
        $settings    = Setting::localizedAll();

        return view('home', compact('services', 'projects', 'brands', 'socialLinks', 'settings'));
    }

    public function contact(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:100',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:2000',
        ]);

        Contact::create($validated);

        return back()->with('success', __('site.contact_success'));
    }
}
