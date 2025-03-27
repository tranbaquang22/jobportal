<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'name',
        'employment_type',
        'position',
        'salary',
        'deadline',
        'description',
        'requirement',
        'benefit',
        'location',
        'workplace',
        'working_time'
    ];

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }
}
