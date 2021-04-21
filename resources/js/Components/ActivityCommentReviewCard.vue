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
                    d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"
                ></path>
                <path
                    d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z"
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
                commented on
                <a
                    class="text-indigo-400 hover:text-indigo-500"
                    :href="route('user', activity.data.user.username)"
                    >{{ activity.data.user.username }}'s</a
                >
                review of
                <a
                    class="text-indigo-400 hover:text-indigo-500"
                    :href="
                        route('movies.reviews.show', [
                            activity.data.movie.id,
                            activity.data.review.id,
                        ])
                    "
                    >{{ activity.data.movie.title }}</a
                >
            </span>
        </template>

        <template #date>
            {{ activity.created_at }}
        </template>

        <template #content>
            <div class="flex p-2 bg-gray-800 rounded-md">
                <img class="h-36 shadow rounded mr-2" :src="poster" />
                <p>{{ activity.data.comment }}</p>
            </div>
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

    computed: {
        poster() {
            if (this.activity.data.movie.poster_path) {
                return (
                    "https://image.tmdb.org/t/p/w500" +
                    this.activity.data.movie.poster_path
                );
            }

            return "/images/default_poster_path.png";
        },
    },
};
</script>