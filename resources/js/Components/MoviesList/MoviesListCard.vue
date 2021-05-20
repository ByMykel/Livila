<template>
    <div
        class="bg-black-300 rounded-md shadow p-4 text-white mb-2 overflow-hidden flex"
    >
        <div class="hidden sm:flex flex-shrink-0 p-4 w-40">
            <a class="flex" :href="route('lists.show', list.id)">
                <span
                    v-for="movie in moviesList.movies"
                    :key="movie.id"
                    class="inline w-24 -m-7"
                >
                    <div
                        v-show="showSkeletonImage"
                        class="bg-black-200 h-full rounded-md shadow-md border border-indigo-400 animate-pulse"
                    ></div>
                    <img
                        v-show="!showSkeletonImage"
                        class="rounded-md shadow-md border border-indigo-400"
                        :src="poster(movie)"
                        @load="showSkeletonImage = false"
                    />
                </span>
            </a>
        </div>
        <div class="block sm:ml-24 w-full">
            <a
                class="hover:text-indigo-400"
                :href="route('lists.show', list.id)"
            >
                <h2 class="block line-clamp-1 break-all">
                    {{ moviesList.name }}
                </h2>
            </a>
            <div class="my-0.5 flex items-center">
                <div>
                    <img
                        class="w-4 rounded-full mr-1"
                        :src="list.user.profile_photo_url"
                    />
                </div>
                <div class="flex items-center">
                    {{ list.user.name }}
                    <span class="ml-2 text-xs text-black-100">
                        {{ list.movies_count }} movies ·
                        {{ list.likes_count }} likes
                    </span>
                </div>
            </div>
            <div>
                <p class="block text-sm text-black-100 break-all line-clamp-2">
                    {{ moviesList.description }}
                </p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        moviesList: Object,
    },

    data() {
        return {
            list: this.moviesList,
            showSkeletonImage: true,
        };
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

    mounted() {
        if (this.list.movies_count < 5) {
            for (let i = 0; i < 5 - this.list.movies_count; i++) {
                this.list.movies.push({
                    id: this.list.id + "-" + i,
                    poster_path: "empty_poster_path.png",
                });
            }

            this.list.movies.movies_count = 5;
            this.list.movies.reverse();
        }
    },
};
</script>
