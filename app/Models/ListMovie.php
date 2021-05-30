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

    public function movies()
    {
        return $this->belongsToMany(ListMovie::class, 'lists_movies', 'list_id', 'list_id');
    }

    public function isListed($listId, $movieId)
    {
        return DB::table('lists_movies')->where('list_id', $listId)->where('movie_id', $movieId)->count() === 1;
    }

    public function getRecentLists()
    {
        $lists = ListMovie::where('visibility', 1)
            ->with('user')
            ->withCount('likes')
            ->latest()
            ->paginate();

        return $lists;
    }

    public function getPopularLists()
    {
        $lists = ListMovie::where('visibility', 1)
            ->with('user')
            ->withCount('likes')
            ->orderByDesc('likes_count')
            ->paginate();

        return $lists;
    }

    public function getFriendsLists()
    {
        if (!Auth::user()) {
            return [];
        }

        $user = Auth::user();

        $lists = ListMovie::whereHas('user', function ($query) use ($user) {
            $query->whereHas('followers', function ($q) use ($user) {
                $q->where('follower_id', $user->id);
            });
        })
            ->where('visibility', 1)
            ->withCount('likes')
            ->with('user')
            ->paginate();

        return $lists;
    }

    public function getUserLists(User $user)
    {
        $visibility = Auth::id() === $user->id ? [1, 0] : [1];

        $lists = ListMovie::where('user_id', $user->id)
            ->whereIn('visibility', $visibility)
            ->with('user')
            ->withCount('likes')
            ->orderByDesc('updated_at')
            ->paginate(15);

        return $lists;
    }

    public function getMyLists()
    {
        if (!Auth::user()) {
            return [];
        }

        $lists = ListMovie::where('user_id', Auth::user()->id)
            ->latest()
            ->get();

        return $lists;
    }

    public function getNumberOfMoviesInAList($list)
    {
        $number = ListMovie::find($list->id)->movies()->count();

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
            ->where('visibility', 1)
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

    public function createListMovie($name, $description, $visibility)
    {
        return Auth::user()->listsMovies()->create([
            'name' => $name,
            'description' => $description,
            'visibility' => $visibility
        ]);
    }

    public function updateListMovie(ListMovie $listMovie, $name, $description, $visibility, $removedMovies)
    {
        $listMovie->update([
            'name' => $name,
            'description' => $description,
            'visibility' => $visibility
        ]);

        // Remove movies from list.
        DB::table('lists_movies')
            ->where('list_id', $listMovie->id)
            ->whereIn('movie_id', $removedMovies)
            ->delete();
    }

    public function isLiked(ListMovie $listMovie)
    {
        return DB::table('likes_lists')->where('user_id', Auth::id())->where('list_id', $listMovie->id)->count() === 1;
    }

    public function markAsLiked(ListMovie $listMovie)
    {
        DB::table('likes_lists')->insert([
            'user_id' => Auth::user()->id,
            'list_id' => $listMovie->id,
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
    }

    public function unmarkAsLiked(ListMovie $listMovie)
    {
        DB::table('likes_lists')->where('user_id', Auth::id())->where('list_id', $listMovie->id)->delete();
    }

    public function handleLike(ListMovie $listMovie)
    {
        $isLiked = $this->isLiked($listMovie);

        if ($isLiked) {
            $this->unmarkAsLiked($listMovie);
            return;
        }

        $this->markAsLiked($listMovie);
    }



    public function markAsListed(ListMovie $listMovie, $id)
    {
        DB::table('lists_movies')->insert([
            'list_id' => $listMovie->id,
            'movie_id' => $id,
            'created_at' => NOW(),
            'updated_at' => NOW(),
        ]);
    }

    public function unmarkAsListed(ListMovie $listMovie, $movieId)
    {
        DB::table('lists_movies')->where('list_id', $listMovie->id)->where('movie_id', $movieId)->delete();
    }

    public function handleListed(ListMovie $listMovie, $movieId)
    {
        $isListed = $this->isListed($listMovie->id, $movieId);

        if ($isListed) {
            $this->unmarkAsListed($listMovie, $movieId);
            return;
        }

        $this->markAsListed($listMovie, $movieId);
    }

    public function getAllMoviesInAList(ListMovie $listMovie)
    {
        return DB::table('lists_movies')->where('list_id', $listMovie->id)->get()->pluck('movie_id');
    }
}
