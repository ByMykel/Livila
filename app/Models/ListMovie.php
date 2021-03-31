<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListMovie extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'lists';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes_lists', 'list_id');
    }

    public function scopePublic($query)
    {
        return $query->where('visibility', 1);
    }

    public function scopePrivate($query)
    {
        return $query->where('visibility', 0);
    }
}
