<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <welcome-card></welcome-card>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import ReviewCard from "@/Components/ReviewCard";
import MoviesShowcase from "@/Components/MoviesShowcase";
import ReviewsShowcase from "@/Components/ReviewsShowcase";
import DescriptionCard from "@/Components/DescriptionCard";
import WelcomeCard from "@/Components/WelcomeCard";

export default {
    components: {
        AppLayout,
        ReviewCard,
        MoviesShowcase,
        ReviewsShowcase,
        DescriptionCard,
        WelcomeCard,
    },

    props: {
        followActiveMembers: Boolean,
        justReviewed: Object,
        friendsReviews: Object,
        friendsWatched: Object,
    },

    methods: {},
};
</script>
