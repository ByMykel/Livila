<template>
    <div>
        <div
            v-show="showSkeletonBackdrop && backdrop"
            class="bg-black-300 md:mb-10 rounded-md h-72 sm:h-80 md:h-96 w-full animate-pulse"
        ></div>
        <div class="relative">
            <img
                v-show="!showSkeletonBackdrop && backdrop"
                class="block md:mb-10 rounded-md h-72 sm:h-80 md:h-96 w-full object-cover shadow-inner opacity-90"
                :src="backdrop"
                @load="showSkeletonBackdrop = false"
            />

            <div
                v-show="!showSkeletonBackdrop && backdrop"
                class="absolute bottom-1 right-1"
            >
                <div class="bg-black-500 rounded-md px-4 py-1 flex">
                    <div>
                        <div
                            class="text-white font-extrabold text-lg sm:text-2xl md:text-3xl uppercase"
                        >
                            {{ movie.title }}
                        </div>
                        <div class="text-black-100 font-bold uppercase">
                            {{ year }}
                        </div>
                    </div>
                    <div class="flex items-center justify-center">
                        <a :href="route('movies.show', movie.id)">
                            <svg
                                class="w-6 h-6 text-white ml-5 hover:text-indigo-400"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z"
                                ></path>
                                <path
                                    d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z"
                                ></path>
                            </svg>
                        </a>
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
    },

    data() {
        return {
            showSkeletonBackdrop: true,
        };
    },

    computed: {
        backdrop() {
            if (this.movie.backdrop_path) {
                return (
                    "https://image.tmdb.org/t/p/original/" +
                    this.movie.backdrop_path
                );
            }

            return "";
        },

        year() {
            return new Date(this.movie.release_date).getFullYear();
        },
    },
};
</script>