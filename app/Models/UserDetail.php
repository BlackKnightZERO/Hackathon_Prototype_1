<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'academic_email',
        'personal_email',
        'institution',
        'program',
        'program_start',
        'program_end',
        'phone_1',
        'phone_2',
        'image_path',
        'resume_path',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
