<template>
    <div class="flex-1 mb-10 md:flex">
        <div class="flex-initial block md:mr-6">
            <div
                v-show="showSkeletonProfileImage"
                class="mx-auto rounded-md bg-black-300 h-96 w-72 animate-pulse"
            ></div>
            <img
                v-show="!showSkeletonProfileImage"
                class="mx-auto rounded-md shadow w-72"
                :src="profileImage"
                @load="showSkeletonProfileImage = false"
            />
        </div>
        <div class="relative flex flex-col flex-1 lg:flex-row">
            <div class="w-full p-1">
                <p
                    class="mt-1 text-3xl font-extrabold text-center text-white md:text-left"
                >
                    {{ cast.name }}
                </p>
                <div
                    class="flex flex-wrap mt-2 mb-3 text-sm text-center text-indigo-300 md:text-left gap-y-1"
                >
                    <span
                        v-if="cast.known_for_department"
                        class="movie-information-tag"
                    >
                        {{ cast.known_for_department }}
                    </span>
                    <span v-if="cast.birthday" class="movie-information-tag">
                        Born: {{ formatDate(cast.birthday) }}
                    </span>
                    <span v-if="cast.deathday" class="movie-information-tag">
                        Died: {{ formatDate(cast.deathday) }}
                    </span>
                    <span
                        v-if="cast.place_of_birth"
                        class="movie-information-tag"
                    >
                        {{ cast.place_of_birth }}
                    </span>
                </div>
                <div>
                    <p class="break-all whitespace-pre-wrap text-md text-black-100">
                        {{ cast.biography }}
                    </p>
                </div>
            </div>
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
            showSkeletonProfileImage: true,
        };
    },

    computed: {
        profileImage() {
            if (this.cast.profile_path) {
                return (
                    "https://image.tmdb.org/t/p/w780" + this.cast.profile_path
                );
            }

            return "/images/placeholder.jpeg";
        },
    },

    methods: {
        formatDate(castDate) {
            if (castDate === null) return "Unknown";

            const date = new Date(castDate);
            const month = date.toLocaleString("en", { month: "long" });
            const day = date.getDate();
            const year = date.getFullYear();

            return `${month} ${day}, ${year}`;
        },
    },
};
</script>
