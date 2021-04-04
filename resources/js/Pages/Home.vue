<template>
    <app-layout>
        <div class="py-6 px-1">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mx-auto text-center text-white my-4">
                    <h1 v-if="followActiveMembers">
                        Welcome back, {{ $page.props.user.name }}. Here’s what
                        your friends have been watching…
                    </h1>
                    <div v-else>
                        <h1>
                            Welcome back, {{ $page.props.user.name }}. Here’s
                            what we’ve been watching…
                        </h1>
                        <h3 class="text-gray-300">
                            This homepage will become customized as you follow
                            active members.
                        </h3>
                    </div>
                </div>

                <description-card
                    title="Just reviewed movies"
                    description="These are the latest reviewed movies in Livila"
                >
                    <reviews-showcase :reviews="justReviewed" />
                </description-card>

                <description-card
                    title="Friends watched movies"
                    description="These are the latest movies watched by your friends"
                >
                    <movies-showcase :movies="friendsWatched" :all="false" />
                </description-card>

                <description-card
                    title="Friends reviews"
                    description="These are the latest reviewed movies by your friends"
                >
                    <review-card
                        v-for="review in friendsReviews"
                        :key="review.id"
                        :review="review"
                        :showTitle="true"
                    />
                </description-card>
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

export default {
    components: {
        AppLayout,
        ReviewCard,
        MoviesShowcase,
        ReviewsShowcase,
        DescriptionCard,
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
