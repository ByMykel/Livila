<template>
    <div
        v-if="all"
        class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-2"
    >
        <div v-for="movie in movies" :key="movie.id">
            <movie-image :movie="movie" :border="false" />
        </div>
    </div>

    <div v-else class="my-2">
        <div class="md:hidden grid grid-cols-5 gap-2">
            <div v-for="movie in movies.slice(0, 5)" :key="movie.id">
                <movie-image :movie="movie" />
            </div>
        </div>

        <div class="hidden md:grid grid-cols-8 gap-2">
            <div v-for="movie in movies.slice(0, 8)" :key="movie.id">
                <movie-image :movie="movie" />
            </div>
        </div>
    </div>
</template>

<script>
import MovieImage from "@/Components/MovieImage.vue";

export default {
    components: {
        MovieImage,
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
