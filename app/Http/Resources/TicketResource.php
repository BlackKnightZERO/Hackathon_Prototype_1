<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;
use Carbon\Carbon;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'                        => $this->id,
            'ticket_id'                 => $this->ticket_id,
            'link'                      => $this->link,
            'start_day'                 => Carbon::create($this->start_day)->toDateString(),
            'end_day'                   => Carbon::create($this->end_day)->toDateString(),
            'proposed_completion_day'   => $this->proposed_completion_day,
            'status'                    => $this->status,
            'user_id'                   => $this->user_id,
            'user'                      => new UserResource($this->user),
            'approver'                  => new UserResource($this->approver),
            'verify_status'             => $this->verify_status,
            'slug'                      => $this->slug,
        ];
    }
}
