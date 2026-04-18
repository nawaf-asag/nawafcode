<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class StorageCopy extends Command
{
    protected $signature   = 'storage:copy';
    protected $description = 'Copy storage/app/public to public/storage (for shared hosting without symlink support)';

    public function handle(): void
    {
        $src  = storage_path('app/public');
        $dest = public_path('storage');

        if (!File::exists($src)) {
            File::makeDirectory($src, 0755, true);
        }

        if (is_link($dest)) {
            $this->info('Symlink already exists — no action needed.');
            return;
        }

        if (!File::exists($dest)) {
            File::makeDirectory($dest, 0755, true);
        }

        File::copyDirectory($src, $dest);

        $this->info('تم نسخ ملفات storage إلى public/storage بنجاح');
    }
}
