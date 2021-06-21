<template>
    <div class="mt-5 md:mt-0 md:col-span-2 relative">
        <form>
            <div class="shadow rounded-md overflow-hidden">
                <div class="px-4 py-5 bg-black-300 space-y-6 sm:p-6">
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
                            class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                            :class="[ (form.name.length === 0 || form.name.length > 50) ? 'border-2 border-red-500 focus:ring-red-500 focus:border-red-500' : 'focus:ring-indigo-500 focus:border-indigo-500' ]"
                            placeholder="Add a name..."
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
                                class="disabled:opacity-50 shadow-sm mt-1 block w-full sm:text-sm border-gray-300 rounded-md"
                                :class="[ form.description.length > 300 ? 'border-2 border-red-500 focus:ring-red-500 focus:border-red-500' : 'focus:ring-indigo-500 focus:border-indigo-500' ]"
                                placeholder="Add a decription..."
                                v-model="form.description"
                            ></textarea>
                        </div>
                        <p class="mt-2 text-sm text-black-100">
                            Please describe what kind of movies this list
                            contains.
                        </p>
                    </div>
                </div>

                <div class="bg-black-300 space-y-6 sm:px-6 px-4 pb-4">
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
                            <p class="text-black-100">
                                Make this list visible to others.
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="px-4 py-3 bg-black-200 text-right sm:px-6 flex"
                    :class="editing ? 'justify-between' : 'justify-end'"
                >
                    <button
                        @click="destroyList()"
                        v-show="editing"
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
                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                clip-rule="evenodd"
                            ></path>
                        </svg>
                        <span class="hidden sm:block">Delete</span>
                    </button>

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
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                            <span class="hidden sm:block">Cancel</span>
                        </button>

                        <button
                            @click="submitHandler()"
                            type="button"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50"
                            :disabled="form.name.length === 0 || form.name.length > 50 || form.description.length > 300"
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

        <div
            v-show="editing"
            class="mt-3 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md"
        >
            <p v-show="movies.length === 0" class="text-white font-bold">
                Your list is empty.
            </p>

            <movies-list-showcase
                @remove-movie="removeMovie($event)"
                :movies="movies"
            ></movies-list-showcase>
        </div>
    </div>
</template>

<script>
import MoviesListShowcase from "@/Components/MoviesList/MoviesListShowcase";

export default {
    components: {
        MoviesListShowcase,
    },

    props: {
        editing: {
            type: Boolean,
            default: false,
        },

        list: {
            type: Object,
            default() {
                return {
                    name: "",
                    description: "",
                    visibility: false,
                };
            },
        },

        movies: {
            type: Array,
            default: [],
        },
    },

    data() {
        return {
            form: {
                name: this.list.name,
                description: this.list.description,
                visibility: Boolean(this.list.visibility),
                removedMovies: [],
            },
        };
    },

    methods: {
        submitHandler() {
            if (this.editing) {
                this.updateList();
            } else {
                this.createList();
            }
        },

        updateList() {
            const removedMovies = this.movies.filter(
                (movie) => movie.deleted === true
            );

            this.form.removedMovies = removedMovies.map((movie) => movie.id);

            this.$inertia.post(route("lists.update", this.list.id), this.form, {
                preserveState: false,
                preserveScroll: true,
                resetOnSuccess: false,
            });
        },

        createList() {
            this.$inertia.post(route("lists.store"), this.form, {
                preserveState: false,
                preserveScroll: true,
                resetOnSuccess: false,
            });
        },

        destroyList() {
            this.$inertia.delete(route("lists.destroy", this.list.id), {
                preserveState: false,
                preserveScroll: true,
                resetOnSuccess: false,
            });
        },

        cancel() {
            this.$inertia.visit(route("lists.show", this.list.id));
        },

        removeMovie(id) {
            for (let i = 0; i < this.movies.length; i++) {
                if (this.movies[i].id === id) {
                    this.movies[i].deleted = !this.movies[i].deleted;
                    return;
                }
            }
        },
    },
};
</script>
