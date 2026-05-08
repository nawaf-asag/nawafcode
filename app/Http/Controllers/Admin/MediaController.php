<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index()
    {
        $items = Media::latest()->paginate(48);
        return view('admin.media.index', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'files.*' => 'required|image|mimes:jpg,jpeg,png,webp,svg,gif,ico|max:4096',
            'alt'     => 'nullable|string|max:200',
        ]);

        $count = 0;
        foreach ((array) $request->file('files', []) as $file) {
            if (! $file) continue;
            $count += $this->saveFile($file, $request->input('alt')) ? 1 : 0;
        }

        if (! is_link(public_path('storage'))) {
            Artisan::call('storage:copy');
        }

        return back()->with('success', "تم رفع {$count} صورة بنجاح");
    }

    public function destroy(Media $medium)
    {
        $medium->delete(); // booted() removes file
        return back()->with('success', 'تم حذف الصورة');
    }

    /**
     * JSON list for the picker modal.
     */
    public function pickerList(): JsonResponse
    {
        $items = Media::latest()->take(120)->get(['id', 'path', 'original_name', 'alt'])
            ->map(fn (Media $m) => [
                'id'   => $m->id,
                'path' => $m->path,
                'url'  => $m->url(),
                'name' => $m->original_name,
                'alt'  => $m->alt,
            ]);

        return response()->json($items);
    }

    /**
     * Inline upload from picker — returns JSON of the new media.
     */
    public function pickerUpload(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png,webp,svg,gif,ico|max:4096',
        ]);

        $media = $this->saveFile($request->file('file'));

        if (! is_link(public_path('storage'))) {
            Artisan::call('storage:copy');
        }

        return response()->json([
            'id'   => $media->id,
            'path' => $media->path,
            'url'  => $media->url(),
            'name' => $media->original_name,
        ]);
    }

    private function saveFile($file, ?string $alt = null): ?Media
    {
        if (! $file) return null;

        $path = $file->store('media', 'public');

        return Media::create([
            'original_name' => $file->getClientOriginalName(),
            'path'          => $path,
            'mime_type'     => $file->getMimeType(),
            'size'          => $file->getSize(),
            'alt'           => $alt,
        ]);
    }
}
