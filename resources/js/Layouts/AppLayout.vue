<template>
    <div>
        <nav class="bg-black-500 z-10 shadow fixed w-full">
            <div class="max-w-6xl mx-auto px-2 sm:px-6 lg:px-8">
                <div class="relative flex items-center justify-between h-13">
                    <div
                        class="
                            absolute
                            inset-y-0
                            left-0
                            flex
                            items-center
                            sm:hidden
                        "
                    >
                        <!-- Mobile menu button-->
                        <button
                            @click="
                                showingNavigationDropdown =
                                    !showingNavigationDropdown
                            "
                            type="button"
                            class="
                                inline-flex
                                items-center
                                justify-center
                                p-2
                                rounded-md
                                text-gray-400
                                hover:text-white
                                hover:bg-gray-700
                                focus:outline-none
                                focus:ring-2 focus:ring-inset focus:ring-white
                            "
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
                        class="
                            flex-1 flex
                            items-center
                            justify-center
                            sm:items-stretch
                            sm:justify-start
                        "
                    >
                        <div class="flex-shrink-0 flex items-center">
                            <a :href="route('home')">
                                <div
                                    v-show="showSkeletonLogo"
                                    class="
                                        block
                                        lg:hidden
                                        bg-black-400
                                        h-9
                                        w-10
                                        animate-pulse
                                        rounded
                                    "
                                ></div>
                                <div
                                    v-show="showSkeletonLogo"
                                    class="
                                        hidden
                                        lg:block
                                        bg-black-400
                                        h-9
                                        w-24
                                        animate-pulse
                                        rounded
                                    "
                                ></div>
                                <img
                                    v-show="!showSkeletonLogo"
                                    class="block lg:hidden h-9 w-auto"
                                    src="/images/logo.svg"
                                    alt="Livila"
                                    @load="showSkeletonLogo = false"
                                />
                                <img
                                    v-show="!showSkeletonLogo"
                                    class="hidden lg:block h-9 w-auto"
                                    src="/images/logo-text.svg"
                                    alt="Livila"
                                    @load="showSkeletonLogo = false"
                                />
                            </a>
                        </div>
                        <div class="hidden sm:block sm:ml-6 mr-2">
                            <div class="flex space-x-4">
                                <a
                                    :href="route('movies')"
                                    class="
                                        px-3
                                        py-2
                                        rounded-md
                                        text-sm
                                        font-medium
                                    "
                                    :class="
                                        route().current('movies')
                                            ? 'bg-black-300 text-white'
                                            : 'text-gray-300 hover:bg-black-200 hover:text-white'
                                    "
                                    >Movies</a
                                >

                                <a
                                    :href="route('lists')"
                                    class="
                                        px-3
                                        py-2
                                        rounded-md
                                        text-sm
                                        font-medium
                                    "
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
                                class="
                                    w-full
                                    text-white
                                    bg-black-300
                                    border-0
                                    rounded-md
                                    h-9
                                    focus:ring-indigo-500
                                    pr-10
                                "
                                placeholder="Search"
                                v-model="searchText"
                                @keypress.enter="searchQuery()"
                                @focus="showSearchSuggestion = true"
                                @blur="closeSearchSuggestion()"
                            />
                            <div @click="searchQuery()">
                                <svg
                                    class="
                                        w-8
                                        h-8
                                        absolute
                                        text-black-100
                                        top-0.5
                                        right-0.5
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

                            <div
                                v-show="
                                    showSearchSuggestion && !searchText.length
                                "
                                class="
                                    bg-black-500
                                    shadow
                                    mx-auto
                                    hidden
                                    sm:block
                                    sm:w-full
                                    absolute
                                    rounded-b-md
                                    space-y-1
                                    mt-0.5
                                "
                            >
                                <div
                                    v-for="(
                                        suggestion, index
                                    ) in searchSuggestion"
                                    :key="index"
                                    class="
                                        text-white
                                        py-2
                                        px-3
                                        hover:bg-black-300
                                        rounded-md
                                        cursor-pointer
                                        flex
                                        items-center
                                    "
                                    @click="searchQuerySuggested(suggestion)"
                                >
                                    <span>
                                        <svg
                                            class="w-4 h-4 text-indigo-500 mr-2"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                            ></path>
                                        </svg>
                                    </span>
                                    <span class="truncate">
                                        {{ suggestion }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="
                            absolute
                            inset-y-0
                            right-0
                            flex
                            items-center
                            pr-2
                            sm:static
                            sm:inset-auto
                            sm:ml-6
                            sm:pr-0
                        "
                    >
                        <a
                            v-if="$page.props.auth"
                            :href="
                                route('user.watched', $page.props.auth.username)
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
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"
                                ></path>
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
                                class="
                                    px-2
                                    py-1
                                    rounded-md
                                    text-sm
                                    font-medium
                                    bg-black-300
                                    text-white
                                    hover:bg-black-200
                                "
                                >Log in</a
                            >
                            <a
                                :href="route('register')"
                                class="
                                    px-2
                                    py-1
                                    rounded-md
                                    text-sm
                                    font-medium
                                    bg-black-300
                                    text-white
                                    hover:bg-black-200
                                "
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
                        class="
                            w-full
                            text-white
                            bg-black-300
                            border-0
                            rounded-md
                            h-9
                            focus:ring-indigo-500
                            pr-10
                        "
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
        <main class="pt-10">
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
            showSkeletonLogo: true,
            showSearchSuggestion: false,
        };
    },

    computed: {
        searchSuggestion() {
            let suggestions = this.getSearchSuggestionHistory();

            if (suggestions) {
                return suggestions.suggestions;
            }

            return [];
        },
    },

    methods: {
        closeSearchSuggestion() {
            setTimeout(() => (this.showSearchSuggestion = false), 500);
        },

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

            this.saveSearchSuggestionHistory(this.searchText.trim());

            this.$inertia.visit(route("search", this.searchText.trim()));
        },

        searchQuerySuggested(query) {
            this.$inertia.visit(route("search", query.trim()));
        },

        getSearchSuggestionHistory() {
            return JSON.parse(localStorage.getItem("SearchSuggestionHistory"));
        },

        saveSearchSuggestionHistory(text) {
            let data = this.getSearchSuggestionHistory();
            let suggestions = { suggestions: [] };

            if (data === null) {
                suggestions = { suggestions: [text] };
            } else {
                data.suggestions = data.suggestions.filter(
                    (item) => item.toLowerCase() !== text.toLowerCase()
                );

                data.suggestions.unshift(text);
                data.suggestions = data.suggestions.slice(0, 5);

                suggestions = data;
            }

            localStorage.setItem(
                "SearchSuggestionHistory",
                JSON.stringify(suggestions)
            );
        },
    },
};
</script>
