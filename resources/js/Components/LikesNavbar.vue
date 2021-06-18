<template>
    <div class="mt-5 mb-2 text-gray-400 flex px-1 font-semibold text-base">
        <a
            :href="route('user.likes.movies', user.username)"
            class="hover:border-b-2 hover:text-white px-3 border-gray-500"
            :class="{
                'text-white border-indigo-600 border-b-2': route().current(
                    'user.likes.movies',
                    user.username
                ),
            }"
            >Movies</a
        >
        <a
            :href="route('user.likes.reviews', user.username)"
            class="hover:border-b-2 hover:text-white px-3 border-gray-500"
            :class="{
                'text-white border-indigo-600 border-b-2': route().current(
                    'user.likes.reviews',
                    user.username
                ),
            }"
            >Reviews</a
        >
        <a
            :href="route('user.likes.lists', user.username)"
            class="hover:border-b-2 hover:text-white px-3 border-gray-500"
            :class="{
                'text-white border-indigo-600 border-b-2': route().current(
                    'user.likes.lists',
                    user.username
                ),
            }"
            >Lists</a
        >
    </div>
</template>

<script>
export default {
    props: {
        user: Object,
    },
};
</script>