<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Enums\ApproveStatusEnum;

class Ticket extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'ticket_id',
        'link',
        'start_day',
        'end_day',
        'proposed_completion_day',
        'status',
        'user_id',
        'verify_status',
        'slug',
    ];

    public function sluggable(): array {
        return [
            'slug' => [
                'source' => 'ticket_id'
            ]
        ];
    }

    public function scopeApproved($query) {
        return $query->where('verify_status', ApproveStatusEnum::APPROVED->value);
    }

    public function scopeNotapproved($query) {
        return $query->where('verify_status', ApproveStatusEnum::NOT_APPROVED->value);
    }
}
