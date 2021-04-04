<template>
    <div
        v-if="all"
        class="grid grid-cols-5 sm:grid-cols-8 md:grid-cols-10 gap-2"
    >
        <div v-for="person in cast" :key="person.id">
            <cast-image :person="person" />
        </div>
    </div>

    <div v-else class="my-2">
        <div class="md:hidden grid grid-cols-6 gap-2">
            <div v-for="person in cast.slice(0, 6)" :key="person.id">
                <cast-image :person="person" />
            </div>
        </div>

        <div class="hidden md:grid grid-flow-col gap-2">
            <div v-for="person in cast.slice(0, 11)" :key="person.id">
                <cast-image :person="person" />
            </div>
        </div>
    </div>
</template>

<script>
import CastImage from "@/Components/CastImage.vue";

export default {
    components: {
        CastImage,
    },

    props: {
        cast: Object,
        all: {
            type: Boolean,
            default: true,
        },
    },

    computed: {},

    methods: {},
};
</script>
