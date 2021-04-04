<template>
    <div class="my-2">
        <div class="md:hidden grid grid-cols-5 gap-2">
            <div v-for="review in reviews.slice(0, 5)" :key="review.id">
                <review-image :review="review" />
            </div>
        </div>

        <div class="hidden md:grid grid-flow-col gap-2">
            <div v-for="review in reviews.slice(0, 8)" :key="review.id">
                <review-image :review="review" />
            </div>
        </div>
    </div>
</template>

<script>
import ReviewImage from "@/Components/ReviewImage.vue";

export default {
    components: {
        ReviewImage,
    },

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
