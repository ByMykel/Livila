<template>
    <div class="grid grid-cols-5 sm:grid-cols-8 md:grid-cols-10 gap-2">
        <div v-for="movie in movies" :key="movie.id">
            <a :href="route('movies.show', movie.id)">
                <img
                    class="duration-100 max-h-48 object-cover shadow rounded-md hover:border-2 hover:border-indigo-500"
                    :src="poster(movie)"
                />
            </a>
        </div>
    </div>
</template>

<script>
export default {
    components: {},

    props: {
        movies: Object,
    },

    computed: {},

    methods: {
        poster(movie) {
            if (movie.poster_path) {
                return "https://image.tmdb.org/t/p/w300" + movie.poster_path;
            }

            return "/images/default_poster_path.png";
        },
    },
};
</script>
