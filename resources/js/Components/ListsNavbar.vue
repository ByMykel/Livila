<template>
    <div class="mt-5 mb-2 text-black-100 flex px-1 font-semibold text-base">
        <a
            :href="route('lists')"
            class="hover:border-b-2 hover:text-white px-3 border-black-100"
            :class="{
                'text-white border-indigo-600 border-b-2': selected === 1,
            }"
            >Recent</a
        >
        <a
            :href="route('lists.popular')"
            class="hover:border-b-2 hover:text-white px-3 border-black-100"
            :class="{
                'text-white border-indigo-600 border-b-2': selected === 2,
            }"
            >Popular</a
        >
        <a
            v-if="$page.props.auth"
            :href="route('lists.friends')"
            class="hover:border-b-2 hover:text-white px-3 border-black-100"
            :class="{
                'text-white border-indigo-600 border-b-2': selected === 3,
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