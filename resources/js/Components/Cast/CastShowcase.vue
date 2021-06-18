<template>
    <div class="grid grid-cols-6 md:grid-cols-12 gap-2">
        <div v-for="cast in castMembers" :key="cast.id">
            <cast-image :cast="cast"></cast-image>
        </div>
    </div>
</template>

<script>
import CastImage from "@/Components/Cast/CastImage.vue";

export default {
    components: {
        CastImage,
    },

    props: {
        castMembers: Object,
    },
};
</script>
