<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Contact;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\SocialLink;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        $stats = [
            'services'    => Service::count(),
            'projects'    => Project::count(),
            'experiences' => Experience::count(),
            'education'   => Education::count(),
            'brands'      => Brand::count(),
            'contacts'    => Contact::count(),
            'unread'      => Contact::where('is_read', false)->count(),
            'socials'     => SocialLink::count(),
        ];

        // Messages per month over the last 12 months — grouped in PHP so it works
        // the same on SQLite and MySQL (no DATE_FORMAT dialect differences).
        $counts = [];
        foreach (Contact::get(['created_at']) as $c) {
            if (! $c->created_at) continue;
            $key = $c->created_at->format('Y-m');
            $counts[$key] = ($counts[$key] ?? 0) + 1;
        }

        $months = [];
        $cursor = Carbon::now()->startOfMonth()->subMonths(11);
        for ($i = 0; $i < 12; $i++) {
            $key = $cursor->format('Y-m');
            $months[] = [
                'label' => $cursor->translatedFormat('M y'),
                'value' => $counts[$key] ?? 0,
            ];
            $cursor->addMonth();
        }

        // Content distribution for the doughnut chart
        $contentMix = [
            ['label' => 'الخدمات',      'value' => $stats['services']],
            ['label' => 'الأعمال',      'value' => $stats['projects']],
            ['label' => 'الخبرات',      'value' => $stats['experiences']],
            ['label' => 'التعليم',      'value' => $stats['education']],
            ['label' => 'البراندات',    'value' => $stats['brands']],
        ];

        $ga4Id       = Setting::where('key', 'ga4_id')->value('value');
        $gscVerified = filled(Setting::where('key', 'gsc_verification')->value('value'));

        $recentContacts = Contact::latest()->take(6)->get();

        return view('admin.analytics', compact(
            'stats', 'months', 'contentMix', 'ga4Id', 'gscVerified', 'recentContacts'
        ));
    }
}
