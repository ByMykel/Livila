<template>
    <div class="font-sans text-white antialiased">
        <div class="pt-4 bg-black-400">
            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                <div>
                    <jet-authentication-card-logo />
                </div>

                <div
                    class="
                        w-full
                        sm:max-w-2xl
                        mt-6
                        p-6
                        bg-white
                        shadow-md
                        overflow-hidden
                        sm:rounded-lg
                        prose
                    "
                >
                    <span>
                        All movies-related metadata used in this product is
                        supplied by The Movie Database (TMDb).
                    </span>

                    <img
                        class="block sm:hidden w-40 mx-auto"
                        src="/images/blue_square_tmdb.svg"
                    />
                    <img
                        class="hidden sm:block"
                        src="/images/blue_long_tmdb.svg"
                    />

                    <!-- <span class="pt-2"
                        >This product uses the TMDb API but is not endorsed or
                        certified by TMDb.</span
                    > -->
                    <span>
                        This product uses the
                        <a
                            class="underline hover:text-indigo-400"
                            href="https://developers.themoviedb.org/3/getting-started/introduction"
                            target="_blank"
                            >TMDb API</a
                        >
                        but is not endorsed or certified by
                        <a
                            class="underline hover:text-indigo-400"
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
