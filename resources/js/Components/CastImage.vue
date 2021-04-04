<template>
    <div>
        <title-image :title="person.name" :show="show" />

        <a @mouseenter="show = true" @mouseleave="show = false" href="#">
            <img
                class="duration-100 rounded-sm border-2 hover:border-indigo-500"
                :src="profile"
            />
        </a>
    </div>
</template>

<script>
import TitleImage from "@/Components/TitleImage";

export default {
    components: {
        TitleImage,
    },

    props: {
        person: Object,
    },

    data() {
        return {
            show: false,
        };
    },

    computed: {
        profile() {
            if (this.person.profile_path) {
                return (
                    "https://image.tmdb.org/t/p/w185" + this.person.profile_path
                );
            }

            return "/images/default_profile_path.png";
        },
    },
};
</script>
