<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <movie-details-card
                    :movie="review[0].movie"
                    :review-page="true"
                ></movie-details-card>

                <review-card class="mt-8" :review="review[0]"></review-card>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import ReviewCard from "@/Components/ReviewCard";
import MovieDetailsCard from "@/Components/MovieDetailsCard";

export default {
    components: {
        AppLayout,
        ReviewCard,
        MovieDetailsCard,
    },

    props: {
        review: Object,
    },
};
</script>
