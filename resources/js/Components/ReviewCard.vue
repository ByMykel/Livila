<template>
    <div
        class="bg-gray-800 rounded-md shadow p-3 text-white my-2 overflow-hidden relative"
    >
        <div
            class="py-1 px-2 rounded-bl-md absolute top-0 right-0 text-xs font-medium"
            :class="review.recommended ? 'bg-green-500' : 'bg-red-500'"
        >
            <span class="hidden sm:block">{{ isRecommended }}</span>

            <span class="block sm:hidden">
                <span v-if="!review.recommended">
                    <svg
                        class="w-4 h-4"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M18 9.5a1.5 1.5 0 11-3 0v-6a1.5 1.5 0 013 0v6zM14 9.667v-5.43a2 2 0 00-1.105-1.79l-.05-.025A4 4 0 0011.055 2H5.64a2 2 0 00-1.962 1.608l-1.2 6A2 2 0 004.44 12H8v4a2 2 0 002 2 1 1 0 001-1v-.667a4 4 0 01.8-2.4l1.4-1.866a4 4 0 00.8-2.4z"
                        ></path>
                    </svg>
                </span>

                <span v-else>
                    <svg
                        class="w-4 h-4"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"
                        ></path>
                    </svg>
                </span>
            </span>
        </div>

        <div class="flex items-center">
            <img
                v-if="showTitle"
                class="w-8 sm:w-10 rounded-md"
                :src="poster"
                alt=""
            />

            <img
                v-else
                class="w-8 sm:w-10 rounded-full"
                :src="review.user.profile_photo_url"
                alt=""
            />

            <div class="ml-2 text-sm">
                <p>
                    Reviewed by
                    <a
                        class="hover:text-indigo-400 font-medium"
                        :href="route('user', review.user.username)"
                    >
                        {{ review.user.username }}
                    </a>
                </p>

                <p class="text-xs text-gray-500">{{ review.updated_at }}</p>
            </div>
        </div>

        <div class="my-2 text-sm">
            <h3
                v-show="showTitle"
                class="break-words hover:text-indigo-500 hover:underline"
            >
                <a :href="route('movies.show', review.movie.id)">
                    {{ review.movie.title }}
                </a>
            </h3>

            <p class="text-gray-300 break-words">{{ review.review }}</p>
        </div>

        <div class="flex text-sm">
            <div class="flex mr-5 cursor-pointer" @click="like()">
                <svg
                    class="w-5 h-5 text-gray-400 hover:text-red-400"
                    :class="{ 'text-red-500 hover:text-red-400': review.like }"
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

                <span class="ml-1">{{ review.likes_count }}</span>
            </div>

            <div class="flex">
                <svg
                    class="w-5 h-5 text-gray-400"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        fill-rule="evenodd"
                        d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                        clip-rule="evenodd"
                    ></path>
                </svg>

                <span class="ml-1">{{ review.comments_count }}</span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    components: {},

    props: {
        review: Object,
        showTitle: {
            default: false,
            type: Boolean,
        },
    },

    computed: {
        isRecommended() {
            return this.review.recommended ? "Recommended" : "Not Recommended";
        },

        poster() {
            if (this.review.movie.poster_path) {
                return (
                    "https://image.tmdb.org/t/p/w780" +
                    this.review.movie.poster_path
                );
            }

            return "/images/default_poster_path.png";
        },
    },

    methods: {
        like() {
            this.$inertia.post(
                route("movies.reviews.like", [
                    this.review.movie,
                    this.review.id,
                ]),
                {},
                {
                    preserveState: false,
                    preserveScroll: true,
                    resetOnSuccess: false,
                }
            );
        },
    },
};
</script>
