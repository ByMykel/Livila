<template>
    <div class="mb-1 pb-4 flex flex-col justify-between h-full">
        <div
            class="relative"
            @mouseenter="show = true"
            @mouseleave="show = false"
        >
            <transition
                enter-active-class="transition ease-out duration-150"
                enter-from-class="transform opacity-0 scale-105"
                enter-to-class="transform opacity-100 scale-100"
                leave-active-class="transition ease-in duration-100"
                leave-from-class="transform opacity-100"
                leave-to-class="transform opacity-0"
            >
                <a
                    v-show="show"
                    :href="route('cast.show', cast.id)"
                    class="absolute w-full h-full cursor-pointer bg-black-400 bg-opacity-70 rounded"
                    :class="[show ? 'border-2 border-indigo-500' : '']"
                ></a>
            </transition>
            <div
                v-show="showSkeletonImage"
                class="bg-black-300 h-44 w-full shadow rounded animate-pulse"
            ></div>
            <img
                v-show="!showSkeletonImage"
                class="max-h-48 w-full shadow rounded"
                :src="image"
                @load="showSkeletonImage = false"
            />
        </div>
        <div>
            <p
                :title="cast.name"
                class="truncate text-white text-sm font-semibold"
            >
                {{ cast.name }}
            </p>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        cast: Object,
    },

    data() {
        return {
            show: false,
            showSkeletonImage: true,
        };
    },

    computed: {
        image() {
            if (this.cast.profile_path) {
                return (
                    "https://image.tmdb.org/t/p/w500" + this.cast.profile_path
                );
            }

            return "/images/default_poster_path.png";
        },
    },

    methods: {},
};
</script>
