<template>
    <div>
        <div class="mx-auto">
            <div class="lg:text-center">
                <p
                    class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-white sm:text-4xl"
                >
                    The social network for film lovers
                </p>
                <p class="mt-4 max-w-3xl text-xl text-gray-400 lg:mx-auto">
                    <a class="text-gray-200 hover:text-indigo-400" :href="route('login')">Log in</a>
                    or
                    <a class="text-gray-200 hover:text-indigo-400" :href="route('register')"
                        >Sing up</a
                    >
                    to get started. We’re your home for logging, rating and
                    reviewing films, your watchlist of titles to see, your
                    source for lists and inspiration, a cast and crew database
                    and an activity stream of passionate film criticism,
                    discussion and discovery.
                </p>
            </div>

            <div class="mt-10">
                <dl
                    class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10"
                >
                    <div class="relative rounded-md p-2">
                        <dt>
                            <div
                                class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white"
                            >
                                <svg
                                    class="w-6 h-6"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M10 12a2 2 0 100-4 2 2 0 000 4z"
                                    ></path>
                                    <path
                                        fill-rule="evenodd"
                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                        clip-rule="evenodd"
                                    ></path>
                                </svg>
                            </div>
                            <p
                                class="ml-16 text-lg leading-6 font-medium text-white"
                            >
                                Tell us what you’ve seen
                            </p>
                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-400">
                            Keep track of every film you’ve ever watched (or
                            just start from the day you join)
                        </dd>
                    </div>

                    <div class="relative rounded-md p-2">
                        <dt>
                            <div
                                class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white"
                            >
                                <svg
                                    class="w-6 h-6"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                        clip-rule="evenodd"
                                    ></path>
                                </svg>
                            </div>
                            <p
                                class="ml-16 text-lg leading-6 font-medium text-white"
                            >
                                Tell us what you’ve liked
                            </p>
                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-400">
                            Show some love for your favorite films, lists and
                            reviews with a “like”
                        </dd>
                    </div>

                    <div class="relative rounded-md p-2">
                        <dt>
                            <div
                                class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white"
                            >
                                <svg
                                    class="w-6 h-6"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z"
                                    ></path>
                                </svg>
                            </div>
                            <p
                                class="ml-16 text-lg leading-6 font-medium text-white"
                            >
                                Make and share lists
                            </p>
                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-400">
                            Compile and share lists of films on any topic and
                            keep a watchlist of films to see
                        </dd>
                    </div>

                    <div class="relative rounded-md p-2">
                        <dt>
                            <div
                                class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white"
                            >
                                <svg
                                    class="w-6 h-6"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z"
                                        clip-rule="evenodd"
                                    ></path>
                                </svg>
                            </div>
                            <p
                                class="ml-16 text-lg leading-6 font-medium text-white"
                            >
                                Reviews and following
                            </p>
                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-400">
                            Write and share reviews, and follow friends and
                            other members to read theirs
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="mt-20 mb-40">
                <div
                    class="lg:mx-auto lg:grid lg:grid-cols-2 lg:grid-flow-col-dense lg:gap-12 mb-16 lg:mb-10"
                >
                    <div class="mb-3 lb:mb-0 lg:ml-16 flex items-center">
                        <div>
                            <p class="text-lg leading-6 font-medium text-white">
                                Tell us what you’ve seen
                            </p>
                            <p class="mt-2 text-base text-gray-400">
                                Get your Livila underway by visiting our Movies
                                section and marking a few films you’ve seen. We
                                add all watched titles to your Films tab and
                                then we can show you reviews containing spoilers
                                (usually hidden) and other cool stuff.
                            </p>
                        </div>
                    </div>

                    <div>
                        <img
                            class="w-full"
                            src="/images/welcome_1.png"
                            alt=""
                        />
                    </div>
                </div>

                <div
                    class="lg:mx-auto lg:grid lg:grid-cols-2 lg:grid-flow-col-dense lg:gap-12 mb-16 lg:mb-10"
                >
                    <div>
                        <img
                            class="w-full"
                            src="/images/welcome_2.png"
                            alt=""
                        />
                    </div>

                    <div class="mt-3 lb:mt-0 lg:mr-16 flex items-center">
                        <div>
                            <p class="text-lg leading-6 font-medium text-white">
                                Browse your watched films
                            </p>
                            <p class="mt-2 text-base text-gray-400">
                                Now that you’ve added some films, you can find
                                them in the Films tab of your profile. As you
                                add more content, your profile starts to reflect
                                your taste. You can also browse the films of
                                other members.
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="lg:mx-auto lg:grid lg:grid-cols-2 lg:grid-flow-col-dense lg:gap-12 mb-16 lg:mb-10"
                >
                    <div class="mb-3 lb:mb-0 lg:ml-16 flex items-center">
                        <div>
                            <p class="text-lg leading-6 font-medium text-white">
                                Review a film
                            </p>
                            <p class="mt-2 text-base text-gray-400">
                                The best way to tell others your opinion about a
                                movies is by describing what you liked or
                                disliked and whether you recommend it to others.
                            </p>
                        </div>
                    </div>

                    <div>
                        <img
                            class="w-full"
                            src="/images/welcome_3.png"
                            alt=""
                        />
                    </div>
                </div>

                <div
                    class="lg:mx-auto lg:grid lg:grid-cols-2 lg:grid-flow-col-dense lg:gap-12 mb-16 lg:mb-10"
                >
                    <div>
                        <img
                            class="w-full"
                            src="/images/welcome_4.png"
                            alt=""
                        />
                    </div>

                    <div class="mt-3 lb:mt-0 lg:mr-16 flex items-center">
                        <div>
                            <p class="text-lg leading-6 font-medium text-white">
                                Make and share lists
                            </p>
                            <p class="mt-2 text-base text-gray-400">
                                Lists are a great way to share a collection of
                                related films.
                            </p>
                            <p class="mt-1 text-base text-gray-400">
                                Start a list on your Lists tab (or from the menu
                                on a movie page), then add films. The first time
                                you make a list public, it’s shared with your
                                followers.
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="lg:mx-auto lg:grid lg:grid-cols-2 lg:grid-flow-col-dense lg:gap-12 mb-16 lg:mb-10"
                >
                    <div class="mb-3 lb:mb-0 lg:ml-16 flex items-center">
                        <div>
                            <p class="text-lg leading-6 font-medium text-white">
                                Following and activity
                            </p>
                            <p class="mt-2 text-base text-gray-400">
                                The best way to find members to follow is by
                                reading reviews of films you like, to identify
                                the voices and opinions you dig
                            </p>
                        </div>
                    </div>

                    <div>
                        <img
                            class="w-full"
                            src="/images/welcome_5.png"
                            alt=""
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {};
</script>