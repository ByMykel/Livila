<template>
    <div class="border-b border-black-300 mt-5 mb-5 text-black-100 flex px-1">
        <a
            :href="route('lists')"
            class="hover:border-b hover:text-white px-3 border-black-100"
            :class="{
                'text-white border-indigo-600 border-b': selected === 1,
            }"
            >Recent</a
        >
        <a
            :href="route('lists.popular')"
            class="hover:border-b hover:text-white px-3 border-black-100"
            :class="{
                'text-white border-indigo-600 border-b': selected === 2,
            }"
            >Popular</a
        >
        <a
            :href="route('lists.friends')"
            class="hover:border-b hover:text-white px-3 border-black-100"
            :class="{
                'text-white border-indigo-600 border-b': selected === 3,
            }"
            >Friends</a
        >
    </div>
</template>

<script>
export default {
    props: {
        selected: Number,
    },
};
</script>