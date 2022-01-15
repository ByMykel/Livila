<template>
    <div ref="dropdown" v-if="$page.props.auth">
        <div>
            <button
                @click="show = !show"
                type="button"
                class="flex text-sm bg-gray-800 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
                id="user-menu"
                aria-expanded="false"
                aria-haspopup="true"
            >
                <span class="sr-only">Open user menu</span>
                <img
                    class="w-8 h-8 rounded-full"
                    :src="$page.props.auth.profile_photo_url"
                    alt=""
                />
            </button>
        </div>

        <transition
            enter-active-class="transition duration-100 ease-out"
            enter-from-class="transform scale-95 opacity-0"
            enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition duration-75 ease-in"
            leave-from-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0"
        >
            <div
                v-if="show"
                class="absolute right-0 w-48 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                role="menu"
                aria-orientation="vertical"
                aria-labelledby="user-menu"
            >
                <a
                    :href="route('user', $page.props.auth.username)"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                    role="menuitem"
                    >Your Profile</a
                >
                <a
                    :href="
                        route('user.likes.movies', $page.props.auth.username)
                    "
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                    role="menuitem"
                    >Likes</a
                >
                <a
                    :href="route('user.watched', $page.props.auth.username)"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                    role="menuitem"
                    >Watched Movies</a
                >
                <a
                    :href="route('profile.show')"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                    role="menuitem"
                    >Settings</a
                >
                <form @submit.prevent="logout">
                    <button
                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100"
                        role="menuitem"
                    >
                        Sign out
                    </button>
                </form>
            </div>
        </transition>
    </div>
</template>

<script>
export default {
    props: {
        showingMenuDropdown: Boolean,
    },

    data() {
        return {
            show: this.showingMenuDropdown,
        };
    },

    methods: {
        logout() {
            this.$inertia.post(route("logout"));
        },

        onClickOutside(event) {
            const { dropdown } = this.$refs;
            if (!dropdown || dropdown.contains(event.target)) return;
            this.show = false;
        },
    },

    mounted() {
        document.addEventListener("click", this.onClickOutside);
    },
};
</script>
