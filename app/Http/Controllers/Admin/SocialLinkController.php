<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
    public function index()
    {
        $links = SocialLink::ordered()->get();
        return view('admin.socials.index', compact('links'));
    }

    public function create()
    {
        return view('admin.socials.form', ['link' => new SocialLink()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'platform' => 'required|string|max:100',
            'url'      => 'required|url|max:500',
            'icon'     => 'required|string|max:100',
            'order'    => 'integer|min:0',
            'active'   => 'boolean',
        ]);

        $data['active'] = $request->boolean('active');
        SocialLink::create($data);

        return redirect()->route('admin.socials.index')->with('success', 'تمت الإضافة بنجاح');
    }

    public function edit(SocialLink $social)
    {
        return view('admin.socials.form', ['link' => $social]);
    }

    public function update(Request $request, SocialLink $social)
    {
        $data = $request->validate([
            'platform' => 'required|string|max:100',
            'url'      => 'required|url|max:500',
            'icon'     => 'required|string|max:100',
            'order'    => 'integer|min:0',
            'active'   => 'boolean',
        ]);

        $data['active'] = $request->boolean('active');
        $social->update($data);

        return redirect()->route('admin.socials.index')->with('success', 'تم التحديث بنجاح');
    }

    public function destroy(SocialLink $social)
    {
        $social->delete();
        return redirect()->route('admin.socials.index')->with('success', 'تم الحذف');
    }
}
