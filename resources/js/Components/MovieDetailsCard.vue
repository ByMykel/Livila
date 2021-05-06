<template>
    <div>
        <!-- TODO: Add link to a full size backdrop image. -->
        <img
            v-show="showBackdrop"
            class="block md:mb-6 rounded-md h-72 sm:h-80 md:h-96 w-full object-cover shadow-inner"
            :src="backdrop"
        />

        <div class="md:flex flex-1">
            <div class="hidden md:block md:mr-6 flex-initial z-10">
                <img class="shadow rounded-md mx-auto w-72" :src="poster" />
            </div>
            <div class="flex flex-col lg:flex-row flex-1 relative z-0">
                <div class="w-full p-1">
                    <p
                        class="text-center md:text-left mt-1 text-3xl font-extrabold text-white"
                    >
                        {{ movie.title }}
                    </p>
                    <p
                        class="text-center md:text-left mt-2 mb-3 text-sm text-indigo-300"
                        v-html="movieStats"
                    ></p>
                    <div>
                        <p class="text-md text-black-100">
                            {{ movie.overview }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    components: {},

    props: {
        movie: Object,
        reviewPage: {
            default: false,
            type: Boolean,
        },
        showBackdrop: {
            default: true,
            type: Boolean,
        },
    },

    computed: {
        poster() {
            if (this.movie.poster_path) {
                return (
                    "https://image.tmdb.org/t/p/w780" + this.movie.poster_path
                );
            }

            return "/images/default_poster_path.png";
        },

        backdrop() {
            if (this.movie.backdrop_path) {
                return (
                    "https://image.tmdb.org/t/p/original/" +
                    this.movie.backdrop_path
                );
            }

            return "";
        },

        movieStats() {
            return `<span class="movie-information-tag">${this.movie.release_date}</span><span class="movie-information-tag">${this.movie.runtime}m</span></span><span class="movie-information-tag">${this.movie.vote_average}/10</span>`;
        },
    },

    methods: {},
};
</script>
