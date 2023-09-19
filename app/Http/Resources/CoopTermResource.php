<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CoopTermResource extends JsonResource
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
            'user_id'       => $this->user_id,
            'ministry_id'   => $this->ministry_id,
            'ministry'      => new MinistryResource($this->ministry),
            'term'          => $this->term,
            'term_start'    => $this->term_start,
            'term_end'      => $this->term_end,
            'position'      => $this->position,
            'slug'          => $this->slug,
        ];
    }
}
