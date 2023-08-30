<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'ticket_id'             => ['required', 'string'],
            'link'                  => ['required', 'string'],
            'start_day'             => ['required'],
            'end_day'               => ['required'],
            'proposed_completion_day' => ['required'],
            'status'                => ['required'],
            'user_id'               => ['required'],
            'approver_id'           => ['required'],
            'verify_status'         => ['required'],
        ];
    }
}
