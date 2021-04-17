<template>
    <div class="mb-1 pb-4 flex flex-col justify-between h-full">
        <div
            class="relative"
            @mouseenter="show = true"
            @mouseleave="show = false"
        >
            <transition
                enter-active-class="transition ease-out duration-150"
                enter-from-class="transform opacity-0 scale-105"
                enter-to-class="transform opacity-100 scale-100"
                leave-active-class="transition ease-in duration-100"
                leave-from-class="transform opacity-100"
                leave-to-class="transform opacity-0"
            >
                <a
                    v-show="show || movie.watched"
                    :href="route('movies.show', movie.id)"
                    class="absolute w-full h-full cursor-pointer bg-black bg-opacity-70"
                    :class="[
                        border ? 'rounded-sm' : 'rounded',
                        show ? 'border-2 border-indigo-500' : '',
                    ]"
                ></a>
            </transition>

            <button v-show="show" class="absolute left-1 top-1" @click="like()">
                <svg
                    class="hidden sm:block w-5 h-5 hover:text-blue-500 text-gray-100"
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

            <button
                v-show="show"
                class="absolute right-1 top-1"
                @click="watch()"
            >
                <svg
                    class="hidden sm:block w-5 h-5 hover:text-blue-500 text-gray-100"
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

            <img v-else class="max-h-48 w-full shadow rounded" :src="poster" />
        </div>

        <div>
            <p
                :title="movie.title"
                class="truncate text-white text-sm font-semibold"
            >
                {{ movie.title }}
            </p>

            <p :title="movie.title" class="truncate text-gray-400 text-xs">
                {{ year }}
            </p>
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
                    "https://image.tmdb.org/t/p/w500" + this.movie.poster_path
                );
            }

            return "/images/default_poster_path.png";
        },

        year() {
            return new Date(this.movie.release_date).getFullYear();
        },
    },

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
