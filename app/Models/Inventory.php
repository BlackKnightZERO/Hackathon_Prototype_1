<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Inventory extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'title',
        'type',
        'manufacturer',
        'model',
        'serial_number',
        'user_id',
        'slug',
    ];

    public function sluggable(): array {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function scopeAvailable($query) {
        return $query->where('user_id', 1);
    }

    public function scopeUnavailable($query) {
        return $query->where('user_id', '!=', 1);
    }
}
