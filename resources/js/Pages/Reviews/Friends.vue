<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 relative">
                <movie-details-card
                    :movie="movie"
                    :review-page="true"
                    :show-backdrop="false"
                    hideBackdrop
                ></movie-details-card>

                <reviews-navbar :movie="movie"></reviews-navbar>

                <review-card
                    v-for="review in reviews"
                    :key="review.id"
                    :review="review"
                />

                <base-pagination :page="page"></base-pagination>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import ReviewCard from "@/Components/Reviews/ReviewCard";
import BasePagination from "@/Components/BasePagination";
import MovieDetailsCard from "@/Components/Movies/MovieDetailsCard";
import ReviewsNavbar from "@/Components/Reviews/ReviewsNavbar";

export default {
    components: {
        AppLayout,
        ReviewCard,
        BasePagination,
        MovieDetailsCard,
        ReviewsNavbar,
    },

    props: {
        movie: Object,
        reviews: Object,
        page: Object,
    },
};
</script>
