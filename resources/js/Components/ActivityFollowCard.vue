<template>
    <activity-card>
        <template #icon>
            <svg
                class="w-5 h-5 text-indigo-500 mx-2"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    fill-rule="evenodd"
                    d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
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
                followed
                <a
                    class="text-indigo-400 hover:text-indigo-500"
                    :href="route('user', activity.data.username)"
                    >{{ activity.data.username }}</a
                >
            </span>
        </template>

        <template #date>
            {{ activity.created_at }}
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