<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /** Shared validation rules for store + update. */
    private function rules(): array
    {
        return [
            'title'               => 'required|string|max:200',
            'title_en'            => 'nullable|string|max:200',
            'slug'                => 'nullable|string|max:200',
            'description'         => 'required|string',
            'description_en'      => 'nullable|string',
            'content'             => 'nullable|string',
            'content_en'          => 'nullable|string',
            'cover_image_path'    => 'nullable|string|max:255',
            'meta_title'          => 'nullable|string|max:200',
            'meta_title_en'       => 'nullable|string|max:200',
            'meta_description'    => 'nullable|string|max:500',
            'meta_description_en' => 'nullable|string|max:500',
            'keywords'            => 'nullable|string',
            'keywords_en'         => 'nullable|string',
            'faq'                 => 'nullable|string',
            'faq_en'              => 'nullable|string',
            'icon'                => 'required|string|max:100',
            'order'               => 'integer|min:0',
            'active'              => 'boolean',
        ];
    }

    /** Map validated input to model attributes (slug handled by caller). */
    private function payload(Request $request, array $data): array
    {
        $data['cover_image'] = $request->input('cover_image_path') ?: null;
        $data['active']      = $request->boolean('active');
        unset($data['cover_image_path'], $data['slug']);
        return $data;
    }

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
        $data = $request->validate($this->rules());
        $payload = $this->payload($request, $data);

        // Explicit slug wins (made unique); blank lets the model derive it from the title.
        if (filled($data['slug'])) {
            $payload['slug'] = Service::uniqueSlug(Service::slugify($data['slug']));
        }

        Service::create($payload);

        return redirect()->route('admin.services.index')->with('success', 'تمت إضافة الخدمة بنجاح');
    }

    public function edit(Service $service)
    {
        return view('admin.services.form', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate($this->rules());
        $payload = $this->payload($request, $data);

        // Only touch the slug when the admin typed one; blank keeps the current URL stable.
        if (filled($data['slug'])) {
            $payload['slug'] = Service::uniqueSlug(Service::slugify($data['slug']), $service->id);
        }

        $service->update($payload);

        return redirect()->route('admin.services.index')->with('success', 'تم تحديث الخدمة بنجاح');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', 'تم حذف الخدمة');
    }
}
