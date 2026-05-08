<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $table = 'media';

    protected $fillable = ['original_name', 'path', 'mime_type', 'size', 'alt'];

    public function url(): string
    {
        return asset('storage/' . $this->path);
    }

    public function humanSize(): string
    {
        $bytes = (int) $this->size;
        if ($bytes < 1024) return $bytes . ' B';
        if ($bytes < 1048576) return round($bytes / 1024, 1) . ' KB';
        return round($bytes / 1048576, 2) . ' MB';
    }

    /**
     * Ensure the underlying file is also removed when the model is deleted.
     */
    protected static function booted(): void
    {
        static::deleting(function (Media $m) {
            if ($m->path && Storage::disk('public')->exists($m->path)) {
                Storage::disk('public')->delete($m->path);
            }
        });
    }
}
