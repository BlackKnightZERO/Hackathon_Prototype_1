<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Enums\ApproveStatusEnum;
use App\Models\User;
use App\Enums\TicketStatusEnum;

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
        'approver_id',
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

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function approver() {
        return $this->belongsTo(User::class);
    }

    public function scopeApproved($query) {
        return $query->where('verify_status', ApproveStatusEnum::APPROVED->value);
    }

    public function scopeNotApproved($query) {
        return $query->where('verify_status', ApproveStatusEnum::NOT_APPROVED->value);
    }

    public function scopeFilterByStatus($query, $status) {
        switch ($status) {
            case TicketStatusEnum::PENDING->value: 
                return $query->where('status', TicketStatusEnum::PENDING->value);
                break;
            case TicketStatusEnum::IN_PROGRESS->value: 
                return $query->where('status', TicketStatusEnum::IN_PROGRESS->value);
                break;
            case TicketStatusEnum::COMPLETED->value: 
                return $query->where('status', TicketStatusEnum::COMPLETED->value);
                break;
            case TicketStatusEnum::QA_PASSED->value: 
                return $query->where('status', TicketStatusEnum::QA_PASSED->value);
                break;
            case TicketStatusEnum::PROD_READY->value: 
                return $query->where('status', TicketStatusEnum::PROD_READY->value);
                break;
            case TicketStatusEnum::IN_PROD->value: 
                return $query->where('status', TicketStatusEnum::IN_PROD->value);
                break;
            default:
                return $query;
                break;  
          }
    }
}
