<template>
    <div class="my-5 bg-gray-900 rounded-md shadow relative">
        <div class="text-white text-base font-semibold px-3 py-2">
            <p class="uppercase hover:text-indigo-400">
                <a v-if="url" :href="url">
                    {{ title }}
                </a>

                <span v-else>{{ title }}</span>
            </p>

            <p class="text-gray-400">
                {{ description }}
            </p>
        </div>
        <div class="border-t border-gray-400"></div>
        <div class="py-1 px-3">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    components: {},

    props: {
        title: String,
        description: String,
        url: {
            type: String,
            defalt: "",
        },
    },

    computed: {},

    methods: {},
};
</script>
