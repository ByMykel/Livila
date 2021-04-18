<template>
    <div
        v-if="activity.type == 'watchMovie'"
        class="bg-gray-800 rounded-md shadow p-2 text-white mb-2"
    >
        {{ activity.user.username }} watched {{ activity.data.title }}
    </div>

    <div
        v-else-if="activity.type == 'likeMovie'"
        class="bg-gray-800 rounded-md shadow p-2 text-white mb-2"
    >
        {{ activity.user.username }} liked {{ activity.data.title }}
    </div>

    <div
        v-else-if="activity.type == 'likeReview'"
        class="bg-gray-800 rounded-md shadow p-2 text-white mb-2"
    >
        {{ activity.user.username }} liked
        {{ activity.data.user.username }} review of
        {{ activity.data.movie.title }}
    </div>

    <div
        v-else-if="activity.type == 'likeList'"
        class="bg-gray-800 rounded-md shadow p-2 text-white mb-2"
    >
        {{ activity.user.username }} liked
        {{ activity.data.user.username }} list of {{ activity.name }}
    </div>

    <div
        v-else-if="activity.type == 'createReview'"
        class="bg-gray-800 rounded-md shadow p-2 text-white mb-2"
    >
        {{ activity.user.username }} reviewed {{ activity.data.movie.title }}
    </div>

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
export default {
    props: {
        activity: Object,
    },
};
</script>