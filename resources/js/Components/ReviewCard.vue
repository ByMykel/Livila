<template>
    <div
        class="bg-gray-800 rounded-md shadow p-3 text-white my-2 overflow-hidden relative"
    >
        <div
            class="py-1 px-2 rounded-bl-md absolute top-0 right-0 text-xs font-medium"
            :class="review.recommended ? 'bg-green-500' : 'bg-red-500'"
        >
            {{ isRecommended }}
        </div>

        <div class="flex items-center">
            <img
                class="w-10 rounded-full"
                :src="review.user.profile_photo_url"
                alt=""
            />
            <div class="ml-2">
                <p>
                    Reviewed by
                    <span class="font-bold">{{ review.user.name }}</span>
                </p>
                <p class="text-xs text-gray-500">{{ review.updated_at }}</p>
            </div>
        </div>

        <div class="my-2">
            <h3 class="font-bold">{{ review.movie.title }}</h3>
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
    },

    computed: {
        isRecommended() {
            return this.review.recommended ? "Recommended" : "Not Recommended";
        },
    },

    methods: {},
};
</script>
