<template>
    <div class="h-full flex flex-col justify-between mb-1 pb-2">
        <a
            @mouseenter="show = true"
            @mouseleave="show = false"
            :href="route('movies.reviews.show', [review.movie.id, review.id])"
        >
            <img
                class="duration-100 rounded-sm border-2 hover:border-indigo-500"
                :src="poster"
                :title="review.movie.title"
            />
        </a>

        <div>
            <p
                :title="review.movie.title"
                class="truncate text-white text-sm font-semibold"
            >
                {{ review.movie.title }}
            </p>

            <p :title="review.movie.title" class="truncate text-gray-400 text-xs">
                {{ year }}
            </p>
        </div>
    </div>
</template>

<script>
export default {
    components: {},

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

        year() {
            return new Date(this.review.movie.release_date).getFullYear();
        }
    },
};
</script>
