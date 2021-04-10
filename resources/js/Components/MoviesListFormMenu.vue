<template>
    <div class="mt-5 md:mt-0 md:col-span-2 relative">
        <form v-if="creating" @submit.prevent="createList">
            <div class="shadow rounded-md overflow-hidden">
                <div class="px-4 py-5 bg-gray-900 space-y-6 sm:p-6">
                    <div class="col-span-6">
                        <label
                            for="list_name"
                            class="block text-sm font-medium text-white"
                            >Name of list</label
                        >
                        <input
                            type="text"
                            name="list_name"
                            id="list_name"
                            class="text-black mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            v-model="form.name"
                            autocomplete="off"
                        />
                    </div>
                    <div>
                        <label
                            for="description"
                            class="block text-sm font-medium text-white"
                        >
                            Description
                        </label>
                        <div class="mt-1">
                            <textarea
                                id="description"
                                name="description"
                                rows="5"
                                class="text-black disabled:opacity-50 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md"
                                placeholder="Add a decription..."
                                v-model="form.description"
                            ></textarea>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                            Please describe what kind of movies this list
                            contains.
                        </p>
                    </div>
                </div>

                <div class="bg-gray-900 space-y-6 sm:px-6 px-4 pb-4">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input
                                id="visibility"
                                name="visibility"
                                type="checkbox"
                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
                                v-model="form.visibility"
                            />
                        </div>
                        <div class="ml-3 text-sm">
                            <label
                                for="visibility"
                                class="font-medium text-white"
                                >Public list</label
                            >
                            <p class="text-gray-500">
                                Make this list visible to others.
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="px-4 py-3 bg-gray-800 text-right rounded-md sm:px-6 flex justify-end"
                >
                    <div>
                        <button
                            @click="cancel()"
                            type="button"
                            class="mr-2 inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            <svg
                                class="sm:-ml-1 sm:mr-2 h-5 w-5"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                            <span class="hidden sm:block">Return</span>
                        </button>

                        <button
                            type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            <svg
                                class="sm:-ml-1 sm:mr-2 h-5 w-5"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span class="hidden sm:block">Publish</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <div v-else class="shadow rounded-md overflow-hidden">
            <div class="px-4 py-5 bg-gray-900 space-y-6 sm:p-6">
                <div class="col-span-6">
                    <label
                        for="list_name"
                        class="block text-sm font-medium text-white"
                        >Name of list</label
                    >
                    <input
                        type="text"
                        name="list_name"
                        id="list_name"
                        class="appearance-none mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md text-black"
                        autocomplete="off"
                        v-model="listName"
                    />
                </div>

                <div class="overflow-y-auto h-56 pr-1">
                    <div
                        v-for="list in filteredLists"
                        :key="list.id"
                        class="hover:bg-gray-800 rounded mb-1 px-2 py-0.5 flex justify-between cursor-pointer"
                        @click="
                            (list.contains_movie = !list.contains_movie),
                                movieList(list)
                        "
                    >
                        <div class="flex items-center w-11/12">
                            <input
                                type="checkbox"
                                class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded ml-1"
                                :checked="list.contains_movie"
                                @change="movieList(list)"
                            />
                            <p class="ml-2 truncate">{{ list.name }}</p>
                        </div>

                        <div class="flex items-center justify-center">
                            <svg
                                v-if="list.visibility"
                                key="public"
                                class="w-5 h-5 text-green-500 block"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"
                                ></path>
                            </svg>

                            <svg
                                v-else
                                key="private"
                                class="w-5 h-5 text-red-500"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                ></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="px-4 py-3 bg-gray-800 rounded-md text-right sm:px-6 flex justify-end"
            >
                <div>
                    <button
                        @click="creating = true"
                        type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        <svg
                            class="sm:-ml-1 sm:mr-2 h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                            ></path>
                        </svg>
                        <span class="hidden sm:block">Create a new list</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import MoviesListShowcase from "@/Components/MoviesListShowcase";

export default {
    components: {
        MoviesListShowcase,
    },

    props: {
        lists: Object,
        movie: Object,
    },

    data() {
        return {
            creating: false,
            listName: "",
            form: {
                name: "",
                description: "",
                visibility: false,
            },
        };
    },

    computed: {
        filteredLists() {
            return this.lists.filter((list) =>
                list.name.includes(this.listName)
            );
        },
    },

    methods: {
        createList() {
            this.$inertia.post(route("lists.store"), this.form, {
                preserveState: true,
                preserveScroll: true,
                resetOnSuccess: false,
            });

            this.creating = false;
            this.form = {
                name: "",
                description: "",
                visibility: false,
            };
        },

        cancel() {
            this.creating = false;
        },

        movieList(list) {
            this.$inertia.post(
                route("lists.store.movie", [list.id, this.movie.id]),
                {},
                {
                    preserveState: true,
                    preserveScroll: true,
                    resetOnSuccess: false,
                }
            );
        },
    },
};
</script>
