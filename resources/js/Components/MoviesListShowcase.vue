<template>
    <div
        v-if="all"
        class="grid grid-cols-5 sm:grid-cols-8 md:grid-cols-10 gap-2"
    >
        <div v-for="movie in movies" :key="movie.id">
            <movie-list-image :movie="movie" :border="false" />
        </div>
    </div>

    <div v-else class="my-2">
        <div class="md:hidden grid grid-cols-5 gap-2">
            <div v-for="movie in movies.slice(0, 5)" :key="movie.id">
                <movie-list-image :movie="movie" />
            </div>
        </div>

        <div class="hidden md:grid grid-flow-col gap-2">
            <div v-for="movie in movies.slice(0, 8)" :key="movie.id">
                <movie-list-image :movie="movie" />
            </div>
        </div>
    </div>
</template>

<script>
import MovieListImage from "@/Components/MovieListImage.vue";

export default {
    components: {
        MovieListImage,
    },

    props: {
        movies: Object,
        all: {
            type: Boolean,
            default: true,
        },
    },

    computed: {},

    methods: {},
};
</script>
