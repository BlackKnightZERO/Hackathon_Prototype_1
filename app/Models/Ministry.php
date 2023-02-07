<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Ministry extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'title',
        'short_title',
        'description',
        'slug',
    ];

    public function sluggable(): array {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
