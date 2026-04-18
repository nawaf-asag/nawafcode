<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['title','description','image','category','technologies','project_url','github_url','order','active','featured'];
    protected $casts = ['active' => 'boolean', 'featured' => 'boolean'];

    public function scopeActive($query) { return $query->where('active', true); }
    public function scopeOrdered($query) { return $query->orderBy('order')->orderBy('id'); }
    public function scopeFeatured($query) { return $query->where('featured', true); }

    public function getTechnologiesArrayAttribute(): array
    {
        return $this->technologies ? array_map('trim', explode(',', $this->technologies)) : [];
    }
}
