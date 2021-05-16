<template>
    <activity-card>
        <template #icon>
            <svg
                class="w-5 h-5 text-blue-500 mx-2"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    fill-rule="evenodd"
                    d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z"
                    clip-rule="evenodd"
                ></path>
            </svg>
        </template>

        <template #title>
            <span>
                <a
                    class="text-indigo-400 hover:text-indigo-500"
                    :href="route('user', activity.user.username)"
                    >{{ activity.user.username }}</a
                >
                reviewed
                <a
                    class="text-indigo-400 hover:text-indigo-500"
                    :href="route('movies.show', activity.data.movie.id)"
                    >{{ activity.data.movie.title }}</a
                >
            </span>
        </template>

        <template #date>
            <span :title="activity.created_at">{{ activity.created_at_human }}</span>
        </template>
    </activity-card>
</template>

<script>
import ActivityCard from "@/Components/Activity/ActivityCard";

export default {
    components: {
        ActivityCard,
    },

    props: {
        activity: Object,
    },
};
</script>