<template>
    <div class="grid grid-cols-5 sm:grid-cols-8 md:grid-cols-10 gap-2">
        <div v-for="movie in movies" :key="movie.id">
            <movie-list-image :movie="movie" :deleted="movie.deleted" />
        </div>
    </div>
</template>

<script>
import MovieListImage from "@/Components/MoviesList/MovieListImage.vue";

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
};
</script>
