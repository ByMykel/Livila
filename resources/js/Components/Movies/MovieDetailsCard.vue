<template>
    <div>
        <!-- TODO: Add link to a full size backdrop image. -->
        <div
            v-show="showSkeletonBackdrop && backdrop && !hideBackdrop"
            class="w-full rounded-md bg-black-300 md:mb-10 h-72 sm:h-80 md:h-96 animate-pulse"
        ></div>
        <img
            v-show="!showSkeletonBackdrop && backdrop && !hideBackdrop"
            class="block object-cover w-full rounded-md shadow-inner md:mb-10 h-72 sm:h-80 md:h-96"
            :src="backdrop"
            @load="showSkeletonBackdrop = false"
        />

        <div class="flex-1 md:flex">
            <div class="flex-initial hidden md:block md:mr-6">
                <div
                    v-show="showSkeletonPoster"
                    class="mx-auto rounded-md bg-black-300 h-96 w-72 animate-pulse"
                ></div>
                <img
                    v-show="!showSkeletonPoster"
                    class="mx-auto rounded-md shadow w-72"
                    :src="poster"
                    @load="showSkeletonPoster = false"
                />
            </div>
            <div class="relative flex flex-col flex-1 lg:flex-row">
                <div class="w-full p-1">
                    <p
                        class="mt-1 text-3xl font-extrabold text-center text-white md:text-left"
                    >
                        {{ movie.title }}
                    </p>
                    <div
                        class="flex flex-wrap mt-2 mb-3 text-sm text-center text-indigo-300 md:text-left gap-y-1"
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
        hideBackdrop: {
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

            return "/images/placeholder.jpeg";
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
