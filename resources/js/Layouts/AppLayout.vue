<template>
    <div class="flex flex-col justify-between min-h-screen">
        <div>
            <nav class="fixed z-10 w-full shadow bg-black-500">
                <div class="max-w-6xl px-2 mx-auto sm:px-6 lg:px-8">
                    <div
                        class="relative flex items-center justify-between h-13"
                    >
                        <div
                            class="absolute inset-y-0 left-0 flex items-center sm:hidden"
                        >
                            <!-- Mobile menu button-->
                            <button
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                type="button"
                                class="inline-flex items-center justify-center p-2 text-gray-400 rounded-md hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                                aria-controls="mobile-menu"
                                aria-expanded="false"
                            >
                                <span class="sr-only">Open main menu</span>
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
                        <div
                            class="flex items-center justify-center flex-1 sm:items-stretch sm:justify-start"
                        >
                            <div class="flex items-center flex-shrink-0">
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
                                                ? 'bg-black-300 text-white'
                                                : 'text-gray-300 hover:bg-black-200 hover:text-white'
                                        "
                                        >Movies</a
                                    >

                                    <a
                                        :href="route('lists')"
                                        class="px-3 py-2 text-sm font-medium rounded-md "
                                        :class="
                                            route().current('lists')
                                                ? 'bg-black-300 text-white'
                                                : 'text-gray-300 hover:bg-black-200 hover:text-white'
                                        "
                                        >Lists</a
                                    >
                                </div>
                            </div>

                            <search-bar></search-bar>
                        </div>
                        <div
                            class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0"
                        >
                            <a
                                v-if="$page.props.auth"
                                :href="
                                    route(
                                        'user.watched',
                                        $page.props.auth.username
                                    )
                                "
                                class="
                                    bg-black-300
                                    p-1
                                    rounded-full
                                    text-gray-400
                                    hover:text-white
                                    focus:outline-none
                                    focus:ring-2
                                    focus:ring-offset-2
                                    focus:ring-offset-gray-800
                                    focus:ring-white
                                    mr-1.5
                                "
                            >
                                <svg
                                    class="w-6 h-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                    ></path>
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                    ></path>
                                </svg>
                            </a>

                            <a
                                v-if="$page.props.auth"
                                :href="
                                    route(
                                        'user.likes.movies',
                                        $page.props.auth.username
                                    )
                                "
                                class="p-1 text-gray-400 rounded-full bg-black-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
                            >
                                <svg
                                    class="w-6 h-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                                    ></path>
                                </svg>
                            </a>

                            <!-- Profile dropdown -->
                            <div class="relative ml-3">
                                <dropdown
                                    :showingMenuDropdown="showingMenuDropdown"
                                />
                            </div>

                            <div
                                v-if="!$page.props.auth"
                                class="flex space-x-2 text-white"
                            >
                                <a
                                    :href="route('login')"
                                    class="px-2 py-1 text-sm font-medium text-white rounded-md bg-black-300 hover:bg-black-200"
                                    >Log in</a
                                >
                                <a
                                    :href="route('register')"
                                    class="px-2 py-1 text-sm font-medium text-white rounded-md bg-black-300 hover:bg-black-200"
                                    >Sign up</a
                                >
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
                                    ? 'bg-black-300 text-white'
                                    : 'text-gray-300 hover:bg-black-200 hover:text-white'
                            "
                            >Movies</a
                        >

                        <a
                            :href="route('lists')"
                            class="block px-3 py-2 text-base font-medium rounded-md "
                            :class="
                                route().current('lists')
                                    ? 'bg-black-300 text-white'
                                    : 'text-gray-300 hover:bg-black-200 hover:text-white'
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
