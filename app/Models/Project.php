<?php
namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title', 'title_en',
        'description', 'description_en',
        'image', 'category', 'technologies',
        'year_from', 'year_to',
        'project_url', 'github_url',
        'order', 'active', 'featured',
    ];
    protected $casts = [
        'active'    => 'boolean',
        'featured'  => 'boolean',
        'year_from' => 'integer',
        'year_to'   => 'integer',
    ];

    public function scopeActive($query)   { return $query->where('active', true); }
    public function scopeOrdered($query)  { return $query->orderBy('order')->orderBy('id'); }
    public function scopeFeatured($query) { return $query->where('featured', true); }

    public function getTechnologiesArrayAttribute(): array
    {
        return $this->technologies ? array_map('trim', explode(',', $this->technologies)) : [];
    }
}
