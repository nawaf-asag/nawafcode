<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index()
    {
        $experiences = Experience::ordered()->get();
        return view('admin.experiences.index', compact('experiences'));
    }

    public function create()
    {
        return view('admin.experiences.form', ['experience' => new Experience()]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['active']     = $request->boolean('active');
        $data['is_current'] = $request->boolean('is_current');
        Experience::create($data);

        return redirect()->route('admin.experiences.index')->with('success', 'تمت إضافة الخبرة بنجاح');
    }

    public function edit(Experience $experience)
    {
        return view('admin.experiences.form', compact('experience'));
    }

    public function update(Request $request, Experience $experience)
    {
        $data = $this->validateData($request);
        $data['active']     = $request->boolean('active');
        $data['is_current'] = $request->boolean('is_current');
        $experience->update($data);

        return redirect()->route('admin.experiences.index')->with('success', 'تم تحديث الخبرة بنجاح');
    }

    public function destroy(Experience $experience)
    {
        $experience->delete();
        return redirect()->route('admin.experiences.index')->with('success', 'تم حذف الخبرة');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'role'           => 'required|string|max:200',
            'role_en'        => 'nullable|string|max:200',
            'company'        => 'required|string|max:200',
            'company_en'     => 'nullable|string|max:200',
            'description'    => 'nullable|string',
            'description_en' => 'nullable|string',
            'year_from'      => 'nullable|integer|min:1990|max:2100',
            'year_to'        => 'nullable|integer|min:1990|max:2100',
            'technologies'   => 'nullable|string|max:500',
            'order'          => 'integer|min:0',
        ]);
    }
}
