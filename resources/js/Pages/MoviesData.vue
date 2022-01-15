<template>
    <div class="font-sans antialiased">
        <div class="pt-4 bg-black-500">
            <div class="flex flex-col items-center min-h-screen pt-6 sm:pt-0">
                <div>
                    <jet-authentication-card-logo />
                </div>

                <div
                    class="w-full p-6 mt-6 overflow-hidden shadow-md bg-black-400 sm:max-w-2xl sm:rounded-lg text-black-100"
                >
                    <span>
                        All movies-related metadata used in this product is
                        supplied by The Movie Database (TMDb).
                    </span>

                    <div class="py-10">
                        <img
                            class="block w-40 mx-auto sm:hidden"
                            src="/images/blue_square_tmdb.svg"
                        />
                        <img
                            class="hidden sm:block"
                            src="/images/blue_long_tmdb.svg"
                        />
                    </div>

                    <span>
                        This product uses the
                        <a
                            class="underline text-black-200 hover:text-indigo-400"
                            href="https://developers.themoviedb.org/3/getting-started/introduction"
                            target="_blank"
                            >TMDb API</a
                        >
                        but is not endorsed or certified by
                        <a
                            class="underline text-black-200 hover:text-indigo-400"
                            href="https://www.themoviedb.org/"
                            target="_blank"
                            >TMDb</a
                        >.
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import JetAuthenticationCardLogo from "@/Jetstream/AuthenticationCardLogo";

export default {
    components: {
        JetAuthenticationCardLogo,
    },
};
</script>
