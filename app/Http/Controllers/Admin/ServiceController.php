<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::ordered()->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.form', ['service' => new Service()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'           => 'required|string|max:200',
            'title_en'        => 'nullable|string|max:200',
            'description'     => 'required|string',
            'description_en'  => 'nullable|string',
            'icon'            => 'required|string|max:100',
            'order'           => 'integer|min:0',
            'active'          => 'boolean',
        ]);

        $data['active'] = $request->boolean('active');
        Service::create($data);

        return redirect()->route('admin.services.index')->with('success', 'تمت إضافة الخدمة بنجاح');
    }

    public function edit(Service $service)
    {
        return view('admin.services.form', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'title'           => 'required|string|max:200',
            'title_en'        => 'nullable|string|max:200',
            'description'     => 'required|string',
            'description_en'  => 'nullable|string',
            'icon'            => 'required|string|max:100',
            'order'           => 'integer|min:0',
            'active'          => 'boolean',
        ]);

        $data['active'] = $request->boolean('active');
        $service->update($data);

        return redirect()->route('admin.services.index')->with('success', 'تم تحديث الخدمة بنجاح');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'تم حذف الخدمة');
    }
}
