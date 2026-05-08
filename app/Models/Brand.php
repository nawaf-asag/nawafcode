<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasTranslations;

    protected $fillable = [
        'name',
        'logo',
        'icon',
        'website',
        'contribution',
        'contribution_en',
        'order',
        'active',
    ];

    protected $casts = ['active' => 'boolean'];

    public function scopeActive($query)  { return $query->where('active', true); }
    public function scopeOrdered($query) { return $query->orderBy('order')->orderBy('id'); }
}
