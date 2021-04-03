<template>
    <div class="my-2">
        <div class="md:hidden grid grid-cols-5 gap-2">
            <div v-for="review in reviews.slice(0, 5)" :key="review.id">
                <a :href="route('movies.reviews.show', [review.movie.id, review.id])">
                    <img
                        class="duration-100 rounded-sm border-2 hover:border-indigo-500"
                        :src="poster(review.movie)"
                    />
                </a>
            </div>
        </div>

        <div class="hidden md:grid grid-flow-col gap-2">
            <div v-for="review in reviews.slice(0, 8)" :key="review.id">
                <a :href="route('movies.reviews.show', [review.movie.id, review.id])">
                    <img
                        class="duration-100 rounded-sm border-2 hover:border-indigo-500"
                        :src="poster(review.movie)"
                    />
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    components: {},

    props: {
        reviews: Object,
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
