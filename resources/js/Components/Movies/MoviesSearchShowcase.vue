<template>
    <div class="grid w-full gap-2 mx-auto movies-grid-small md:movies-grid">
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
