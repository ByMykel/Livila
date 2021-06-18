<template>
    <div class="mt-5 mb-2 text-black-100 flex px-1 font-semibold text-base">
        <a
            :href="route('movies.reviews.index', movie.id)"
            class="hover:border-b-2 hover:text-white px-3 border-black-100"
            :class="{
                'text-white border-indigo-600 border-b-2': route().current(
                    'movies.reviews.index',
                    movie.id
                ),
            }"
            >Recent</a
        >
        <a
            :href="route('movies.reviews.popular', movie.id)"
            class="hover:border-b-2 hover:text-white px-3 border-black-100"
            :class="{
                'text-white border-indigo-600 border-b-2': route().current(
                    'movies.reviews.popular',
                    movie.id
                ),
            }"
            >Popular</a
        >
        <a
            v-if="$page.props.auth"
            :href="route('movies.reviews.friends', movie.id)"
            class="hover:border-b-2 hover:text-white px-3 border-black-100"
            :class="{
                'text-white border-indigo-600 border-b-2': route().current(
                    'movies.reviews.friends',
                    movie.id
                ),
            }"
            >Friends</a
        >
    </div>
</template>

<script>
export default {
    props: {
        movie: Object,
    },
};
</script>