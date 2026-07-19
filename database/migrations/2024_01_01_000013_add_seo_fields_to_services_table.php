<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('id');
            $table->string('cover_image')->nullable()->after('icon');

            // Rich landing-page body (HTML allowed — authored by trusted admin)
            $table->longText('content')->nullable()->after('description_en');
            $table->longText('content_en')->nullable()->after('content');

            // Per-service SEO
            $table->string('meta_title')->nullable()->after('content_en');
            $table->string('meta_title_en')->nullable()->after('meta_title');
            $table->string('meta_description', 500)->nullable()->after('meta_title_en');
            $table->string('meta_description_en', 500)->nullable()->after('meta_description');
            $table->text('keywords')->nullable()->after('meta_description_en');
            $table->text('keywords_en')->nullable()->after('keywords');

            // FAQ — one "question | answer" pair per line
            $table->text('faq')->nullable()->after('keywords_en');
            $table->text('faq_en')->nullable()->after('faq');
        });

        // Backfill slugs for existing rows, guaranteeing uniqueness.
        // Unicode-aware so Arabic titles keep readable slugs (Str::slug strips them).
        $slugify = function (?string $value): string {
            $value = trim((string) $value);
            if ($value === '') return '';
            $value = preg_replace('/\s+/u', '-', $value);
            $value = preg_replace('/[^\p{L}\p{N}\-_]+/u', '', $value);
            $value = preg_replace('/-+/', '-', $value);
            return trim(mb_strtolower($value), '-_');
        };

        $used = [];
        foreach (DB::table('services')->get() as $service) {
            if (! empty($service->slug)) {
                $used[] = $service->slug;
                continue;
            }

            $base = $slugify($service->title) ?: 'service';
            $slug = $base;
            $i    = 2;
            while (in_array($slug, $used, true)) {
                $slug = $base . '-' . $i++;
            }
            $used[] = $slug;

            DB::table('services')->where('id', $service->id)->update(['slug' => $slug]);
        }
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn([
                'slug', 'cover_image', 'content', 'content_en',
                'meta_title', 'meta_title_en', 'meta_description', 'meta_description_en',
                'keywords', 'keywords_en', 'faq', 'faq_en',
            ]);
        });
    }
};
