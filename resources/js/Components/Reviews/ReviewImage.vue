<template>
    <div class="flex flex-col justify-between h-full pb-2 mb-1">
        <a
            :href="route('movies.show', review.movie.id)"
            @mouseenter="show = true"
            @mouseleave="show = false"
        >
            <img
                class="rounded shadow hover:border hover:border-indigo-400"
                :src="poster"
                :title="review.movie.title"
            />
        </a>

        <div>
            <p
                :title="review.movie.title"
                class="text-sm font-semibold text-white truncate"
            >
                {{ review.movie.title }}
            </p>

            <p
                :title="review.movie.title"
                class="text-xs text-gray-400 truncate"
            >
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

            return "/images/placeholder.jpeg";
        },

        year() {
            return new Date(this.review.movie.release_date).getFullYear();
        },
    },
};
</script>
