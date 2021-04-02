<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="md:flex">
                    <div class="mr-2">
                        <img
                            class="shadow rounded-md mx-auto"
                            :src="poster"
                            alt=""
                        />
                    </div>

                    <div class="w-full p-1">
                        <p
                            class="text-center md:text-left mt-1 text-3xl leading-8 font-extrabold tracking-tight text-indigo-500 sm:text-3xl"
                        >
                            {{ movie.title }}
                        </p>

                        <p class="text-indigo-200">
                            {{ new Date(movie.release_date).getFullYear() }} ·
                            {{ movie.runtime }}m ·
                            <a :href="imdbLink">IMDB</a>
                            · {{ movie.vote_average }} / 10
                        </p>

                        <p class="mt-3 text-md text-white">
                            {{ movie.overview }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";

export default {
    components: {
        AppLayout,
    },

    props: {
        movie: Object,
    },

    computed: {
        poster() {
            if (this.movie.poster_path) {
                return (
                    "https://image.tmdb.org/t/p/w300" + this.movie.poster_path
                );
            }

            return "/images/default_poster_path.png";
        },

        imdbLink() {
            return "https://www.imdb.com/title/" + this.movie.imdb_id;
        },
    },
};
</script>
