<template>
    <activity-card>
        <template #icon>
            <svg
                class="w-5 h-5 text-green-500 mx-2"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                <path
                    fill-rule="evenodd"
                    d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
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
                watched
                <a
                    class="text-indigo-400 hover:text-indigo-500"
                    :href="route('movies.show', activity.data.id)"
                    >{{ activity.data.title }}</a
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