<template>
    <div>
        <!-- TODO: Add link to a full size backdrop image. -->
        <div
            v-show="showSkeletonBackdrop && backdrop && !isReviewsPage"
            class="bg-black-300 md:mb-6 rounded-md h-72 sm:h-80 md:h-96 w-full animate-pulse"
        ></div>
        <img
            v-show="!showSkeletonBackdrop && backdrop && !isReviewsPage"
            class="block md:mb-6 rounded-md h-72 sm:h-80 md:h-96 w-full object-cover shadow-inner"
            :src="backdrop"
            @load="showSkeletonBackdrop = false"
        />

        <div class="md:flex flex-1">
            <div class="hidden md:block md:mr-6 flex-initial z-10">
                <div
                    v-show="showSkeletonPoster"
                    class="bg-black-300 h-96 rounded-md mx-auto w-72 animate-pulse"
                ></div>
                <img
                    v-show="!showSkeletonPoster"
                    class="shadow rounded-md mx-auto w-72"
                    :src="poster"
                    @load="showSkeletonPoster = false"
                />
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
    props: {
        movie: Object,
        isReviewsPage: {
            type: Boolean,
            default: false,
        },
    },

    data() {
        return {
            showSkeletonBackdrop: true,
            showSkeletonPoster: true,
        };
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
};
</script>
