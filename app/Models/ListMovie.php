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

    public function getNumberOfMoviesInAList($list)
    {
        $number = DB::table('lists_movies')
            ->where('list_id', $list->id)
            ->get()
            ->count();

        return $number;
    }

    public function getNumberOfWatchedMoviesInAList($moviesIds)
    {
        if (!Auth::user()) {
            return 0;
        }

        $number = DB::table('movies_watched')
            ->where('user_id', Auth::user()->id)
            ->whereIn('movie_id', $moviesIds)
            ->get()
            ->count();

        return $number;
    }

    public function getListsByIds($ids)
    {
        $lists = ListMovie::whereIn('id', $ids)
            ->with('user')
            ->withCount('likes')
            ->latest()
            ->get();

        return $lists;
    }


    public function getListById($id)
    {
        $list = ListMovie::where('id', $id)
            ->withcount(['likes as like' => function ($q) {
                return $q->where('user_id', Auth::id());
            }])
            ->with('user')
            ->withCount('likes')
            ->latest()
            ->get();

        return $list[0];
    }

    public function getMoviesFromAList(ListMovie $list, $numberOfMovies = 40)
    {
        $lists = DB::table('lists_movies')
            ->where('list_id', $list->id)
            ->paginate($numberOfMovies);

        return $lists;
    }

    public function getLikedLists(User $user)
    {
        $lists = DB::table('likes_lists')
            ->where('user_id', $user->id)
            ->latest()
            ->select('list_id')
            ->paginate(15);

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

    public function getListsByName($query)
    {
        $terms = explode(" ", $query);

        $lists = ListMovie::query()
            ->where(function ($query) use ($terms) {
                foreach ($terms as $term) {
                    $query->orWhere('name', 'like', '%' . $term . '%');
                }
            })
            ->orWhere(function ($query) use ($terms) {
                foreach ($terms as $term) {
                    $query->orWhere('description', 'like', '%' . $term . '%');
                }
            })
            ->withcount(['likes as like' => function ($q) {
                return $q->where('user_id', Auth::id());
            }])
            ->with('user')
            ->withCount('likes')
            ->distinct()
            ->paginate();

        return $lists;
    }
}
