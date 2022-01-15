<template>
    <div class="flex flex-col justify-between h-full pb-4 mb-1">
        <div
            class="relative"
            @mouseenter="show = true"
            @mouseleave="show = false"
        >
            <transition
                enter-active-class="transition duration-150 ease-out"
                enter-from-class="transform scale-105 opacity-0"
                enter-to-class="transform scale-100 opacity-100"
                leave-active-class="transition duration-100 ease-in"
                leave-from-class="transform opacity-100"
                leave-to-class="transform opacity-0"
            >
                <a
                    v-show="show"
                    :href="route('cast.show', cast.id)"
                    class="absolute w-full h-full rounded cursor-pointer bg-black-400 bg-opacity-70"
                    :class="[show ? 'border-2 border-indigo-500' : '']"
                ></a>
            </transition>
            <img
                v-show="showSkeletonImage"
                class="w-full rounded shadow animate-pulse"
                src="/images/placeholder.jpeg"
            />
            <img
                v-show="!showSkeletonImage"
                class="w-full rounded shadow"
                :class="{ hidden: showSkeletonImage }"
                :src="image"
                @load="showSkeletonImage = false"
            />
        </div>
        <div>
            <p
                :title="cast.name"
                class="text-xs text-white truncate sm:text-sm"
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

            return "/images/placeholder.jpeg";
        },
    },

    methods: {},
};
</script>
