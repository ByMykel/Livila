<template>
    <div
        ref="showSuggestions"
        class="relative hidden p-1 mx-auto sm:block sm:w-2/4"
        :class="{ 'bg-black-300 rounded-t-md': showSearchSuggestion }"
    >
        <input
            type="text"
            class="w-full pr-10 text-white border-0 rounded-md bg-black-300 h-9 focus:ring-indigo-500"
            :class="{ 'bg-black-500': showSearchSuggestion }"
            placeholder="Search"
            v-model="searchText"
            @keypress.enter="searchQuery()"
            @focus="showSearchSuggestion = true"
        />
        <div @click="searchQuery()">
            <svg
                class="
                    w-8
                    h-8
                    absolute
                    text-black-100
                    top-1.5
                    right-1.5
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
            v-show="showSearchSuggestion"
            class="
                bg-black-300
                shadow-md
                mx-auto
                hidden
                sm:block
                sm:w-full
                absolute
                left-0
                rounded-b-md
                space-y-1
                p-1
                mt-0.5
            "
        >
            <div v-if="!searchText.length">
                <div
                    v-for="(suggestion, index) in searchSuggestion"
                    :key="index"
                    class="flex items-center px-3 py-2 text-white rounded-md cursor-pointer hover:bg-black-200"
                    @click="searchQuerySuggested(suggestion)"
                >
                    <span>
                        <svg
                            class="w-4 h-4 mr-2 text-indigo-500"
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
            <div v-else>
                <div v-if="!loadingSuggestedMovies">
                    <a
                        v-for="(movie, index) in suggestedMovies"
                        :key="index"
                        class="flex items-center px-3 py-2 text-white rounded-md cursor-pointer hover:bg-black-200"
                        :href="route('movies.show', movie.id)"
                    >
                        <span>
                            <svg
                                class="w-4 h-4 mr-2 text-indigo-500"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"
                                ></path>
                            </svg>
                        </span>
                        <span class="truncate">
                            {{ movie.title }}
                        </span>
                    </a>
                </div>
                <div v-else>
                    <div
                        class="flex items-center px-3 py-2 text-white rounded-md cursor-pointer bg-black-200 animate-pulse"
                    >
                        <span>
                            <svg
                                class="w-4 h-4 mr-2 text-indigo-500"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"
                                ></path>
                            </svg>
                        </span>
                        <span class="truncate"> loading... </span>
                    </div>
                </div>
                <div
                    class="flex items-center px-3 py-2 text-white rounded-md cursor-pointer hover:bg-black-200"
                    @click="searchQuery()"
                >
                    <span>
                        <svg
                            class="w-4 h-4 mr-2 text-black-100"
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
                    </span>
                    <span> Search {{ searchText }} </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            searchText: "",
            showSearchSuggestion: false,
            suggestedMovies: [],
            loadingSuggestedMovies: false,
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

    mounted() {
        document.addEventListener("click", this.onClickOutside);
    },

    watch: {
        searchText(value) {
            if (!value) {
                this.suggestedMovies = [];
                return;
            }

            if (!this.loadingSuggestedMovies) {
                this.loadingSuggestedMovies = true;
                
                setTimeout(() => {
                    this.getSuggestedMovies();
                    this.loadingSuggestedMovies = false;
                }, 200);
            }
        },
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

        onClickOutside(event) {
            const { showSuggestions } = this.$refs;
            if (!showSuggestions || showSuggestions.contains(event.target))
                return;
            this.showSearchSuggestion = false;
        },

        getSuggestedMovies() {
            if (!this.searchText) return;

            return axios
                .get(route("search.suggested.movies", this.searchText))
                .then((res) => {
                    this.suggestedMovies = res.data;
                });
        },
    },
};
</script>