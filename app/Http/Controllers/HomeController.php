<?php
namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Project;
use App\Models\Experience;
use App\Models\Education;
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
        $experiences = Experience::active()->ordered()->get();
        $education   = Education::active()->ordered()->get();
        $brands      = Brand::active()->ordered()->get();
        $socialLinks = SocialLink::active()->ordered()->get();
        $settings    = Setting::localizedAll();

        return view('home', compact('services', 'projects', 'experiences', 'education', 'brands', 'socialLinks', 'settings'));
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

    /**
     * Multilingual XML sitemap — lists both language URLs with reciprocal
     * hreflang alternates so Google can index Arabic and English separately.
     */
    public function sitemap()
    {
        $ar = url('/');
        $en = url('/en');
        $lastmod = now()->toAtomString();

        $urls = [
            ['loc' => $ar, 'alt' => ['ar' => $ar, 'en' => $en]],
            ['loc' => $en, 'alt' => ['ar' => $ar, 'en' => $en]],
        ];

        $xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";
        foreach ($urls as $u) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$u['loc']}</loc>\n";
            $xml .= "    <lastmod>{$lastmod}</lastmod>\n";
            $xml .= "    <changefreq>weekly</changefreq>\n";
            $xml .= "    <priority>1.0</priority>\n";
            foreach ($u['alt'] as $hl => $href) {
                $xml .= "    <xhtml:link rel=\"alternate\" hreflang=\"{$hl}\" href=\"{$href}\"/>\n";
            }
            $xml .= "    <xhtml:link rel=\"alternate\" hreflang=\"x-default\" href=\"{$ar}\"/>\n";
            $xml .= "  </url>\n";
        }
        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }

    public function robots()
    {
        $body  = "User-agent: *\n";
        $body .= "Allow: /\n";
        $body .= "Disallow: /admin\n\n";
        $body .= "Sitemap: " . url('/sitemap.xml') . "\n";

        return response($body, 200, ['Content-Type' => 'text/plain']);
    }
}
