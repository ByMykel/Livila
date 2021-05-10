<template>
    <div class="border-b border-black-300 mt-5 mb-5 text-gray-400 flex px-1">
        <a
            :href="route('user.likes.movies', user.username)"
            class="hover:border-b hover:text-white px-3 border-gray-500"
            :class="{
                'text-white border-indigo-600 border-b': route().current(
                    'user.likes.movies',
                    user.username
                ),
            }"
            >Movies</a
        >
        <a
            :href="route('user.likes.reviews', user.username)"
            class="hover:border-b hover:text-white px-3 border-gray-500"
            :class="{
                'text-white border-indigo-600 border-b': route().current(
                    'user.likes.reviews',
                    user.username
                ),
            }"
            >Reviews</a
        >
        <a
            :href="route('user.likes.lists', user.username)"
            class="hover:border-b hover:text-white px-3 border-gray-500"
            :class="{
                'text-white border-indigo-600 border-b': route().current(
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