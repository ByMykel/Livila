<template>
    <form
        v-if="$page.props.auth && $page.props.auth.id !== user.id"
        @submit.prevent="follow"
    >
        <button
            v-if="!user.follow"
            type="submit"
            class="bg-black-200 hover:bg-black-100 px-3 py-0.5 rounded-md shadow text-white text-sm sm:text-base duration-200"
        >
            Follow
        </button>

        <button
            v-else
            type="submit"
            class="px-3 py-0.5 rounded-md shadow text-white text-sm sm:text-base duration-200"
            :class="[
                hoverButton
                    ? 'bg-red-700 hover:bg-red-600'
                    : 'bg-green-600 hover:bg-green-500',
            ]"
            @mouseenter="hoverButton = true"
            @mouseleave="hoverButton = false"
        >
            <span v-if="hoverButton">Unfollow</span>
            <span v-else>Following</span>
        </button>
    </form>
</template>

<script>
export default {
    props: {
        user: Object,
    },

    data() {
        return {
            hoverButton: false,
        };
    },

    methods: {
        follow() {
            this.$inertia.post(
                route("user.follow", this.user),
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