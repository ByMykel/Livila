<template>
    <div class="my-2">
        <div class="grid grid-cols-6 gap-2 md:hidden">
            <div v-for="review in reviews.slice(0, 6)" :key="review.id">
                <review-image :review="review" />
            </div>
        </div>

        <div class="hidden grid-cols-8 gap-2 md:grid">
            <div v-for="review in reviews.slice(0, 8)" :key="review.id">
                <review-image :review="review" />
            </div>
        </div>
    </div>
</template>

<script>
import ReviewImage from "@/Components/Reviews/ReviewImage.vue";

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

            return "/images/placeholder.jpeg";
        },
    },
};
</script>
