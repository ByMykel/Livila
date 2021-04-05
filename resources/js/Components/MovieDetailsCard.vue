<template>
    <div>
        <img
            class="absolute left-0 -top-3 opacity-5 rounded-lg z-0"
            :src="backdrop"
        />

        <div class="lg:flex">
            <div class="md:flex flex-1">
                <div class="md:mr-2 flex-initial z-10">
                    <img
                        class="shadow rounded-md mx-auto"
                        :class="{ 'w-28': reviewPage }"
                        :src="poster"
                    />
                </div>

                <div class="flex flex-col lg:flex-row flex-1 z-10">
                    <div class="w-full p-1">
                        <p
                            class="text-center md:text-left mt-1 text-3xl leading-8 font-extrabold tracking-tight text-indigo-500"
                        >
                            <a
                                v-if="reviewPage"
                                class="hover:underline"
                                :href="route('movies.show', movie.id)"
                                >{{ movie.title }}</a
                            >
                            <span v-else>{{ movie.title }}</span>
                        </p>

                        <div>
                            <p class="mt-3 text-sm text-indigo-300">
                                {{ movieStats }}
                            </p>
                            <p class="text-md text-white">
                                {{ movie.overview }}
                            </p>
                        </div>
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
    },

    computed: {
        poster() {
            if (this.movie.poster_path) {
                return (
                    "https://image.tmdb.org/t/p/w300" + this.movie.poster_path
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
            return `${this.movie.release_date} · ${this.movie.runtime}m · ${this.movie.vote_average}/10`;
        },
    },

    methods: {},
};
</script>
