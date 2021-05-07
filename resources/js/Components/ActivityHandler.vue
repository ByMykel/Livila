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

    <activity-like-list-card
        v-else-if="activity.type == 'likeList'"
        :activity="activity"
    ></activity-like-list-card>

    <activity-create-review-card
        v-else-if="activity.type == 'createReview'"
        :activity="activity"
    ></activity-create-review-card>

    <activity-follow-card
        v-else-if="activity.type == 'followUser'"
        :activity="activity"
    ></activity-follow-card>

    <activity-create-list-card
        v-else-if="activity.type == 'createList'"
        :activity="activity"
    ></activity-create-list-card>

    <activity-add-list-card
        v-else-if="activity.type == 'addList'"
        :activity="activity"
    ></activity-add-list-card>
</template>

<script>
import ActivityWatchMovieCard from "@/Components/ActivityWatchMovieCard";
import ActivityLikeMovieCard from "@/Components/ActivityLikeMovieCard";
import ActivityLikeReviewCard from "@/Components/ActivityLikeReviewCard";
import ActivityFollowCard from "@/Components/ActivityFollowCard";
import ActivityLikeListCard from "@/Components/ActivityLikeListCard";
import ActivityCreateReviewCard from "@/Components/ActivityCreateReviewCard";
import ActivityCreateListCard from "@/Components/ActivityCreateListCard";
import ActivityAddListCard from "@/Components/ActivityAddListCard";

export default {
    components: {
        ActivityWatchMovieCard,
        ActivityLikeMovieCard,
        ActivityLikeReviewCard,
        ActivityLikeListCard,
        ActivityFollowCard,
        ActivityCreateReviewCard,
        ActivityCreateListCard,
        ActivityAddListCard,
    },

    props: {
        activity: Object,
    },
};
</script>