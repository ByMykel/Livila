<?php

namespace Database\Seeders;

use App\Models\User;
use App\Services\TMDB\TmdbMoviesInformationApi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\User::factory(10)->create();
        $movies = (new TmdbMoviesInformationApi)->getPopular()['results'];

        foreach ($users as $user) {
            foreach ($movies as $movie) {
                \App\Models\Review::factory()->create([
                    'user_id' => $user->id,
                    'movie_id' => $movie['id']
                ]);
            }
        }
    }
}
