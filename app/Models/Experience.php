<?php
namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasTranslations;

    protected $fillable = [
        'role', 'role_en',
        'company', 'company_en',
        'description', 'description_en',
        'year_from', 'year_to', 'is_current',
        'technologies', 'order', 'active',
    ];

    protected $casts = [
        'active'     => 'boolean',
        'is_current' => 'boolean',
        'year_from'  => 'integer',
        'year_to'    => 'integer',
    ];

    public function scopeActive($query)  { return $query->where('active', true); }
    public function scopeOrdered($query) { return $query->orderBy('order')->orderBy('id'); }

    public function getTechnologiesArrayAttribute(): array
    {
        return $this->technologies ? array_map('trim', explode(',', $this->technologies)) : [];
    }
}
