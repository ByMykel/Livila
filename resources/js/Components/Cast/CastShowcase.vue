<template>
    <div class="grid w-full gap-2 mx-auto cast-grid-small md:cast-grid">
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
