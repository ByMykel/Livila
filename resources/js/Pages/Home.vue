<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <welcome-card v-if="!$page.props.auth"></welcome-card>
                <div v-else>
                    <div
                        v-if="recommendedMovies.length"
                        class="border-b border-black-300 mt-10 mb-5 text-black-100 px-1"
                    >
                        Recommended movies for you
                    </div>

                    <movies-showcase
                        v-if="recommendedMovies.length"
                        :movies="recommendedMovies"
                    ></movies-showcase>

                    <div
                        v-if="justReviewed.length"
                        class="border-b border-black-300 mt-10 mb-5 text-black-100 px-1"
                    >
                        Just Reviewed
                    </div>

                    <movies-showcase
                        v-if="justReviewed.length"
                        :movies="justReviewed"
                    ></movies-showcase>

                    <div
                        v-if="trendingMovies.length"
                        class="border-b border-black-300 mt-10 mb-5 text-black-100 px-1"
                    >
                        Trending movies today
                    </div>

                    <movies-showcase
                        v-if="trendingMovies.length"
                        :movies="trendingMovies"
                    ></movies-showcase>

                    <div
                        v-if="upcomingMovies.length"
                        class="border-b border-black-300 mt-10 mb-5 text-black-100 px-1"
                    >
                        Upcoming movies in theatres
                    </div>

                    <movies-showcase
                        v-if="upcomingMovies.length"
                        :movies="upcomingMovies"
                    ></movies-showcase>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import WelcomeCard from "@/Components/WelcomeCard";
import MoviesShowcase from "@/Components/Movies/MoviesShowcase";

export default {
    components: {
        AppLayout,
        WelcomeCard,
        MoviesShowcase,
    },

    props: {
        recommendedMovies: Object,
        trendingMovies: Object,
        upcomingMovies: Object,
        justReviewed: Object,
    },
};
</script>
