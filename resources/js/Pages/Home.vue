<template>
    <app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mx-auto text-center text-white my-4">
                    <h1 v-if="followActiveMembers">Welcome back, {{ $page.props.user.name }}. Here’s what your friends have been watching…</h1>
                    <div v-else>
                        <h1>Welcome back, {{ $page.props.user.name }}. Here’s what we’ve been watching…</h1>
                        <h3 class="text-gray-300">This homepage will become customized as you follow active members.</h3>
                    </div>
                </div>

                <div class="my-2">
                    <div class="text-white mb-1 flex justify-between">
                        <p>Just reviewed movies</p>
                        <p>View more</p>
                    </div>
                    <reviews-showcase :reviews="justReviewed" />
                </div>

                <div class="my-2">
                    <div class="text-white mb-1 flex justify-between">
                        <p>Friends watched movies</p>
                        <p>View more</p>
                    </div>
                    <movies-showcase :movies="friendsWatched" />
                </div>

                <div class="my-2">
                    <div class="text-white mb-1 flex justify-between">
                        <p>Friends reviews</p>
                        <p>View more</p>
                    </div>
                    <div>
                        <review-card v-for="review in friendsReviews" :key="review.id" :review="review" />
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import ReviewCard from "@/Components/ReviewCard";
import MoviesShowcase from "@/Components/MoviesShowcase";
import ReviewsShowcase from "@/Components/ReviewsShowcase";

export default {
    components: {
        AppLayout,
        ReviewCard,
        MoviesShowcase,
        ReviewsShowcase
    },

    props: {
        followActiveMembers: Boolean,
        justReviewed: Object,
        friendsReviews: Object,
        friendsWatched: Object
    },

    methods: {
    },
};
</script>
