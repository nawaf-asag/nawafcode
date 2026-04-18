<?php
namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Project;
use App\Models\Contact;
use App\Models\SocialLink;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::active()->ordered()->get();
        $projects = Project::active()->ordered()->get();
        $socialLinks = SocialLink::active()->ordered()->get();
        $settings = Setting::pluck('value', 'key');

        return view('home', compact('services', 'projects', 'socialLinks', 'settings'));
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

        return back()->with('success', 'تم إرسال رسالتك بنجاح! سأتواصل معك قريباً.');
    }
}
