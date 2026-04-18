<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    protected $fillable = ['platform', 'url', 'icon', 'order', 'active'];
    protected $casts = ['active' => 'boolean'];

    public function scopeActive($query) { return $query->where('active', true); }
    public function scopeOrdered($query) { return $query->orderBy('order')->orderBy('id'); }
}
