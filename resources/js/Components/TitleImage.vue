<template>
    <div class="relative">
        <transition
            enter-active-class="transition ease-out duration-100"
            leave-active-class="transition ease-in duration-75"
            enter-class="transform opacity-0 -translate-y-6"
            enter-to-class="transform opacity-100 translate-y-0"
            leave-class="transform opacity-100 translate-y-0"
            leave-to-class="transform opacity-0 -translate-y-2"
        >
            <div
                v-show="show"
                class="bg-gray-900 border border-indigo-500 text-white py-0.5 px-2 rounded-t-md rounded-br-md text-xs font-medium absolute -top-6 w-max"
            >
                {{ title }}
            </div>
        </transition>
    </div>
</template>

<script>
export default {
    props: {
        title: String,
        show: Boolean,
    },
};
</script>
