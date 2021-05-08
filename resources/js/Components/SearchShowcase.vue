<template>
    <div class="text-white mb-2 text-sm font-medium break-all">
        {{ queryResultMessage }}
    </div>

    <div class="md:grid md:grid-cols-4">
        <div
            class="block overflow-hidden md:hidden bg-black-300 w-full rounded-md text-white mb-2"
        >
            <div class="bg-black-400 rounded-md m-2 p-2 flex justify-between">
                <span class="text-sm flex items-center">
                    <span class="font-medium"> Show results for </span>
                    <span class="font-bold ml-0.5">{{ type }}</span>
                </span>
                <span @click="showOptions = !showOptions">
                    <svg
                        v-if="!showOptions"
                        class="w-6 h-6 cursor-pointer"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 9l-7 7-7-7"
                        ></path>
                    </svg>
                    <svg
                        v-else
                        class="w-6 h-6 cursor-pointer"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        ></path>
                    </svg>
                </span>
            </div>

            <div v-if="showOptions" class="flex flex-col space-y-2 m-2 mt-4">
                <a
                    :href="route('search', query)"
                    class="px-3 py-2 rounded-md text-sm font-medium"
                    :class="
                        route().current('search', encodeURI(query))
                            ? 'bg-black-400 text-white'
                            : 'text-gray-300 hover:bg-black-200 hover:text-white'
                    "
                    >Movies</a
                >
                <a
                    :href="route('search.reviews', query)"
                    class="px-3 py-2 rounded-md text-sm font-medium"
                    :class="
                        route().current('search.reviews', encodeURI(query))
                            ? 'bg-black-400 text-white'
                            : 'text-gray-300 hover:bg-black-200 hover:text-white'
                    "
                    >Reviews</a
                >
                <a
                    :href="route('search.lists', query)"
                    class="px-3 py-2 rounded-md text-sm font-medium"
                    :class="
                        route().current('search.lists', encodeURI(query))
                            ? 'bg-black-400 text-white'
                            : 'text-gray-300 hover:bg-black-200 hover:text-white'
                    "
                    >Lists</a
                >
                <a
                    :href="route('search.members', query)"
                    class="px-3 py-2 rounded-md text-sm font-medium"
                    :class="
                        route().current('search.members', encodeURI(query))
                            ? 'bg-black-400 text-white'
                            : 'text-gray-300 hover:bg-black-200 hover:text-white'
                    "
                    >Members</a
                >
            </div>
        </div>

        <div class="col-span-3">
            <slot></slot>
        </div>

        <div
            class="hidden md:flex flex-col space-y-2 bg-black-300 rounded-md p-2 ml-2 h-64"
        >
            <div class="text-white px-2 text-sm font-medium">
                Show results for
            </div>
            <a
                :href="route('search', query)"
                class="px-3 py-2 rounded-md text-sm font-medium"
                :class="
                    route().current('search', encodeURI(query))
                        ? 'bg-black-400 text-white'
                        : 'text-gray-300 hover:bg-black-200 hover:text-white'
                "
                >Movies</a
            >
            <a
                :href="route('search.reviews', query)"
                class="px-3 py-2 rounded-md text-sm font-medium"
                :class="
                    route().current('search.reviews', encodeURI(query))
                        ? 'bg-black-400 text-white'
                        : 'text-gray-300 hover:bg-black-200 hover:text-white'
                "
                >Reviews</a
            >
            <a
                :href="route('search.lists', query)"
                class="px-3 py-2 rounded-md text-sm font-medium"
                :class="
                    route().current('search.lists', encodeURI(query))
                        ? 'bg-black-400 text-white'
                        : 'text-gray-300 hover:bg-black-200 hover:text-white'
                "
                >Lists</a
            >
            <a
                :href="route('search.members', query)"
                class="px-3 py-2 rounded-md text-sm font-medium"
                :class="
                    route().current('search.members', encodeURI(query))
                        ? 'bg-black-400 text-white'
                        : 'text-gray-300 hover:bg-black-200 hover:text-white'
                "
                >Members</a
            >
        </div>
    </div>
</template>

<script>
export default {
    props: {
        type: String,
        query: String,
        totalResults: Number,
    },

    data() {
        return {
            showOptions: false,
        };
    },

    computed: {
        queryResultMessage() {
            return `Found at least ${this.totalResults} matches for '${this.query}'`;
        },
    },
};
</script>
