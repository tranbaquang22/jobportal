<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InterviewCandidate extends Model
{
    use HasFactory;

    protected $table = 'interview_candidate';

    protected $fillable = [
        'interview_id',
        'candidate_id',
        'type'
    ];

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(Candidate::class);
    }

    public function interview(): BelongsTo
    {
        return $this->belongsTo(Interview::class);
    }
}
