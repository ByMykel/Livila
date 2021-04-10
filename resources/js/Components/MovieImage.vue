<template>
    <div class="mb-2" @mouseenter="show = true" @mouseleave="show = false">
        <p v-if="!border" :title="movie.title" class="truncate text-white text-sm">
            {{ movie.title }}
        </p>

        <div class="relative">
            <div
                v-show="show || movie.watched"
                class="absolute w-full h-full cursor-pointer bg-black bg-opacity-50"
                :class="[
                    border ? 'rounded-sm' : 'rounded-md',
                    show ? 'border border-indigo-500' : '',
                ]"
                @click="visit()"
            ></div>

            <button v-show="show" class="absolute left-0.5" @click="like()">
                <svg
                    class="w-5 h-5 hover:text-blue-500 text-gray-200"
                    :class="[
                        movie.liked
                            ? 'text-red-500'
                            : 'opacity-40 hover:opacity-100',
                    ]"
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

            <button v-show="show" class="absolute right-0.5" @click="watch()">
                <svg
                    class="w-5 h-5 hover:text-blue-500 text-gray-200"
                    :class="[
                        movie.watched
                            ? 'text-green-500'
                            : 'opacity-40 hover:opacity-100',
                    ]"
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

            <img v-if="border" class="rounded-sm shadow" :src="poster" />

            <img v-else class="max-h-48 shadow rounded-md" :src="poster" />
        </div>
    </div>
</template>

<script>
export default {
    components: {},

    props: {
        movie: Object,
        border: {
            type: Boolean,
            default: true,
        },
    },

    data() {
        return {
            show: false,
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
    },

    methods: {
        visit() {
            this.$inertia.visit(route("movies.show", this.movie.id));
        },

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
