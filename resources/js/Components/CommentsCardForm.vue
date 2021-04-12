<template>
    <div class="mt-5 md:mt-0 md:col-span-2 relative z-10">
        <form @submit.prevent="createComment">
            <div class="shadow rounded-md overflow-hidden">
                <div class="px-4 py-5 bg-gray-900 space-y-6 sm:p-6">
                    <div>
                        <div class="mt-1">
                            <textarea
                                id="comment"
                                name="comment"
                                rows="5"
                                class="disabled:opacity-50 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md"
                                placeholder="Add a comment..."
                                v-model="form.comment"
                            ></textarea>
                        </div>
                    </div>
                </div>

                <div
                    class="px-4 py-3 bg-gray-800 text-right sm:px-6 flex justify-end"
                >
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
            form: {
                comment: "",
            },
        };
    },

    methods: {
        createComment() {
            this.$inertia.post(
                route("reviews.comments.store", [
                    this.movie.id,
                    this.review.id,
                ]),
                this.form,
                {
                    preserveState: false,
                    preserveScroll: true,
                    resetOnSuccess: false,
                }
            );
        },
    },
};
</script>
