<?php
namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasTranslations;

    protected $table = 'education';

    protected $fillable = [
        'degree', 'degree_en',
        'institution', 'institution_en',
        'note', 'note_en',
        'year_from', 'year_to', 'is_current',
        'order', 'active',
    ];

    protected $casts = [
        'active'     => 'boolean',
        'is_current' => 'boolean',
        'year_from'  => 'integer',
        'year_to'    => 'integer',
    ];

    public function scopeActive($query)  { return $query->where('active', true); }
    public function scopeOrdered($query) { return $query->orderBy('order')->orderBy('id'); }
}
