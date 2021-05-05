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
            {{ activity.created_at }}
        </template>

        <template #content>
            <div
                class="bg-gray-800 rounded-md shadow p-3 text-white overflow-hidden relative"
            >
                <div
                    class="py-1 px-2 rounded-bl-md absolute top-0 right-0 text-xs font-medium"
                    :class="
                        activity.data.recommended
                            ? 'bg-green-500'
                            : 'bg-red-500'
                    "
                >
                    <span class="hidden sm:block">{{ isRecommended }}</span>

                    <span class="block sm:hidden">
                        <span v-if="!activity.data.recommended">
                            <svg
                                class="w-4 h-4"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M18 9.5a1.5 1.5 0 11-3 0v-6a1.5 1.5 0 013 0v6zM14 9.667v-5.43a2 2 0 00-1.105-1.79l-.05-.025A4 4 0 0011.055 2H5.64a2 2 0 00-1.962 1.608l-1.2 6A2 2 0 004.44 12H8v4a2 2 0 002 2 1 1 0 001-1v-.667a4 4 0 01.8-2.4l1.4-1.866a4 4 0 00.8-2.4z"
                                ></path>
                            </svg>
                        </span>

                        <span v-else>
                            <svg
                                class="w-4 h-4"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"
                                ></path>
                            </svg>
                        </span>
                    </span>
                </div>

                <div class="flex items-center">
                    <img class="w-8 sm:w-10 rounded-md" :src="poster" />

                    <div class="ml-2 text-sm">
                        <p>
                            <a
                                class="hover:text-indigo-400"
                                :href="
                                    route('movies.show', activity.data.movie.id)
                                "
                                >Reviewed by
                            </a>
                            <span class="font-medium">{{
                                activity.user.username
                            }}</span>
                        </p>

                        <p class="text-xs text-gray-500">
                            {{ activity.data.updated_at }}
                        </p>
                    </div>
                </div>

                <div class="my-2 text-sm text-gray-300 break-words">
                    {{ activity.data.review }}
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

    computed: {
        isRecommended() {
            return this.activity.data.recommended
                ? "Recommended"
                : "Not Recommended";
        },

        poster() {
            if (this.activity.data.movie.poster_path) {
                return (
                    "https://image.tmdb.org/t/p/w780" +
                    this.activity.data.movie.poster_path
                );
            }

            return "/images/default_poster_path.png";
        },
    },
};
</script>