<template>
    <activity-card>
        <template #icon>
            <svg
                class="w-5 h-5 text-red-500 mx-2"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    fill-rule="evenodd"
                    d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
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
                liked
                <a
                    class="text-indigo-400 hover:text-indigo-500"
                    :href="route('user', activity.data.user.username)"
                    >{{ activity.data.user.username }}</a
                >
                list of
                <a
                    class="text-indigo-400 hover:text-indigo-500"
                    :href="route('lists.show', activity.data.id)"
                    >{{ activity.data.name }}</a
                >
            </span>
        </template>

        <template #date>
            <span :title="activity.created_at">{{ activity.created_at_human }}</span>
        </template>
    </activity-card>
</template>

<script>
import ActivityCard from "@/Components/ActivityCard";

export default {
    components: {
        ActivityCard,
    },

    props: {
        activity: Object,
    },
};
</script>