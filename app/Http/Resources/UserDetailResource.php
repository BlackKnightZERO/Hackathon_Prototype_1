<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailResource extends JsonResource
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
            'academic_email'=> $this->academic_email,
            'personal_email'=> $this->personal_email,
            'institution'   => $this->institution,
            'program'       => $this->program,
            'program_start' => $this->program_start,
            'program_end'   => $this->program_end,
            'phone_1'       => $this->phone_1,
            'phone_2'       => $this->phone_2,
            'image_path'    => $this->image_path,
            'resume_path'   => $this->resume_path,
        ];
    }
}
