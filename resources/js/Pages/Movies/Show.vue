<template>
    <app-layout>
        <div class="px-1 py-6">
            <div class="relative max-w-6xl mx-auto sm:px-6 lg:px-8">
                <movie-details-card :movie="movie" />

                <movie-menu
                    v-show="$page.props.auth"
                    :movie="movie"
                    :liked="movie.liked"
                    :watched="movie.watched"
                    :lists="lists"
                    :review="myReview"
                />

                <movie-video :videos="movie.videos.results" />

                <div
                    v-if="movie.credits.cast.length"
                    class="flex justify-between px-1 mt-10 mb-2 text-base font-semibold text-black-100"
                >
                    <span>Cast</span>

                    <div class="flex items-center">
                        <a :href="route('cast.index', movie.id)">
                            <svg
                                class="w-4 h-4 mx-3 text-white hover:text-indigo-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
                                ></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <cast-showcase
                    v-if="movie.credits.cast.length"
                    :castMembers="movie.credits.cast.slice(0, 8)"
                ></cast-showcase>

                <div
                    v-if="showReviewsNavbar"
                    class="flex justify-between px-1 mt-10 mb-2 text-base font-semibold text-black-100"
                >
                    <div class="flex">
                        <a
                            v-if="recentReviews.length"
                            class="px-3 cursor-pointer hover:border-b-2 hover:text-white border-black-100"
                            :class="{
                                'text-white border-indigo-600 border-b-2':
                                    selected === 1,
                            }"
                            @click="selected = 1"
                            >Recent</a
                        >
                        <a
                            v-if="popularReviews.length"
                            class="px-3 cursor-pointer hover:border-b-2 hover:text-white border-black-100"
                            :class="{
                                'text-white border-indigo-600 border-b-2':
                                    selected === 2,
                            }"
                            @click="selected = 2"
                            >Popular</a
                        >
                        <a
                            v-if="friendsReviews.length"
                            class="px-3 cursor-pointer hover:border-b-2 hover:text-white border-black-100"
                            :class="{
                                'text-white border-indigo-600 border-b-2':
                                    selected === 3,
                            }"
                            @click="selected = 3"
                            >Friends</a
                        >
                    </div>
                    <div class="flex items-center">
                        <a :href="route(routeToReviews, movie.id)">
                            <svg
                                class="w-4 h-4 mx-3 text-white hover:text-indigo-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
                                ></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <div v-if="selected === 1 && recentReviews.length">
                    <review-card
                        v-for="review in recentReviews"
                        :key="'recent' + review.id"
                        :review="review"
                    />
                </div>

                <div v-if="selected === 2 && popularReviews.length">
                    <review-card
                        v-for="review in popularReviews"
                        :key="'popular' + review.id"
                        :review="review"
                    />
                </div>

                <div
                    v-if="
                        $page.props.auth &&
                        selected === 3 &&
                        friendsReviews.length
                    "
                >
                    <review-card
                        v-for="review in friendsReviews"
                        :key="'friend' + review.id"
                        :review="review"
                    />
                </div>

                <div
                    v-if="similarMovies.length"
                    class="px-1 mt-10 mb-2 text-base font-semibold text-black-100"
                >
                    Similar movies
                </div>

                <movies-showcase
                    v-if="similarMovies.length"
                    :movies="similarMovies"
                ></movies-showcase>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import ReviewCard from "@/Components/Reviews/ReviewCard";
import MovieMenu from "@/Components/Movies/MovieMenu";
import MovieDetailsCard from "@/Components/Movies/MovieDetailsCard";
import MovieVideo from "@/Components/Movies/MovieVideo";
import MoviesShowcase from "@/Components/Movies/MoviesShowcase";
import CastShowcase from "@/Components/Cast/CastShowcase";

export default {
    components: {
        AppLayout,
        ReviewCard,
        MovieMenu,
        MovieDetailsCard,
        MovieVideo,
        MoviesShowcase,
        CastShowcase,
    },

    props: {
        title: String,
        movie: Object,
        myReview: Object,
        friendsReviews: Object,
        popularReviews: Object,
        recentReviews: Object,
        lists: Object,
        similarMovies: Object,
    },

    data() {
        return {
            selected: 1,
        };
    },

    computed: {
        showReviewsNavbar() {
            return (
                this.friendsReviews.length ||
                this.popularReviews.length ||
                this.recentReviews.length
            );
        },

        routeToReviews() {
            return {
                1 : 'movies.reviews.index',
                2 : 'movies.reviews.popular',
                3 : 'movies.reviews.friends'
            }[this.selected]
        }
    },

    mounted() {
        document.title = `${this.movie.title} - Livila`;
    },
};
</script>
