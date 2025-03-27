<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Interview extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'date',
        'start_time',
        'end_time',
        'interviewer_names',
        'interviewer_emails',
        'status',
        'interviewer_mail_status',
        'candidate_mail_status'
    ];

    public function interview_candidate(): HasMany
    {
        return $this->hasMany(InterviewCandidate::class);
    }
}
