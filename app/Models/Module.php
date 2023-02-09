<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\Permission;

class Module extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'title',
        'slug',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function sluggable(): array {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function permissions() {
        return $this->hasMany(Permission::class);
    }
}
