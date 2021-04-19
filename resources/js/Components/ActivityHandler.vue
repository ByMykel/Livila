<template>
    <activity-watch-movie-card
        v-if="activity.type == 'watchMovie'"
        :activity="activity"
    ></activity-watch-movie-card>

    <activity-like-movie-card
        v-else-if="activity.type == 'likeMovie'"
        :activity="activity"
    ></activity-like-movie-card>

    <activity-like-review-card
        v-else-if="activity.type == 'likeReview'"
        :activity="activity"
    ></activity-like-review-card>

    <div
        v-else-if="activity.type == 'likeList'"
        class="bg-gray-800 rounded-md shadow p-2 text-white mb-2"
    >
        {{ activity.user.username }} liked
        {{ activity.data.user.username }} list of {{ activity.name }}
    </div>

    <activity-create-review-card
        v-else-if="activity.type == 'createReview'"
        :activity="activity"
    ></activity-create-review-card>

    <div
        v-else-if="activity.type == 'commentReview'"
        class="bg-gray-800 rounded-md shadow p-2 text-white mb-2"
    >
        {{ activity.user.username }} commented on
        {{ activity.data.user.username }}'s review
    </div>

    <div
        v-else-if="activity.type == 'followUser'"
        class="bg-gray-800 rounded-md shadow p-2 text-white mb-2"
    >
        {{ activity.user.username }} followed {{ activity.data.username }}
    </div>

    <div
        v-else-if="activity.type == 'createList'"
        class="bg-gray-800 rounded-md shadow p-2 text-white mb-2"
    >
        {{ activity.user.username }} created a new list {{ activity.data.name }}
    </div>

    <div
        v-else-if="activity.type == 'addList'"
        class="bg-gray-800 rounded-md shadow p-2 text-white mb-2"
    >
        {{ activity.user.username }} added {{ activity.data.movie.title }} to
        {{ activity.data.name }}
    </div>
</template>

<script>
import ActivityWatchMovieCard from "@/Components/ActivityWatchMovieCard";
import ActivityLikeMovieCard from "@/Components/ActivityLikeMovieCard";
import ActivityLikeReviewCard from "@/Components/ActivityLikeReviewCard";

import ActivityCreateReviewCard from "@/Components/ActivityCreateReviewCard";

export default {
    components: {
        ActivityWatchMovieCard,
        ActivityLikeMovieCard,
        ActivityLikeReviewCard,

        ActivityCreateReviewCard,
    },

    props: {
        activity: Object,
    },
};
</script>