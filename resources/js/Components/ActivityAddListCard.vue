<template>
    <activity-card>
        <template #icon>
            <svg
                class="w-5 h-5 text-yellow-500 mx-2"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z"
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
                added
                <a
                    class="text-indigo-400 hover:text-indigo-500"
                    :href="route('movies.show', activity.data.movie.id)"
                    >{{ activity.data.movie.title }}</a
                >
                to
                <a
                    class="text-indigo-400 hover:text-indigo-500"
                    :href="route('lists.show', activity.data.id)"
                    >{{ activity.data.name }}</a
                >
            </span>
        </template>

        <template #date>
            {{ activity.created_at }}
        </template>

        <template #content>
            <div
                class="bg-black-400 rounded-md shadow p-2 text-white overflow-hidden flex"
            >
                <div class="hidden sm:flex flex-shrink-0 mr-2">
                    <a
                        class="flex"
                        :href="route('lists.show', activity.data.movie.id)"
                    >
                        <img
                            class="h-36 rounded-md shadow-md"
                            :src="poster(activity.data.movie)"
                        />
                    </a>
                </div>

                <div class="block">
                    <h2 class="break-all">{{ activity.data.name }}</h2>

                    <div>
                        <p
                            class="block text-sm text-gray-400 h-16 w-auto overflow-hidden trauncate break-all"
                        >
                            {{ activity.data.description }}
                        </p>
                    </div>
                </div>
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

    methods: {
        poster(movie) {
            if (movie.poster_path === "empty_poster_path.png") {
                return "/images/empty_poster_path.png";
            }

            if (movie.poster_path) {
                return "https://image.tmdb.org/t/p/w780" + movie.poster_path;
            }

            return "/images/default_poster_path.png";
        },
    },
};
</script>