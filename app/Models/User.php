<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function listsMovies()
    {
        return $this->hasMany(ListMovie::class)->latest();
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'followed_id', 'follower_id');
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'followed_id')->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->latest();
    }

    public function watched()
    {
        return $this->hasMany(Movie::class, 'user_id', 'id');
    }

    public function getUser(User $user)
    {
        $result = User::where('id', $user->id)
            ->withcount(['followers as follow' => function ($q) {
                return $q->where('follower_id', Auth::id());
            }])
            ->withcount(['followers', 'following', 'listsMovies', 'reviews', 'watched'])
            ->get()[0];

        return $result;
    }

    public function isFollowing(User $user)
    {
        return Auth::user()->following()->find($user);
    }

    public function followUser(User $user)
    {
        Auth::user()->following()->attach($user);
    }

    public function unFollowUser(User $user)
    {
        Auth::user()->following()->detach($user);
    }

    public function handleFollow(User $user)
    {
        $isFollowing = $this->isFollowing($user);

        if ($isFollowing) {
            $this->unFollowUser($user);
            return;
        }

        $this->followUser($user);
    }

    public function getUserByName($query)
    {
        $users = User::query()
            ->where('username', 'like', '%' . $query . '%')
            ->withcount(['followers as follow' => function ($q) {
                return $q->where('follower_id', Auth::id());
            }])
            ->withCount('followers')
            ->distinct()
            ->paginate();

        return $users;
    }
}
