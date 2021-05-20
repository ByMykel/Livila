<?php

namespace Database\Seeders;

use App\Models\ListMovie;
use App\Models\Review;
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
        $users = User::factory(10)->create();
        $movies = (new TmdbMoviesInformationApi)->getPopular()['results'];

        foreach ($users as $user) {
            foreach ($movies as $movie) {
                Review::factory()->create([
                    'user_id' => $user->id,
                    'movie_id' => $movie['id']
                ]);
            }
        }

        $user = User::factory()->create();

        $marvelList = ListMovie::factory()->create([
            'user_id' => $user->id,
            'name' => 'Marvel Cinematic Universe',
            'description' => 'The Marvel Cinematic Universe (MCU) is an American media franchise and shared universe centered on a series of superhero films, independently produced by Marvel Studios and based on characters that appear in American comic books published by Marvel Comics. The franchise includes comic books, short films, television series, and digital series. The shared universe, much like the original Marvel Universe in comic books, was established by crossing over common plot elements, settings, cast, and characters.'
        ]);

        $harryPotterlList = ListMovie::factory()->create([
            'user_id' => $user->id,
            'name' => 'Harry Potter (film series)',
            'description' => 'Harry Potter is a film series based on the eponymous novels by J. K. Rowling. The series is distributed by Warner Bros. and consists of eight fantasy films, beginning with Harry Potter and the Philosopher\'s Stone (2001) and culminating with Harry Potter and the Deathly Hallows – Part 2 (2011).'
        ]);

        $taxiList = ListMovie::factory()->create([
            'user_id' => $user->id,
            'name' => 'Taxi (film series)',
            'description' => 'Taxi is a series of comedy films, created by French screenwriter and producer Luc Besson, consisting of 5 films. In addition to them, an American-French remake of the 1998 original was also made in 2004 (Taxi) and in 2014 an American-French TV series called Taxi Brooklyn aired on television.'
        ]);

        $starWarsList = ListMovie::factory()->create([
            'user_id' => $user->id,
            'name' => 'Star Wars',
            'description' => 'Star Wars is an American epic space opera media franchise created by George Lucas, which began with the eponymous 1977 film and quickly became a worldwide pop-culture phenomenon.'
        ]);

        $marvelMovies = [1726, 1724, 10138, 10195, 1771, 24428, 68721, 76338, 100402, 118340, 99861, 102899, 271110, 284052, 283995, 315635, 284053, 284054, 299536, 363088, 299537, 299534, 429617];
        $harryPotterMovies = [671, 672, 673, 674, 675, 767, 12444, 12445];
        $taxiMovies = [2330, 2332, 2334, 2335];
        $starWarsMovies = [11, 1891, 1892, 1893, 1894, 1895, 140607, 181808, 181812, 330459, 348350, 760798];

        foreach ($marvelMovies as $movie) {
            DB::table('lists_movies')->insert(
                [
                    'list_id' => $marvelList->id,
                    'movie_id' => $movie,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }

        foreach ($harryPotterMovies as $movie) {
            DB::table('lists_movies')->insert(
                [
                    'list_id' => $harryPotterlList->id,
                    'movie_id' => $movie,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }

        foreach ($taxiMovies as $movie) {
            DB::table('lists_movies')->insert(
                [
                    'list_id' => $taxiList->id,
                    'movie_id' => $movie,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }

        foreach ($starWarsMovies as $movie) {
            DB::table('lists_movies')->insert(
                [
                    'list_id' => $starWarsList->id,
                    'movie_id' => $movie,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }
}
