<template>
    <div
        class="relative cursor-pointer"
        :title="movie.title"
        @mouseenter="show = true"
        @mouseleave="show = false"
        @click="$parent.$emit('remove-movie', movie.id)"
    >
        <div
            v-show="show || deleted"
            class="absolute flex items-center justify-center w-full h-full"
        >
            <svg
                v-if="!deleted"
                class="z-10 w-10 h-10 p-2 text-white duration-100 bg-red-600 rounded-full"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    fill-rule="evenodd"
                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                    clip-rule="evenodd"
                ></path>
            </svg>

            <svg
                v-else
                :class="{ 'bg-green-600': show }"
                class="z-10 w-10 h-10 p-2 text-white duration-100 bg-red-600 rounded-full"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    fill-rule="evenodd"
                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                    clip-rule="evenodd"
                ></path>
            </svg>
        </div>

        <img
            :style="[deleted ? { filter: 'grayscale(100%)' } : {}]"
            class="object-cover rounded-md shadow max-h-48"
            :src="poster"
        />
    </div>
</template>

<script>
export default {
    components: {},

    props: {
        movie: Object,
        deleted: Boolean,
    },

    data() {
        return {
            show: false,
            remove: false,
        };
    },

    computed: {
        poster() {
            if (this.movie.poster_path) {
                return (
                    "https://image.tmdb.org/t/p/w780" + this.movie.poster_path
                );
            }

            return "/images/placeholder.jpeg";
        },
    },
};
</script>
