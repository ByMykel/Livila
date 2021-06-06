<template>
    <div class="md:flex flex-1 mb-10">
        <div class="block md:mr-6 flex-initial">
            <div
                v-show="showSkeletonProfileImage"
                class="bg-black-300 h-96 rounded-md mx-auto w-72 animate-pulse"
            ></div>
            <img
                v-show="!showSkeletonProfileImage"
                class="shadow rounded-md mx-auto w-72"
                :src="profileImage"
                @load="showSkeletonProfileImage = false"
            />
        </div>
        <div class="flex flex-col lg:flex-row flex-1 relative">
            <div class="w-full p-1">
                <p
                    class="text-center md:text-left mt-1 text-3xl font-extrabold text-white"
                >
                    {{ cast.name }}
                </p>
                <div
                    class="text-center md:text-left mt-2 mb-3 text-sm text-indigo-300 flex flex-wrap gap-y-1"
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
                    <p class="text-md text-black-100 break-all whitespace-pre-wrap">
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

            return "/images/default_profile_path.png";
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
