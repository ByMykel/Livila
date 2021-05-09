<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function isListed($listId, $movieId)
    {
        return DB::table('lists_movies')->where('list_id', $listId)->where('movie_id', $movieId)->count() === 1;
    }

    public function getMyLists()
    {
        if (!Auth::user()) {
            return [];
        }

        $lists = ListMovie::where('user_id', Auth::user()->id)
            ->get();

        return $lists;
    }

    public function markListWithMovie($lists, $movieId)
    {
        if (!Auth::user()) {
            return $lists;
        }

        foreach ($lists as $index => $list) {
            $lists[$index]['contains_movie'] = $this->isListed($list->id, $movieId);
        }

        return $lists;
    }
}
