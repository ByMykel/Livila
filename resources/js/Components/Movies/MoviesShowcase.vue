<template>
    <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-2">
        <div v-for="movie in movies" :key="movie.id">
            <movie-image :movie="movie" :isUser="isUser" />
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
        user: Object,
        movies: Object,
        isUser: {
            type: Boolean,
            default: false,
        },
    },
};
</script>
