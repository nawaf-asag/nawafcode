<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::ordered()->get();
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.form', ['project' => new Project()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'           => 'required|string|max:200',
            'title_en'        => 'nullable|string|max:200',
            'description'     => 'required|string',
            'description_en'  => 'nullable|string',
            'category'        => 'required|string|max:100',
            'technologies'    => 'nullable|string|max:500',
            'year_from'       => 'nullable|integer|min:1990|max:2100',
            'year_to'         => 'nullable|integer|min:1990|max:2100',
            'project_url'     => 'nullable|url|max:500',
            'github_url'      => 'nullable|url|max:500',
            'order'           => 'integer|min:0',
            'active'          => 'boolean',
            'featured'        => 'boolean',
            'image'           => 'nullable|image|max:2048',
        ]);

        $data['active']   = $request->boolean('active');
        $data['featured'] = $request->boolean('featured');

        $data['image'] = $this->resolveImage($request, 'image', null);
        Project::create($data);
        return redirect()->route('admin.projects.index')->with('success', 'تمت إضافة المشروع بنجاح');
    }

    public function edit(Project $project)
    {
        return view('admin.projects.form', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'title'           => 'required|string|max:200',
            'title_en'        => 'nullable|string|max:200',
            'description'     => 'required|string',
            'description_en'  => 'nullable|string',
            'category'        => 'required|string|max:100',
            'technologies'    => 'nullable|string|max:500',
            'year_from'       => 'nullable|integer|min:1990|max:2100',
            'year_to'         => 'nullable|integer|min:1990|max:2100',
            'project_url'     => 'nullable|url|max:500',
            'github_url'      => 'nullable|url|max:500',
            'order'           => 'integer|min:0',
            'active'          => 'boolean',
            'featured'        => 'boolean',
            'image'           => 'nullable|image|max:2048',
        ]);

        $data['active']   = $request->boolean('active');
        $data['featured'] = $request->boolean('featured');

        $data['image'] = $this->resolveImage($request, 'image', $project->image);
        $project->update($data);
        return redirect()->route('admin.projects.index')->with('success', 'تم تحديث المشروع بنجاح');
    }

    public function destroy(Project $project)
    {
        // Don't delete the image file — it might be used elsewhere via media library
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'تم حذف المشروع');
    }

    /**
     * Resolve image source — file upload takes priority, then library path,
     * then fall back to existing value.
     */
    private function resolveImage(Request $request, string $field, ?string $current): ?string
    {
        if ($request->hasFile($field)) {
            $path = $request->file($field)->store('media', 'public');
            \App\Models\Media::create([
                'original_name' => $request->file($field)->getClientOriginalName(),
                'path'          => $path,
                'mime_type'     => $request->file($field)->getMimeType(),
                'size'          => $request->file($field)->getSize(),
            ]);
            if (!is_link(public_path('storage'))) Artisan::call('storage:copy');
            return $path;
        }

        $picked = $request->input($field . '_path');
        if ($picked !== null) return $picked ?: null;

        return $current;
    }
}
