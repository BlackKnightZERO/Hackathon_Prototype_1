<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id'            => $this->id,
            'first_name'    => $this->first_name,
            'last_name'     => $this->last_name,
            'full_name'     => $this->first_name . " " .$this->last_name,
            'email'         => $this->email,
            'username'      => $this->username,
            'is_admin'      => $this->is_admin == 1 ? 'Yes' : 'No',
            'slug'          => $this->slug,
            'role'          => new RoleResource($this->whenLoaded('role')),
            'userDetail'    => new UserDetailResource($this->whenLoaded('userDetail')),
            'coopTerms'     => new CoopTermResource($this->whenLoaded('coopTerms')),
            'tickets'       => new TicketResource($this->whenLoaded('tickets')),
        ];
    }
}
