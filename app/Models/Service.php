<?php
namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title', 'title_en', 'slug', 'description', 'description_en',
        'content', 'content_en', 'icon', 'cover_image',
        'meta_title', 'meta_title_en', 'meta_description', 'meta_description_en',
        'keywords', 'keywords_en', 'faq', 'faq_en',
        'order', 'active',
    ];
    protected $casts = ['active' => 'boolean'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        // Auto-generate a unique slug from the title when one isn't provided.
        static::saving(function (Service $service) {
            if (blank($service->slug)) {
                $service->slug = static::uniqueSlug(static::slugify($service->title) ?: 'service', $service->id);
            }
        });
    }

    /**
     * Unicode-aware slugify — keeps Arabic letters (Str::slug would strip them),
     * lowercases, and collapses whitespace/invalid chars to single hyphens.
     */
    public static function slugify(?string $value): string
    {
        $value = trim((string) $value);
        if ($value === '') return '';

        $value = preg_replace('/\s+/u', '-', $value);
        $value = preg_replace('/[^\p{L}\p{N}\-_]+/u', '', $value);
        $value = preg_replace('/-+/', '-', $value);

        return trim(mb_strtolower($value), '-_');
    }

    public static function uniqueSlug(string $base, $ignoreId = null): string
    {
        $base = $base ?: 'service';
        $slug = $base;
        $i    = 2;
        while (static::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = $base . '-' . $i++;
        }
        return $slug;
    }

    public function scopeActive($query)  { return $query->where('active', true); }
    public function scopeOrdered($query) { return $query->orderBy('order')->orderBy('id'); }

    /**
     * Parse the localized FAQ text ("question | answer" per line) into pairs.
     * @return array<int, array{q: string, a: string}>
     */
    public function faqPairs(): array
    {
        $raw = $this->localized('faq');
        if (blank($raw)) return [];

        $pairs = [];
        foreach (preg_split('/\r\n|\r|\n/', $raw) as $line) {
            $line = trim($line);
            if ($line === '' || ! str_contains($line, '|')) continue;
            [$q, $a] = array_map('trim', explode('|', $line, 2));
            if ($q !== '' && $a !== '') {
                $pairs[] = ['q' => $q, 'a' => $a];
            }
        }
        return $pairs;
    }

    /**
     * Localized keywords as a clean list (comma-separated input).
     * @return array<int, string>
     */
    public function keywordsList(): array
    {
        $raw = $this->localized('keywords');
        if (blank($raw)) return [];

        return array_values(array_filter(array_map('trim', explode(',', $raw))));
    }
}
