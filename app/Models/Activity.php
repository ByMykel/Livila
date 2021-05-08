<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['created_at_human'];

    protected $casts = [
        'data' => 'array',
        'created_at' => 'datetime:H:i · M d, Y'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtHumanAttribute()
    {
        if ($this->created_at) {
            return $this->created_at->diffForHumans();
        }

        return "";
    }
}
