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
                class="w-8 sm:w-10 rounded-full"
                :src="review.user.profile_photo_url"
                alt=""
            />

            <div class="ml-2 text-sm">
                <p>
                    <a
                        class="hover:text-indigo-400"
                        :href="
                            route('movies.reviews.show', [
                                review.movie.id,
                                review.id,
                            ])
                        "
                        >Reviewed by
                    </a>
                    <span class="font-medium">{{ review.user.name }}</span>
                </p>
                <p class="text-xs text-gray-500">{{ review.updated_at }}</p>
            </div>
        </div>

        <div class="my-2 text-sm">
            <h3
                v-show="showTitle"
                class="break-words hover:text-indigo-500 hover:underline"
            >
                <a
                    :href="
                        route('movies.reviews.show', [
                            review.movie.id,
                            review.id,
                        ])
                    "
                >
                    {{ review.movie.title }}
                </a>
            </h3>

            <p class="text-gray-300 break-words">{{ review.review }}</p>
        </div>

        <div>{{ review.likes_count }} likes</div>
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
    },

    methods: {},
};
</script>
