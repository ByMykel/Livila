<template>
    <div
        class="flex p-4 mb-2 overflow-hidden text-white rounded-md shadow bg-black-300"
    >
        <div class="flex-shrink-0 hidden w-40 p-4 sm:flex">
            <a class="flex" :href="route('lists.show', list.id)">
                <span
                    v-for="movie in moviesList.movies"
                    :key="movie.id"
                    class="inline w-24 -m-7"
                >
                    <div
                        v-show="showSkeletonImage"
                        class="border border-indigo-400 rounded-md shadow-md bg-black-200 h-36 animate-pulse"
                    ></div>
                    <img
                        v-show="!showSkeletonImage"
                        class="object-cover h-full border border-indigo-400 rounded-md shadow-sm"
                        :src="poster(movie)"
                        @load="showSkeletonImage = false"
                    />
                </span>
            </a>
        </div>
        <div class="block w-full sm:ml-24">
            <a
                class="hover:text-indigo-400"
                :href="route('lists.show', list.id)"
            >
                <h2 class="block break-all line-clamp-1">
                    {{ moviesList.name }}
                </h2>
            </a>
            <div class="my-0.5 flex items-center">
                <div>
                    <img
                        class="w-4 mr-1 rounded-full"
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
                <p class="block text-sm break-all text-black-100 line-clamp-2">
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
            if (movie.poster_path === "empty_poster_path.jpeg") {
                return "/images/empty_poster_path.jpeg";
            }

            if (movie.poster_path) {
                return "https://image.tmdb.org/t/p/original" + movie.poster_path;
            }

            return "/images/placeholder.jpeg";
        },
    },

    mounted() {
        if (this.list.movies_count < 5) {
            for (let i = 0; i < 5 - this.list.movies_count; i++) {
                this.list.movies.push({
                    id: this.list.id + "-" + i,
                    poster_path: "empty_poster_path.jpeg",
                });
            }

            this.list.movies.movies_count = 5;
            this.list.movies.reverse();
        }
    },
};
</script>
