<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 relative">
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
                    v-show="showReviewsNavbar"
                    class="border-b border-black-300 mt-5 mb-5 text-black-100 flex justify-between px-1"
                >
                    <div class="flex">
                        <a
                            v-if="recentReviews.length"
                            class="hover:border-b hover:text-white px-3 border-black-100 cursor-pointer"
                            :class="{
                                'text-white border-indigo-600 border-b':
                                    selected === 1,
                            }"
                            @click="selected = 1"
                            >Recent</a
                        >
                        <a
                            v-if="popularReviews.length"
                            class="hover:border-b hover:text-white px-3 border-black-100 cursor-pointer"
                            :class="{
                                'text-white border-indigo-600 border-b':
                                    selected === 2,
                            }"
                            @click="selected = 2"
                            >Popular</a
                        >
                        <a
                            v-if="friendsReviews.length"
                            class="hover:border-b hover:text-white px-3 border-black-100 cursor-pointer"
                            :class="{
                                'text-white border-indigo-600 border-b':
                                    selected === 3,
                            }"
                            @click="selected = 3"
                            >Friends</a
                        >
                    </div>
                    <div class="flex items-center">
                        <a :href="route('movies.reviews.index', movie.id)">
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

                <div v-if="selected === 1">
                    <review-card
                        v-for="review in recentReviews"
                        :key="'recent' + review.id"
                        :review="review"
                    />
                </div>

                <div v-if="selected === 2">
                    <review-card
                        v-for="review in popularReviews"
                        :key="'popular' + review.id"
                        :review="review"
                    />
                </div>

                <div v-if="selected === 3">
                    <review-card
                        v-for="review in friendsReviews"
                        :key="'friend' + review.id"
                        :review="review"
                    />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import ReviewCard from "@/Components/ReviewCard";
import MovieMenu from "@/Components/MovieMenu";
import MovieDetailsCard from "@/Components/MovieDetailsCard";
import MovieVideo from "@/Components/MovieVideo";

export default {
    components: {
        AppLayout,
        ReviewCard,
        MovieMenu,
        MovieDetailsCard,
        MovieVideo,
    },

    props: {
        movie: Object,
        myReview: Object,
        friendsReviews: Object,
        popularReviews: Object,
        recentReviews: Object,
        lists: Object,
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

        // Check if there is at least one list.
        // showListsNavbar() {
        //     return (
        //         this.friendsReviews.length ||
        //         this.popularReviews.length ||
        //         this.recentReviews.length
        //     );
        // },
    },
};
</script>
