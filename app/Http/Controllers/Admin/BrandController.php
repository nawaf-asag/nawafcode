<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::ordered()->get();
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.form', ['brand' => new Brand()]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['logo']   = $this->resolveImage($request, 'logo', null);
        $data['active'] = $request->boolean('active');
        Brand::create($data);

        return redirect()->route('admin.brands.index')->with('success', 'تمت إضافة البراند بنجاح');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.form', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $data = $this->validateData($request);
        $data['logo']   = $this->resolveImage($request, 'logo', $brand->logo);
        $data['active'] = $request->boolean('active');
        $brand->update($data);

        return redirect()->route('admin.brands.index')->with('success', 'تم تحديث البراند بنجاح');
    }

    public function destroy(Brand $brand)
    {
        // Don't delete file — it may be reused via media library
        $brand->delete();
        return redirect()->route('admin.brands.index')->with('success', 'تم حذف البراند');
    }

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
            if (! is_link(public_path('storage'))) \Illuminate\Support\Facades\Artisan::call('storage:copy');
            return $path;
        }

        $picked = $request->input($field . '_path');
        if ($picked !== null) return $picked ?: null;

        return $current;
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'name'             => 'required|string|max:120',
            'website'          => 'nullable|string|max:255',
            'contribution'     => 'nullable|string|max:200',
            'contribution_en'  => 'nullable|string|max:200',
            'order'            => 'integer|min:0',
            'active'           => 'boolean',
            'logo'             => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
        ]);
    }

}
