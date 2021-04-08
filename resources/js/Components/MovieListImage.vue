<template>
    <div>
        <title-image :title="movie.title" :show="show" />

        <div
            v-if="border"
            @mouseenter="(show = true), (remove = true)"
            @mouseleave="(show = false), (remove = false)"
        >
            <img
                class="duration-100 rounded-sm border-2 hover:border-indigo-500"
                :src="poster"
            />
        </div>

        <div
            v-else
            @mouseenter="(show = true), (remove = true)"
            @mouseleave="(show = false), (remove = false)"
            class="relative"
        >
            <div
                v-show="remove"
                class="absolute w-full h-full flex justify-center items-center cursor-pointer"
                @click="$parent.$emit('remove-movie', movie.id)"
            >
                <svg
                    class="w-16 h-16 text-white bg-red-600 rounded-full p-5"
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
                class="duration-100 max-h-48 object-cover shadow rounded-md hover:border-2 hover:border-indigo-500"
                :src="poster"
            />
        </div>
    </div>
</template>

<script>
import TitleImage from "@/Components/TitleImage";

export default {
    components: {
        TitleImage,
    },

    props: {
        movie: Object,
        border: {
            default: true,
            type: Boolean,
        },
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
                    "https://image.tmdb.org/t/p/w300" + this.movie.poster_path
                );
            }

            return "/images/default_poster_path.png";
        },
    },
};
</script>
