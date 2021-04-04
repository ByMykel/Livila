<template>
    <div>
        <title-image :title="review.movie.title" :show="show" />

        <a
            @mouseenter="show = true"
            @mouseleave="show = false"
            :href="route('movies.reviews.show', [review.movie.id, review.id])"
        >
            <img
                class="duration-100 rounded-sm border-2 hover:border-indigo-500"
                :src="poster"
            />
        </a>
    </div>
</template>

<script>
import TitleImage from "@/Components/TitleImage";

export default {
    components: {
        TitleImage,
    },

    props: {
        review: Object,
    },

    data() {
        return {
            show: false,
        };
    },

    computed: {
        poster() {
            if (this.review.movie.poster_path) {
                return (
                    "https://image.tmdb.org/t/p/w300" +
                    this.review.movie.poster_path
                );
            }

            return "/images/default_poster_path.png";
        },
    },
};
</script>
