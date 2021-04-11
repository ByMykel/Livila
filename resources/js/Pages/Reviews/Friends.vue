<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 relative">
                <movie-details-card
                    :movie="movie"
                    :review-page="true"
                    :show-backdrop="false"
                ></movie-details-card>

                <div
                    class="border-b border-gray-800 mt-5 p-1 flex justify-between mb-5 relative"
                >
                    <div class="text-gray-400">
                        <a
                            :href="route('movies.reviews.index', movie.id)"
                            class="hover:text-white mr-3"
                            :class="{
                                'text-indigo-400': route().current(
                                    'movies.reviews.index',
                                    movie.id
                                ),
                            }"
                            >Recent</a
                        >
                        <a
                            :href="route('movies.reviews.popular', movie.id)"
                            class="hover:text-white mr-3"
                            :class="{
                                'text-indigo-400': route().current(
                                    'movies.reviews.popular',
                                    movie.id
                                ),
                            }"
                            >Popular</a
                        >
                        <a
                            :href="route('movies.reviews.friends', movie.id)"
                            class="hover:text-white mr-3"
                            :class="{
                                'text-indigo-400': route().current(
                                    'movies.reviews.friends',
                                    movie.id
                                ),
                            }"
                            >Friends</a
                        >
                    </div>
                </div>

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
import ReviewCard from "@/Components/ReviewCard";
import BasePagination from "@/Components/BasePagination";
import MovieDetailsCard from "@/Components/MovieDetailsCard";

export default {
    components: {
        AppLayout,
        ReviewCard,
        BasePagination,
        MovieDetailsCard,
    },

    props: {
        movie: Object,
        reviews: Object,
        page: Object,
    },
};
</script>
