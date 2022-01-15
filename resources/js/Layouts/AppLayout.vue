<template>
    <div class="flex flex-col justify-between min-h-screen">
        <div>
            <nav class="fixed z-10 w-full shadow bg-black-500">
                <div class="max-w-6xl px-0 mx-auto sm:px-6 lg:px-8">
                    <div
                        class="relative flex items-center justify-between h-12"
                    >
                        <div
                            class="flex items-center flex-1 sm:items-stretch sm:justify-start"
                        >
                            <div class="flex items-center flex-shrink-0 ml-5">
                                <a :href="route('home')">
                                    <div
                                        v-show="showSkeletonLogo"
                                        class="block w-10 rounded lg:hidden bg-black-400 h-9 animate-pulse"
                                    ></div>
                                    <div
                                        v-show="showSkeletonLogo"
                                        class="hidden w-24 rounded lg:block bg-black-400 h-9 animate-pulse"
                                    ></div>
                                    <img
                                        v-show="!showSkeletonLogo"
                                        class="block w-auto lg:hidden h-9"
                                        src="/images/logo.svg"
                                        alt="Livila"
                                        @load="showSkeletonLogo = false"
                                    />
                                    <img
                                        v-show="!showSkeletonLogo"
                                        class="hidden w-auto lg:block h-9"
                                        src="/images/logo-text.svg"
                                        alt="Livila"
                                        @load="showSkeletonLogo = false"
                                    />
                                </a>
                            </div>
                            <div
                                class="items-center hidden mr-2 sm:flex sm:ml-6"
                            >
                                <div class="flex space-x-4">
                                    <a
                                        :href="route('movies')"
                                        class="px-3 py-2 text-sm font-medium rounded-md "
                                        :class="
                                            route().current('movies')
                                                ? 'bg-black-400 text-white'
                                                : 'text-gray-300 hover:bg-black-400 hover:text-white'
                                        "
                                        >Movies</a
                                    >

                                    <a
                                        :href="route('lists')"
                                        class="px-3 py-2 text-sm font-medium rounded-md "
                                        :class="
                                            route().current('lists')
                                                ? 'bg-black-400 text-white'
                                                : 'text-gray-300 hover:bg-black-400 hover:text-white'
                                        "
                                        >Lists</a
                                    >
                                </div>
                            </div>

                            <search-bar></search-bar>
                        </div>
                        <div class="flex items-center h-full">
                            <div
                                class="flex items-center h-full py-1 pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0"
                            >
                                <!-- Profile dropdown -->
                                <div class="relative ml-3">
                                    <dropdown
                                        :showingMenuDropdown="
                                            showingMenuDropdown
                                        "
                                    />
                                </div>

                                <div
                                    v-if="!$page.props.auth"
                                    class="flex space-x-2 text-white"
                                >
                                    <a
                                        :href="route('login')"
                                        class="flex items-center px-2 py-2 text-sm font-medium text-gray-300 rounded-md hover:bg-black-400 hover:text-white"
                                        >Sign In</a
                                    >
                                    <a
                                        :href="route('register')"
                                        class="flex items-center px-2 py-2 text-sm font-medium text-gray-300 rounded-md bg-black-400 hover:bg-black-400 hover:text-white"
                                        >Sign Up</a
                                    >
                                </div>
                            </div>

                            <div
                                class="flex items-center sm:hidden h-full px-0.5 border-l border-black-400"
                                :class="{ 'border-black-500' : showingNavigationDropdown }"
                            >
                                <!-- Mobile menu button-->
                                <button
                                    @click="
                                        showingNavigationDropdown =
                                            !showingNavigationDropdown
                                    "
                                    type="button"
                                    class="inline-flex items-center justify-center p-2 text-gray-300 rounded-md hover:text-white focus:outline-none"
                                >
                                    <svg
                                        class="w-6 h-6"
                                        :class="
                                            showingNavigationDropdown
                                                ? 'hidden'
                                                : 'block'
                                        "
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h16"
                                        />
                                    </svg>
                                    <svg
                                        class="w-6 h-6"
                                        :class="
                                            showingNavigationDropdown
                                                ? 'block'
                                                : 'hidden'
                                        "
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile menu, show/hide based on menu state. -->
                <div
                    v-if="showingNavigationDropdown"
                    class="sm:hidden"
                    id="mobile-menu"
                >
                    <div class="relative block px-2 pt-2 sm:w-2/5">
                        <input
                            type="text"
                            class="w-full pr-10 text-white border-0 rounded-md bg-black-300 h-9 focus:ring-indigo-500"
                            placeholder="Search"
                            v-model="searchText"
                            @keypress.enter="searchQuery()"
                        />
                        <div @click="searchQuery()">
                            <svg
                                class="
                                    w-8
                                    h-8
                                    absolute
                                    text-black-100
                                    top-2.5
                                    right-2.5
                                    hover:bg-black-200
                                    rounded-md
                                    p-1
                                    cursor-pointer
                                "
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                ></path>
                            </svg>
                        </div>
                    </div>
                    <div class="px-2 pt-2 pb-3 space-y-1">
                        <a
                            :href="route('movies')"
                            class="block px-3 py-2 text-base font-medium rounded-md "
                            :class="
                                route().current('movies')
                                    ? 'bg-black-400 text-white'
                                    : 'text-gray-300 hover:bg-black-400 hover:text-white'
                            "
                            >Movies</a
                        >

                        <a
                            :href="route('lists')"
                            class="block px-3 py-2 text-base font-medium rounded-md "
                            :class="
                                route().current('lists')
                                    ? 'bg-black-400 text-white'
                                    : 'text-gray-300 hover:bg-black-400 hover:text-white'
                            "
                            >Lists</a
                        >
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="pt-10">
                <slot></slot>
            </main>
        </div>

        <div class="w-full h-24 max-w-6xl px-1 mx-auto mt-10 sm:px-6 lg:px-8">
            <div class="flex justify-between">
                <!-- <h1>Livila made by ByMykel</h1> -->
                <img class="h-8" src="/images/logo-text.svg" />
                <span class="flex items-center justify-center h-8">
                    <a href="https://github.com/ByMykel/Livila" target="_blank">
                        <img
                            class="h-6 hover:opacity-60"
                            src="/images/GitHub-Mark-Light-64px.png"
                        />
                    </a>
                </span>
            </div>
            <div class="pt-4 text-sm sm:text-base text-black-100">
                This product uses the
                <a
                    class="underline hover:text-indigo-400"
                    href="https://developers.themoviedb.org/3/getting-started/introduction"
                    target="_blank"
                    >TMDb API</a
                >
                but is not endorsed or certified by
                <a
                    class="underline hover:text-indigo-400"
                    href="https://www.themoviedb.org/"
                    target="_blank"
                    >TMDb</a
                >.
                <a
                    class="underline hover:text-indigo-400"
                    :href="route('about.movies-data')"
                    target="_blank"
                    >Read more</a
                >.
            </div>
        </div>
    </div>
</template>

<script>
import Dropdown from "@/Components/Dropdown";
import SearchBar from "@/Components/SearchBar";

export default {
    components: {
        Dropdown,
        SearchBar,
    },

    data() {
        return {
            showingNavigationDropdown: false,
            showingMenuDropdown: false,
            searchText: "",
            showSkeletonLogo: true,
        };
    },

    methods: {
        searchQuery() {
            if (!this.searchText.trim().length) return;

            if (this.route().current("search.reviews")) {
                this.$inertia.visit(
                    route("search.reviews", this.searchText.trim())
                );
                return;
            }

            if (this.route().current("search.lists")) {
                this.$inertia.visit(
                    route("search.lists", this.searchText.trim())
                );
                return;
            }

            if (this.route().current("search.members")) {
                this.$inertia.visit(
                    route("search.members", this.searchText.trim())
                );
                return;
            }

            this.$inertia.visit(route("search", this.searchText.trim()));
        },
    },
};
</script>
