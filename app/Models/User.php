<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\Role;
use App\Models\Ticket;

use App\Models\UserDetail;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'username',
        'password',
        'is_admin',
        'slug'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'email_verified_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeAdmin($query) {
        return $query->where('is_admin', 1);
    }

    public function userDetail() {
        return $this->hasOne(UserDetail::class);
    }

    public function sluggable(): array {
        return [
            'slug' => [
                'source' => 'first_name'
            ]
        ];
    }

    public function role() {
        return $this->belongsTo(Role::class);
    }

    // public function hasPermission($permission):bool {
    //     return $this->role->permissions->where('slug', $permission)->first() ? true : false;
    // }

    public function inventories() {
        return $this->hasMany(Inventory::class);
    }

    public function tickets() {
        return $this->hasMany(Ticket::class);
    }
}
