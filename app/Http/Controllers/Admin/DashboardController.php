<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Project;
use App\Models\Contact;
use App\Models\SocialLink;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'services'  => Service::count(),
            'projects'  => Project::count(),
            'contacts'  => Contact::count(),
            'unread'    => Contact::where('is_read', false)->count(),
            'socials'   => SocialLink::count(),
        ];

        $recentContacts = Contact::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentContacts'));
    }
}
