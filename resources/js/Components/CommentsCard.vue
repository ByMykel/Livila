<template>
    <div
        class="bg-gray-800 rounded-md shadow p-3 text-white my-2 overflow-hidden relative"
    >
        <div
            v-show="canDelete"
            class="py-0.5 px-1 rounded-tl-md absolute bottom-0 right-0 text-xs font-medium bg-red-500"
        >
            <span class="block">
                <button class="flex items-center" @click="deleteComment()">
                    <svg
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                        ></path>
                    </svg>
                </button>
            </span>
        </div>

        <div class="flex items-center">
            <img
                class="w-8 sm:w-10 rounded-full"
                :src="comment.user.profile_photo_url"
                alt=""
            />

            <div class="ml-2 text-sm">
                <span class="font-medium">{{ comment.user.username }}</span>

                <p class="text-xs text-gray-500">{{ comment.updated_at }}</p>
            </div>
        </div>

        <div class="my-2 text-sm">
            <p class="text-gray-300 break-words">{{ comment.comment }}</p>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        movie: Object,
        review: Object,
        comment: Object,
    },

    computed: {
        canDelete() {
            return this.$page.props.user.id === this.comment.user_id;
        },
    },

    methods: {
        deleteComment() {
            this.$inertia.delete(
                route("reviews.comments.destroy", [
                    this.movie.id,
                    this.review.id,
                    this.comment.id,
                ]),

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
