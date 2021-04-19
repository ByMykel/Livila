<template>
    <div class="bg-gray-900 rounded-md shadow p-2 text-white mb-2">
        <div
            class="flex items-center justify-between bg-gray-800 rounded-md p-1 mb-2"
        >
            <div class="flex items-center text-sm sm:text-base">
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

                <span>
                    <a
                        class="text-indigo-400 hover:text-indigo-500"
                        :href="route('user', activity.user.username)"
                        >{{ activity.user.username }}</a
                    >
                    liked
                    <a
                        class="text-indigo-400 hover:text-indigo-500"
                        :href="route('movies.show', activity.data.id)"
                        >{{ activity.data.title }}</a
                    >
                </span>
            </div>

            <div class="hidden sm:block text-xs text-gray-400 mr-2">
                {{ activity.created_at }}
            </div>
        </div>

        <div class="flex">
            <img class="h-36 shadow rounded" :src="poster" />
            <p class="px-2">
                {{ activity.data.overview }}
            </p>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        activity: Object,
    },

    computed: {
        poster() {
            if (this.activity.data.poster_path) {
                return (
                    "https://image.tmdb.org/t/p/w780" +
                    this.activity.data.poster_path
                );
            }

            return "/images/default_poster_path.png";
        },
    },
};
</script>