<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 relative">
                <movie-details-card :movie="movie" />

                <movie-menu
                    :movie="movie"
                    :liked="liked"
                    :watched="watched"
                    :lists="lists"
                    :review="myReview"
                />

                <movie-video :videos="movie.videos.results" />

                <description-card
                    title="Cast"
                    description="These are some of the cast members (in credits order)"
                >
                    <cast-showcase :cast="movie.credits.cast" :all="false" />
                </description-card>

                <div
                    v-if="friendsReviews.length > 0"
                    class="border-b border-gray-600 mt-5 mb-2 text-white flex px-1"
                >
                    <a
                        :href="route('movies.reviews.friends', movie.id)"
                        class="hover:text-indigo-400"
                        >Friends reviews</a
                    >
                </div>

                <review-card
                    v-for="review in friendsReviews"
                    :key="'friend' + review.id"
                    :review="review"
                />

                <div
                    v-if="popularReviews.length > 0"
                    class="border-b border-gray-600 mt-5 mb-2 text-white flex px-1"
                >
                    <a
                        :href="route('movies.reviews.popular', movie.id)"
                        class="hover:text-indigo-400"
                        >Popular reviews</a
                    >
                </div>

                <review-card
                    v-for="review in popularReviews"
                    :key="'popular' + review.id"
                    :review="review"
                />

                <div
                    v-if="recentReviews.length > 0"
                    class="border-b border-gray-600 mt-5 mb-2 text-white flex px-1"
                >
                    <a
                        :href="route('movies.reviews.index', movie.id)"
                        class="hover:text-indigo-400"
                        >Recent reviews</a
                    >
                </div>

                <review-card
                    v-for="review in recentReviews"
                    :key="'recent' + review.id"
                    :review="review"
                />
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import DescriptionCard from "@/Components/DescriptionCard";
import CastShowcase from "@/Components/CastShowcase";
import ReviewCard from "@/Components/ReviewCard";
import MovieMenu from "@/Components/MovieMenu";
import MovieDetailsCard from "@/Components/MovieDetailsCard";
import MovieVideo from "@/Components/MovieVideo";

export default {
    components: {
        AppLayout,
        DescriptionCard,
        CastShowcase,
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
        liked: Boolean,
        watched: Boolean,
        lists: Object,
    },
};
</script>
