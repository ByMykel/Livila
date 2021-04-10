<template>
    <div ref="dropdown" v-if="$page.props.user">
        <div>
            <button
                @click="show = !show"
                type="button"
                class="bg-gray-800 flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
                id="user-menu"
                aria-expanded="false"
                aria-haspopup="true"
            >
                <span class="sr-only">Open user menu</span>
                <img
                    class="h-8 w-8 rounded-full"
                    :src="$page.props.user.profile_photo_url"
                    alt=""
                />
            </button>
        </div>

        <transition
            enter-active-class="transition ease-out duration-100"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
        >
            <div
                v-if="show"
                class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                role="menu"
                aria-orientation="vertical"
                aria-labelledby="user-menu"
            >
                <a
                    :href="route('user', $page.props.user.username)"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                    role="menuitem"
                    >Your Profile</a
                >
                <a
                    :href="route('profile.show')"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                    role="menuitem"
                    >Settings</a
                >
                <form @submit.prevent="logout">
                    <button
                        class="block w-full px-4 py-2 text-sm text-gray-700 text-left hover:bg-gray-100"
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
