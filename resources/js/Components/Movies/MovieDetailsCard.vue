<template>
    <div>
        <!-- TODO: Add link to a full size backdrop image. -->
        <div
            v-show="showSkeletonBackdrop && backdrop && !isReviewsPage"
            class="bg-black-300 md:mb-10 rounded-md h-72 sm:h-80 md:h-96 w-full animate-pulse"
        ></div>
        <img
            v-show="!showSkeletonBackdrop && backdrop && !isReviewsPage"
            class="block md:mb-10 rounded-md h-72 sm:h-80 md:h-96 w-full object-cover shadow-inner"
            :src="backdrop"
            @load="showSkeletonBackdrop = false"
        />

        <div class="md:flex flex-1">
            <div class="hidden md:block md:mr-6 flex-initial">
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
            <div class="flex flex-col lg:flex-row flex-1 relative">
                <div class="w-full p-1">
                    <p
                        class="text-center md:text-left mt-1 text-3xl font-extrabold text-white"
                    >
                        {{ movie.title }}
                    </p>
                    <div
                        class="text-center md:text-left mt-2 mb-3 text-sm text-indigo-300 flex flex-wrap gap-y-1"
                    >
                        <span
                            v-if="movie.release_date"
                            class="movie-information-tag"
                            :title="movie.release_date"
                        >
                            {{ year }}
                        </span>
                        <span
                            v-if="movie.genres.length"
                            class="movie-information-tag"
                        >
                            {{ movieGenres }}
                        </span>
                        <span
                            v-if="movie.runtime"
                            class="movie-information-tag"
                        >
                            {{ movieRuntime }}
                        </span>
                        <span
                            v-if="movie.vote_average"
                            class="movie-information-tag"
                        >
                            {{ movie.vote_average }}/10
                        </span>
                    </div>
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

        movieRuntime() {
            let runtime = this.movie.runtime;

            if (runtime < 60) {
                return `${runtime}min`;
            }

            if (runtime % 60 === 0) {
                return `${runtime / 60}h`;
            }

            return `${parseInt(runtime / 60)}h ${runtime % 60}min`;
        },

        movieGenres() {
            return this.movie.genres.map((item) => item.name).join(", ");
        },

        year() {
            return new Date(this.movie.release_date).getFullYear();
        },
    },
};
</script>
