<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class CoopTerm extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'user_id',
        'ministry_id',
        'term',
        'term_start',
        'term_end',
        'slug'
    ];

    public function sluggable(): array {
        return [
            'slug' => [
                'source' => 'term'
            ]
        ];
    }
}
