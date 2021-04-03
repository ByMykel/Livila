<template>
    <div v-if="all" class="grid grid-cols-5 sm:grid-cols-8 md:grid-cols-10 gap-2">
        <div v-for="person in cast" :key="person.id">
            <a href="#">
                <img
                    class="duration-100 max-h-48 object-cover shadow rounded-md hover:border-2 hover:border-indigo-500"
                    :src="profile(person)"
                />
            </a>
        </div>
    </div>

    <div v-else class="my-2">
        <div class="md:hidden grid grid-cols-6 gap-2">
            <div v-for="person in cast.slice(0, 6)" :key="person.id">
                <a href="#">
                    <img
                        class="duration-100 rounded-sm border-2 hover:border-indigo-500"
                        :src="profile(person)"
                    />
                </a>
            </div>
        </div>

        <div class="hidden md:grid grid-flow-col gap-2">
            <div v-for="person in cast.slice(0, 11)" :key="person.id">
                <a href="#">
                    <img
                        class="duration-100 w-52 rounded-sm border-2 hover:border-indigo-500"
                        :src="profile(person)"
                    />
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    components: {},

    props: {
        cast: Object,
        all: {
            type: Boolean,
            default: true
        }
    },

    computed: {},

    methods: {
        profile(person) {
            if (person.profile_path) {
                return (
                    "https://image.tmdb.org/t/p/w185" + person.profile_path
                );
            }

            return "/images/default_profile_path.png";
        },
    },
};
</script>
