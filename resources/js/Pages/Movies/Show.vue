<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="lg:flex">
                    <div class="md:flex flex-1">
                        <div class="md:mr-2 flex-initial">
                            <img
                                class="shadow rounded-md mx-auto"
                                :src="poster"
                                alt=""
                            />
                        </div>

                        <div class="flex flex-col lg:flex-row flex-1">
                            <div class="w-full p-1">
                                <p
                                    class="text-center md:text-left mt-1 text-3xl leading-8 font-extrabold tracking-tight text-indigo-500"
                                >
                                    {{ movie.title }}
                                </p>

                                <p class="mt-3 text-md text-white">
                                    {{ movie.overview }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-gray-800 rounded-md shadow w-full lg:w-60 text-white p-4 flex-initial mt-4 lg:mt-0"
                    >
                        <div>
                            <div class="flex lg:flex-col justify-around mb-2">
                                <div class="flex items-center">
                                    <span>
                                        <svg
                                            class="w-5 h-5 text-indigo-400"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                clip-rule="evenodd"
                                            ></path>
                                        </svg>
                                    </span>
                                    <div class="ml-1">
                                        {{ movie.release_date }}
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <span>
                                        <svg
                                            class="w-5 h-5 text-indigo-400"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                clip-rule="evenodd"
                                            ></path>
                                        </svg>
                                    </span>
                                    <div class="ml-1">
                                        {{ movie.runtime }} m
                                    </div>
                                </div>

                                <div class="flex items-center">
                                    <span>
                                        <svg
                                            class="w-5 h-5 text-indigo-400"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"
                                            ></path>
                                        </svg>
                                    </span>
                                    <div class="ml-1">
                                        {{ movie.vote_average }} / 10
                                    </div>
                                </div>
                            </div>

                            <p>Genres</p>
                            <div class="">
                                <span
                                    class="inline-block text-xs rounded-full border border-gray-400 text-white py-0.5 px-2 mr-1"
                                    v-for="genre in movie.genres"
                                    :key="genre.id"
                                >
                                    {{ genre.name }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <description-card
                    title="Friends watched movies"
                    description="These are the latest movies watched by your friends"
                >
                    <cast-showcase :cast="movie.credits.cast" :all="false" />
                </description-card>

                <review-form :movie="movie" :review="myReview" />
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import DescriptionCard from "@/Components/DescriptionCard";
import CastShowcase from "@/Components/CastShowcase";
import ReviewForm from "@/Components/ReviewForm";

export default {
    components: {
        AppLayout,
        DescriptionCard,
        CastShowcase,
        ReviewForm,
    },

    props: {
        movie: Object,
        myReview: Object,
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
    },

    methods: {},
};
</script>
