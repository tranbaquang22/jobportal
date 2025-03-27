<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'user_in_charge_id',
        'start_time',
        'end_time',
        'requirement',
        'status'
    ];

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }
}
