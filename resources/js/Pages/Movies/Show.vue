<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 relative">
                <movie-details-card :movie="movie" />

                <movie-menu :movie="movie" />

                <movie-video :videos="movie.videos.results" />

                <description-card
                    title="Cast"
                    description="These are some of the cast members (in credits order)"
                >
                    <cast-showcase :cast="movie.credits.cast" :all="false" />
                </description-card>

                <review-form :movie="movie" :review="myReview" />

                <description-card
                    title="Friends reviews"
                    description="These are some of your friends reviewes"
                >
                    <review-card
                        v-for="review in friendsReviews"
                        :key="'friend' + review.id"
                        :review="review"
                    />
                </description-card>

                <description-card
                    title="Popular reviews"
                    description="These are some of the most liked reviews"
                >
                    <review-card
                        v-for="review in popularReviews"
                        :key="'popular' + review.id"
                        :review="review"
                    />
                </description-card>

                <description-card
                    title="Recent reviews"
                    description="These are some of the latest reviews"
                >
                    <review-card
                        v-for="review in recentReviews"
                        :key="'recent' + review.id"
                        :review="review"
                    />
                </description-card>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import DescriptionCard from "@/Components/DescriptionCard";
import CastShowcase from "@/Components/CastShowcase";
import ReviewForm from "@/Components/ReviewForm";
import ReviewCard from "@/Components/ReviewCard";
import MovieMenu from "@/Components/MovieMenu";
import MovieDetailsCard from "@/Components/MovieDetailsCard";
import MovieVideo from "@/Components/MovieVideo";

export default {
    components: {
        AppLayout,
        DescriptionCard,
        CastShowcase,
        ReviewForm,
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
    },
};
</script>
