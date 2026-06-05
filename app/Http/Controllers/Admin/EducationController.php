<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index()
    {
        $education = Education::ordered()->get();
        return view('admin.education.index', compact('education'));
    }

    public function create()
    {
        return view('admin.education.form', ['education' => new Education()]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['active']     = $request->boolean('active');
        $data['is_current'] = $request->boolean('is_current');
        Education::create($data);

        return redirect()->route('admin.education.index')->with('success', 'تمت إضافة المؤهل بنجاح');
    }

    public function edit(Education $education)
    {
        return view('admin.education.form', compact('education'));
    }

    public function update(Request $request, Education $education)
    {
        $data = $this->validateData($request);
        $data['active']     = $request->boolean('active');
        $data['is_current'] = $request->boolean('is_current');
        $education->update($data);

        return redirect()->route('admin.education.index')->with('success', 'تم تحديث المؤهل بنجاح');
    }

    public function destroy(Education $education)
    {
        $education->delete();
        return redirect()->route('admin.education.index')->with('success', 'تم حذف المؤهل');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'degree'         => 'required|string|max:200',
            'degree_en'      => 'nullable|string|max:200',
            'institution'    => 'required|string|max:200',
            'institution_en' => 'nullable|string|max:200',
            'note'           => 'nullable|string|max:300',
            'note_en'        => 'nullable|string|max:300',
            'year_from'      => 'nullable|integer|min:1990|max:2100',
            'year_to'        => 'nullable|integer|min:1990|max:2100',
            'order'          => 'integer|min:0',
        ]);
    }
}
