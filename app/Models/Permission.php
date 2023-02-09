<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\Module;
use App\Models\Role;

class Permission extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'title',
        'module_id',
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

    public function module() {
        return $this->belongsTo(Module::class);
    }

    public function roles() {
        return $this->belongsToMany(Role::class);
    }

}
