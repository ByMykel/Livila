<template>
    <div class="bg-black-300 rounded-md shadow relative p-2 mt-10">
        <div
            class="bg-black-400 rounded-md flex justify-around p-2 text-black-100"
        >
            <button class="focus:outline-none" @click="like()">
                <svg
                    class="w-6 h-6 hover:text-red-400"
                    :class="{ 'text-red-500': liked }"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        fill-rule="evenodd"
                        d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                        clip-rule="evenodd"
                    ></path>
                </svg>
            </button>

            <button class="focus:outline-none" @click="watch()">
                <svg
                    class="w-6 h-6 hover:text-green-400"
                    :class="{ 'text-green-500': watched }"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                    <path
                        fill-rule="evenodd"
                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                        clip-rule="evenodd"
                    ></path>
                </svg>
            </button>

            <button
                class="focus:outline-none"
                @click="(showReview = false), (showList = !showList)"
            >
                <svg
                    class="w-6 h-6 hover:text-yellow-400"
                    :class="{ 'text-yellow-500': showList }"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z"
                    ></path>
                </svg>
            </button>

            <button
                class="focus:outline-none"
                @click="(showList = false), (showReview = !showReview)"
            >
                <svg
                    class="w-6 h-6 hover:text-blue-400"
                    :class="{ 'text-blue-500': showReview }"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        fill-rule="evenodd"
                        d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z"
                        clip-rule="evenodd"
                    ></path>
                </svg>
            </button>
        </div>

        <div v-show="showList">
            <movies-list-form-menu
                :lists="lists"
                :movie="movie"
            ></movies-list-form-menu>
        </div>

        <div v-show="showReview">
            <review-form :movie="movie" :review="review" />
        </div>
    </div>
</template>

<script>
import MoviesListFormMenu from "@/Components/MoviesList/MoviesListFormMenu";
import ReviewForm from "@/Components/Reviews/ReviewForm";

export default {
    components: {
        MoviesListFormMenu,
        ReviewForm,
    },

    props: {
        movie: Object,
        liked: Boolean,
        watched: Boolean,
        lists: Object,
        review: Object,
    },

    data() {
        return {
            showList: false,
            showReview: false,
        };
    },

    computed: {},

    methods: {
        like() {
            this.$inertia.post(
                route("movies.like", this.movie.id),
                {},
                {
                    preserveState: true,
                    preserveScroll: true,
                    resetOnSuccess: false,
                }
            );
        },

        watch() {
            this.$inertia.post(
                route("movies.watch", this.movie.id),
                {},
                {
                    preserveState: true,
                    preserveScroll: true,
                    resetOnSuccess: false,
                }
            );
        },
    },
};
</script>
