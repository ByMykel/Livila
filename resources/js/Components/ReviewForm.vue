<template>
    <div class="mt-5 md:mt-0 md:col-span-2 relative z-50">
        <form @submit.prevent="submitHandler">
            <div class="shadow rounded-md overflow-hidden">
                <div class="px-4 py-5 bg-gray-900 space-y-6 sm:p-6">
                    <div>
                        <label
                            for="about"
                            class="block text-sm font-medium text-white"
                        >
                            {{ titleMessage }}
                        </label>
                        <div class="mt-1">
                            <textarea
                                id="about"
                                name="about"
                                rows="5"
                                class="disabled:opacity-50 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md"
                                placeholder="Add a review..."
                                v-model="form.review"
                                :disabled="!editingReview && !notReviewed"
                            ></textarea>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">
                            Please describe what you liked or disliked about
                            this movie and whether you recommend it to others.
                        </p>
                    </div>
                </div>

                <div class="bg-gray-900 space-y-6 sm:px-6 px-4 pb-4">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input
                                id="recommend"
                                name="recommend"
                                type="checkbox"
                                class="disabled:opacity-50 focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
                                v-model="form.recommended"
                                :disabled="!editingReview && !notReviewed"
                            />
                        </div>
                        <div class="ml-3 text-sm">
                            <label
                                for="recommend"
                                class="font-medium text-white"
                                >Recommend</label
                            >
                            <p class="text-gray-500">
                                Check this box if you recommend this game.
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input
                                id="spoiler"
                                name="spoiler"
                                type="checkbox"
                                class="disabled:opacity-50 focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded"
                                v-model="form.spoiler"
                                :disabled="!editingReview && !notReviewed"
                            />
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="spoiler" class="font-medium text-white"
                                >Spoiler</label
                            >
                            <p class="text-gray-500">
                                Check this box if your review contains spoilers.
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="px-4 py-3 bg-gray-800 text-right sm:px-6 flex"
                    :class="editingReview ? 'justify-between' : 'justify-end'"
                >
                    <button
                        @click="destroyReview()"
                        v-show="editingReview"
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
                            @click="editingReview = !editingReview"
                            v-show="!editingReview && !notReviewed"
                            type="button"
                            class="mr-2 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            <svg
                                class="sm:-ml-1 sm:mr-2 h-5 w-5 text-gray-500"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                            >
                                <path
                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
                                />
                            </svg>
                            <span class="hidden sm:block">Edit</span>
                        </button>

                        <button
                            @click="restoreData(), (editingReview = false)"
                            v-show="editingReview"
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
                            v-show="notReviewed || editingReview"
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
    </div>
</template>

<script>
export default {
    props: {
        movie: Object,
        review: Object,
    },

    data() {
        return {
            editingReview: false,
            form: {
                review: this.review.length > 0 ? this.review[0].review : "",
                recommended:
                    this.review.length > 0
                        ? Boolean(this.review[0].recommended)
                        : false,
                spoiler:
                    this.review.length > 0
                        ? Boolean(this.review[0].spoiler)
                        : false,
            },
        };
    },

    computed: {
        notReviewed() {
            return this.review.length === 0;
        },

        titleMessage() {
            return (
                (this.notReviewed
                    ? "Write a review for "
                    : "Edit your review for ") + this.movie.title
            );
        },
    },

    methods: {
        submitHandler() {
            if (this.notReviewed) {
                this.createReview();
            } else {
                this.updateReview();
            }
        },

        updateReview() {
            this.$inertia.post(
                route("movies.reviews.update", [
                    this.movie.id,
                    this.review[0].id,
                ]),
                this.form,
                {
                    preserveState: false,
                    preserveScroll: true,
                    resetOnSuccess: false,
                }
            );
        },

        createReview() {
            this.$inertia.post(
                route("movies.reviews.store", this.movie.id),
                this.form,
                {
                    preserveState: false,
                    preserveScroll: true,
                    resetOnSuccess: false,
                }
            );
        },

        destroyReview() {
            this.$inertia.delete(
                route("movies.reviews.destroy", [
                    this.movie.id,
                    this.review[0].id,
                ]),
                {
                    preserveState: false,
                    preserveScroll: true,
                    resetOnSuccess: false,
                }
            );
        },

        restoreData() {
            this.form = {
                review: this.review.length > 0 ? this.review[0].review : "",
                recommended:
                    this.review.length > 0
                        ? Boolean(this.review[0].recommended)
                        : false,
                spoiler:
                    this.review.length > 0
                        ? Boolean(this.review[0].spoiler)
                        : false,
            };
        },
    },
};
</script>
