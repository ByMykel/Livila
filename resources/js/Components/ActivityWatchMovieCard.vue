<template>
    <div class="bg-gray-900 rounded-md shadow p-2 text-white mb-2">
        <div class="flex items-center justify-between bg-gray-800 rounded-md p-1 mb-2">
            <div class="flex items-center text-sm sm:text-base">
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
                    "https://image.tmdb.org/t/p/w500" +
                    this.activity.data.poster_path
                );
            }

            return "/images/default_poster_path.png";
        },
    },
};
</script>