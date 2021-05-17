<template>
    <div class="grid grid-cols-4 sm:grid-cols-5 md:grid-cols-6 lg:grid-cols-7 gap-2">
        <div v-for="movie in movies" :key="movie.id">
            <movie-image :movie="movie" :border="false" />
        </div>
    </div>
</template>

<script>
import MovieImage from "@/Components/Movies/MovieImage.vue";

export default {
    components: {
        MovieImage,
    },

    props: {
        movies: Object,
    },
};
</script>
