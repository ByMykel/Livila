<template>
    <div>
        <nav class="bg-black-500 relative z-10 shadow">
            <div class="max-w-6xl mx-auto px-2 sm:px-6 lg:px-8">
                <div class="relative flex items-center justify-between h-16">
                    <div
                        class="absolute inset-y-0 left-0 flex items-center sm:hidden"
                    >
                        <!-- Mobile menu button-->
                        <button
                            @click="
                                showingNavigationDropdown = !showingNavigationDropdown
                            "
                            type="button"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                            aria-controls="mobile-menu"
                            aria-expanded="false"
                        >
                            <span class="sr-only">Open main menu</span>
                            <svg
                                class="h-6 w-6"
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
                                class="h-6 w-6"
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
                        class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start"
                    >
                        <div class="flex-shrink-0 flex items-center">
                            <img
                                class="block lg:hidden h-8 w-auto"
                                src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg"
                                alt="Workflow"
                            />
                            <img
                                class="hidden lg:block h-8 w-auto"
                                src="https://tailwindui.com/img/logos/workflow-logo-indigo-500-mark-white-text.svg"
                                alt="Workflow"
                            />
                        </div>
                        <div class="hidden sm:block sm:ml-6 mr-2">
                            <div class="flex space-x-4">
                                <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                                <a
                                    :href="route('home')"
                                    class="px-3 py-2 rounded-md text-sm font-medium"
                                    :class="
                                        route().current('home')
                                            ? 'bg-black-300 text-white'
                                            : 'text-gray-300 hover:bg-black-200 hover:text-white'
                                    "
                                    aria-current="page"
                                    >Home</a
                                >

                                <a
                                    :href="route('movies')"
                                    class="px-3 py-2 rounded-md text-sm font-medium"
                                    :class="
                                        route().current('movies')
                                            ? 'bg-black-300 text-white'
                                            : 'text-gray-300 hover:bg-black-200 hover:text-white'
                                    "
                                    >Movies</a
                                >

                                <a
                                    :href="route('lists')"
                                    class="px-3 py-2 rounded-md text-sm font-medium"
                                    :class="
                                        route().current('lists')
                                            ? 'bg-black-300 text-white'
                                            : 'text-gray-300 hover:bg-black-200 hover:text-white'
                                    "
                                    >Lists</a
                                >
                            </div>
                        </div>
                        <div class="mx-auto hidden sm:block sm:w-2/4 relative">
                            <input
                                type="text"
                                class="w-full text-white bg-black-300 border-0 rounded-md h-9 focus:ring-indigo-500 pr-10"
                                placeholder="Search"
                                v-model="searchText"
                                @keypress.enter="searchQuery()"
                            />
                            <div @click="searchQuery()">
                                <svg
                                    class="w-8 h-8 absolute text-black-100 top-0.5 right-0.5 hover:bg-black-200 rounded-md p-1 cursor-pointer"
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
                    </div>
                    <div
                        class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0"
                    >
                        <a
                            v-if="$page.props.auth"
                            :href="route('activity')"
                            class="bg-black-300 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
                        >
                            <span class="sr-only">View notifications</span>
                            <svg
                                class="h-6 w-6"
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
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"
                                />
                            </svg>
                        </a>

                        <!-- Profile dropdown -->
                        <div class="ml-3 relative">
                            <dropdown
                                :showingMenuDropdown="showingMenuDropdown"
                            />
                        </div>

                        <div
                            v-if="!$page.props.auth"
                            class="text-white flex space-x-2"
                        >
                            <a
                                :href="route('login')"
                                class="px-3 py-2 rounded-md text-sm font-medium bg-black-300 text-white hover:bg-black-200"
                                >Log in</a
                            >
                            <a
                                :href="route('register')"
                                class="px-3 py-2 rounded-md text-sm font-medium bg-black-300 text-white hover:bg-black-200"
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
                <div class="block sm:w-2/5 relative px-2 pt-2">
                    <input
                        type="text"
                        class="w-full text-white bg-black-300 border-0 rounded-md h-9 focus:ring-indigo-500 pr-10"
                        placeholder="Search"
                        v-model="searchText"
                        @keypress.enter="searchQuery()"
                    />
                    <div @click="searchQuery()">
                        <svg
                            class="w-8 h-8 absolute text-black-100 top-2.5 right-2.5 hover:bg-black-200 rounded-md p-1 cursor-pointer"
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
                    <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                    <a
                        :href="route('home')"
                        class="block px-3 py-2 rounded-md text-base font-medium"
                        :class="
                            route().current('home')
                                ? 'bg-black-300 text-white'
                                : 'text-gray-300 hover:bg-black-200 hover:text-white'
                        "
                        aria-current="page"
                        >Home</a
                    >

                    <a
                        :href="route('movies')"
                        class="block px-3 py-2 rounded-md text-base font-medium"
                        :class="
                            route().current('movies')
                                ? 'bg-black-300 text-white'
                                : 'text-gray-300 hover:bg-black-200 hover:text-white'
                        "
                        >Movies</a
                    >

                    <a
                        :href="route('lists')"
                        class="block px-3 py-2 rounded-md text-base font-medium"
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
        <main>
            <slot></slot>
        </main>
    </div>
</template>

<script>
import Dropdown from "@/Components/Dropdown";

export default {
    components: {
        Dropdown,
    },

    data() {
        return {
            showingNavigationDropdown: false,
            showingMenuDropdown: false,
            searchText: "",
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
