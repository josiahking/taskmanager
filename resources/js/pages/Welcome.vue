<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>

    <Head title="Welcome" />
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <div
            class="relative flex min-h-screen flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                    <div class="flex lg:col-start-2 lg:justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-auto text-[#5e03a8]" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-6h6v6h5v2H4v-2h5z" />
                        </svg>

                    </div>
                    <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-end">
                        <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Dashboard
                        </Link>

                        <template v-else>
                            <Link :href="route('login')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                            Log in
                            </Link>

                            <Link v-if="canRegister" :href="route('register')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                            Register
                            </Link>
                        </template>
                    </nav>
                </header>

                <main class="mt-6">
                    <section class="flex flex-col items-center justify-center text-center px-6 py-20">
                        <div class="max-w-6xl mx-auto px-6 py-20 text-center">
                            <h2 class="text-5xl font-extrabold text-gray-800 mb-4">
                                Organize Your Day, One Drag at a Time
                            </h2>
                            <p class="text-gray-600 mb-8 max-w-2xl mx-auto">
                                Drag & drop tasks, filter by project, and auto-set priorities—all in one intuitive
                                interface.
                            </p>
                            <Link href="/register"
                                class="inline-block bg-indigo-600 text-white px-8 py-3 rounded-lg text-lg hover:bg-indigo-500">
                            Try It Free
                            </Link>
                        </div>

                    </section>
                    <!-- Features -->
                    <h3 class="text-3xl font-bold text-gray-800 mb-12 text-center">Key Features</h3>

                    <section class="grid md:grid-cols-3 gap-8 px-10 py-16 bg-white shadow-inner">
                        <div class="p-6 bg-blue-50 rounded-xl shadow hover:shadow-lg transition">
                            <h3 class="text-xl font-semibold text-blue-600 mb-3">✅ Drag & Drop</h3>
                            <p class="text-gray-600">Reorder tasks instantly to reflect your priorities.</p>
                        </div>
                        <div class="p-6 bg-green-50 rounded-xl shadow hover:shadow-lg transition">
                            <h3 class="text-xl font-semibold text-green-600 mb-3">✅ Smart Filters</h3>
                            <p class="text-gray-600">Filter by project, due date, or custom tags.
                            </p>
                        </div>
                        <div class="p-6 bg-purple-50 rounded-xl shadow hover:shadow-lg transition">
                            <h3 class="text-xl font-semibold text-purple-600 mb-3">✅ Smart Priority</h3>
                            <p class="text-gray-600">Tasks auto-assign High, Medium, or Low based on position.</p>
                        </div>
                    </section>
                    <section id="how-it-works" class="py-16 bg-white">
                        <div class="max-w-4xl mx-auto px-6 text-center">
                            <h3 class="text-3xl font-bold text-gray-800 mb-8">How It Works</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                                <div>
                                    <div class="text-indigo-600 text-4xl mb-4">1</div>
                                    <h4 class="font-semibold mb-2">Add Tasks</h4>
                                    <p class="text-gray-600">Create tasks with name, project, and due date.</p>
                                </div>
                                <div>
                                    <div class="text-indigo-600 text-4xl mb-4">2</div>
                                    <h4 class="font-semibold mb-2">Drag & Reorder</h4>
                                    <p class="text-gray-600">Reorder your list to change priorities.</p>
                                </div>
                                <div>
                                    <div class="text-indigo-600 text-4xl mb-4">3</div>
                                    <h4 class="font-semibold mb-2">Stay Productive</h4>
                                    <p class="text-gray-600">Focus on what matters and ship value faster.</p>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- CTA -->
                    <section class="text-center py-16 px-6 bg-gradient-to-r from-blue-600 to-purple-600 text-white">
                        <h2 class="text-3xl font-bold mb-4">Ready to Get Organized?</h2>
                        <p class="mb-8">Join thousands of users boosting their productivity every day.</p>
                        <Link href="/register"
                            class="px-8 py-3 bg-white text-blue-700 font-semibold rounded-lg shadow hover:bg-gray-100">
                        Sign Up Free
                        </Link>
                    </section>
                    <footer class="bg-gray-800 text-gray-400 py-6">
                        <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row justify-between">
                            <p>© 2025 TaskTrackr. All rights reserved.</p>
                            <div class="flex space-x-4 mt-4 md:mt-0">
                                <a href="#" class="hover:text-white">Privacy</a>
                                <a href="#" class="hover:text-white">Terms</a>
                                <a href="#" class="hover:text-white">Contact</a>
                            </div>
                        </div>
                    </footer>
                </main>
            </div>
        </div>
    </div>
</template>
