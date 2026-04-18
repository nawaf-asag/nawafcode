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
            'title'        => 'required|string|max:200',
            'description'  => 'required|string',
            'category'     => 'required|string|max:100',
            'technologies' => 'nullable|string|max:500',
            'project_url'  => 'nullable|url|max:500',
            'github_url'   => 'nullable|url|max:500',
            'order'        => 'integer|min:0',
            'active'       => 'boolean',
            'featured'     => 'boolean',
            'image'        => 'nullable|image|max:2048',
        ]);

        $data['active']   = $request->boolean('active');
        $data['featured'] = $request->boolean('featured');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('projects', 'public');
            if (!is_link(public_path('storage'))) Artisan::call('storage:copy');
        }

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
            'title'        => 'required|string|max:200',
            'description'  => 'required|string',
            'category'     => 'required|string|max:100',
            'technologies' => 'nullable|string|max:500',
            'project_url'  => 'nullable|url|max:500',
            'github_url'   => 'nullable|url|max:500',
            'order'        => 'integer|min:0',
            'active'       => 'boolean',
            'featured'     => 'boolean',
            'image'        => 'nullable|image|max:2048',
        ]);

        $data['active']   = $request->boolean('active');
        $data['featured'] = $request->boolean('featured');

        if ($request->hasFile('image')) {
            if ($project->image) Storage::disk('public')->delete($project->image);
            $data['image'] = $request->file('image')->store('projects', 'public');
            if (!is_link(public_path('storage'))) Artisan::call('storage:copy');
        }

        $project->update($data);
        return redirect()->route('admin.projects.index')->with('success', 'تم تحديث المشروع بنجاح');
    }

    public function destroy(Project $project)
    {
        if ($project->image) Storage::disk('public')->delete($project->image);
        $project->delete();
        return redirect()->route('admin.projects.index')->with('success', 'تم حذف المشروع');
    }
}
