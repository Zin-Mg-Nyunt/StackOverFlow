<script setup>
import { titleCase } from '@/composables/titleCase.js';
import { Link, router, usePage } from '@inertiajs/vue3';
import { computed, onMounted, ref, watch } from 'vue';
import useFilter from '../composables/useFilter.js';

const isDark = ref(true);
let allTags = ref(false);
let page = usePage();
let { search, slug } = useFilter();

const navigation = ref([
    { label: 'Home', active: true },
    { label: 'Tags', active: false },
    { label: 'Users', active: false },
    { label: 'Companies', active: false },
    { label: 'Collectives', active: false },
]);

const toggleTheme = () => {
    isDark.value = !isDark.value;
};

watch(
    isDark,
    (value) => {
        document.documentElement.classList.toggle('dark', value);
    },
    { immediate: true },
);

const logout = () => {
    router.post('/logout');
};

onMounted(() => {
    document.documentElement.classList.toggle('dark', isDark.value);
});

const popularTags = computed(() => {
    return page.props.tags.filter((t) => t.questions_count > 10);
});
</script>
<template>
    <div
        class="min-h-screen bg-zinc-50 text-zinc-900 transition-colors duration-300 dark:bg-zinc-950 dark:text-zinc-50"
    >
        <header
            class="sticky top-0 z-20 border-b border-zinc-200 bg-white/80 backdrop-blur dark:border-zinc-800 dark:bg-zinc-900/80"
        >
            <div
                class="mx-auto flex max-w-screen-2xl items-center gap-4 px-6 py-4"
            >
                <div class="flex items-center gap-3">
                    <Link
                        href="/"
                        class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-sky-400 via-indigo-500 to-blue-600 text-lg font-semibold text-white shadow-lg shadow-sky-500/20"
                    >
                        SO
                    </Link>
                    <div>
                        <p
                            class="text-sm font-medium text-zinc-500 dark:text-zinc-400"
                        >
                            Stack Overflow
                        </p>
                        <p
                            class="text-base font-semibold text-zinc-900 dark:text-zinc-50"
                        >
                            Clone · Modern UI
                        </p>
                    </div>
                </div>

                <div class="flex-1">
                    <div
                        class="flex items-center gap-3 rounded-xl border border-zinc-200 bg-zinc-100 px-4 py-2.5 text-sm text-zinc-600 shadow-sm transition focus-within:border-sky-400 focus-within:ring-2 focus-within:ring-sky-200 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-300 dark:focus-within:ring-sky-500/30"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 text-zinc-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.5"
                                d="m21 21-4.35-4.35m0 0A7.5 7.5 0 1 0 5.4 5.4a7.5 7.5 0 0 0 11.3 11.3Z"
                            />
                        </svg>
                        <input
                            class="w-full bg-transparent placeholder:text-zinc-400 focus:outline-none dark:placeholder:text-zinc-600"
                            placeholder="Search questions, tags, users..."
                            v-model="search"
                        />
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <template v-if="!$page.props.auth.user">
                        <Link
                            href="/login"
                            class="rounded-full border border-zinc-200 px-3 py-1.5 text-xs font-medium text-zinc-700 transition hover:border-sky-400 hover:bg-sky-50 dark:border-zinc-800 dark:text-zinc-200 dark:hover:border-sky-500/60 dark:hover:bg-sky-500/10"
                        >
                            Log in
                        </Link>
                        <Link
                            href="/register"
                            class="rounded-full bg-gradient-to-r from-sky-500 via-indigo-500 to-blue-500 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-sky-500/30 transition hover:brightness-105"
                        >
                            Sign up
                        </Link>
                    </template>
                    <template v-else>
                        <!-- INSERT_YOUR_CODE -->
                        <Link
                            :href="
                                route('user.profile', $page.props.auth.user.id)
                            "
                            class="flex cursor-pointer items-center gap-2 rounded-full bg-zinc-100 px-3 py-1.5 text-sm font-medium text-zinc-800 uppercase dark:bg-zinc-800 dark:text-zinc-100"
                        >
                            {{ $page.props.auth.user.name.charAt() }}
                        </Link>
                        <form @submit.prevent="logout" class="inline">
                            <button
                                type="submit"
                                class="ml-2 rounded-full border border-zinc-200 bg-white px-3 py-1.5 text-xs font-medium text-zinc-700 transition hover:border-red-400 hover:bg-red-50 hover:text-red-700 dark:border-zinc-800 dark:bg-zinc-950 dark:text-zinc-200 dark:hover:border-red-500/80 dark:hover:bg-red-800/40 dark:hover:text-red-300"
                            >
                                Log out
                            </button>
                        </form>
                    </template>
                    <button
                        class="rounded-full border border-zinc-200 p-2 text-zinc-600 transition hover:border-sky-400 hover:text-sky-500 dark:border-zinc-800 dark:text-zinc-300 dark:hover:border-sky-500/60 dark:hover:text-sky-400"
                        @click="toggleTheme"
                        :aria-pressed="isDark"
                    >
                        <span
                            v-if="isDark"
                            class="inline-flex items-center gap-1"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79Z"
                                />
                            </svg>
                            <span class="text-xs font-medium">Dark</span>
                        </span>
                        <span v-else class="inline-flex items-center gap-1">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.5"
                                    d="M12 4.5v1.5m0 12v1.5m7.5-7.5h-1.5m-12 0H4.5m12.02-4.77-1.06 1.06m-7.42 7.42-1.06 1.06m0-9.54 1.06 1.06m7.42 7.42 1.06 1.06M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"
                                />
                            </svg>
                            <span class="text-xs font-medium">Light</span>
                        </span>
                    </button>
                </div>
            </div>
        </header>
        <template v-if="$page.props.flash.danger">
            <div class="bg-red-400 p-4 text-center text-white">
                <p class="font-semibold">{{ $page.props.flash.danger }}</p>
            </div>
        </template>
        <template v-if="$page.props.flash.success">
            <div class="bg-green-400 p-4 text-center text-white">
                <p class="font-semibold">{{ $page.props.flash.success }}</p>
            </div>
        </template>
        <main
            class="mx-auto grid max-w-screen-2xl grid-cols-12 gap-6 px-6 py-8"
        >
            <aside class="col-span-12 lg:col-span-2">
                <div
                    class="sticky top-24 space-y-2 rounded-2xl border border-zinc-200 bg-white/80 p-3 shadow-sm backdrop-blur dark:border-zinc-800 dark:bg-zinc-900/70"
                >
                    <p
                        class="px-2 text-xs font-semibold tracking-wide text-zinc-500 uppercase dark:text-zinc-400"
                    >
                        Explore
                    </p>
                    <nav class="space-y-1">
                        <Link
                            :href="route('home')"
                            v-for="item in navigation"
                            :key="item.label"
                            s
                            :class="[
                                'flex w-full items-center justify-between rounded-xl px-3 py-2 text-sm font-medium transition',
                                item.active
                                    ? 'bg-sky-50 text-sky-600 ring-1 ring-sky-200 dark:bg-sky-500/10 dark:text-sky-200 dark:ring-sky-500/30'
                                    : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800',
                            ]"
                        >
                            <span>{{ item.label }}</span>
                            <span
                                v-if="item.active"
                                class="h-2 w-2 rounded-full bg-sky-500"
                            />
                        </Link>
                    </nav>
                    <div
                        class="mt-4 rounded-xl bg-gradient-to-br from-zinc-100 to-white p-3 text-sm text-zinc-700 ring-1 ring-zinc-200 dark:from-zinc-900 dark:to-zinc-950 dark:text-zinc-200 dark:ring-zinc-800"
                    >
                        <p
                            class="font-semibold text-zinc-900 dark:text-zinc-50"
                        >
                            Collectives
                        </p>
                        <p
                            class="mt-1 text-xs text-zinc-500 dark:text-zinc-400"
                        >
                            Discover trusted communities sharing knowledge.
                        </p>
                        <button
                            class="mt-3 w-full rounded-lg bg-zinc-900 px-3 py-2 text-xs font-semibold text-white transition hover:brightness-110 dark:bg-white dark:text-zinc-900"
                        >
                            Explore collectives
                        </button>
                    </div>
                </div>
            </aside>

            <section class="col-span-12 space-y-6 lg:col-span-7">
                <slot />
            </section>

            <aside class="col-span-12 space-y-4 lg:col-span-3">
                <div
                    class="rounded-2xl border border-zinc-200 bg-white/80 p-4 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/80"
                >
                    <div class="flex items-center justify-between">
                        <p
                            class="text-sm font-semibold text-zinc-900 dark:text-zinc-50"
                        >
                            The Recent blogs
                        </p>
                        <span class="text-xs text-sky-500">New</span>
                    </div>
                    <ul class="mt-3 space-y-2 text-sm">
                        <li
                            v-for="question in $page.props.latestQuestions"
                            :key="question.title"
                            class="group flex items-start gap-2 rounded-lg p-2 transition hover:bg-zinc-100 dark:hover:bg-zinc-800"
                        >
                            <span
                                class="mt-1 h-2 w-2 rounded-full bg-sky-500"
                            />
                            <div>
                                <p
                                    class="line-clamp-1 font-semibold text-zinc-800 group-hover:text-sky-600 dark:text-zinc-100 dark:group-hover:text-sky-300"
                                >
                                    {{ titleCase(question.title) }}
                                </p>
                                <Link
                                    :href="
                                        route('questions.detail', question.id)
                                    "
                                    class="text-xs text-sky-500"
                                    >Read more
                                </Link>
                            </div>
                        </li>
                    </ul>
                </div>

                <div
                    class="rounded-2xl border border-zinc-200 bg-white/80 p-4 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/80"
                >
                    <div class="flex items-center justify-between">
                        <p
                            class="text-sm font-semibold text-zinc-900 dark:text-zinc-50"
                        >
                            {{ allTags ? 'All tags' : 'Popular tags' }}
                        </p>
                        <span
                            class="cursor-pointer text-xs text-sky-500"
                            @click="allTags = !allTags"
                        >
                            {{ allTags ? 'Hide' : 'View all' }}
                        </span>
                    </div>
                    <div class="mt-3 grid grid-cols-2 gap-2">
                        <div
                            v-for="tag in allTags
                                ? $page.props.tags
                                : popularTags"
                            :key="tag.slug"
                            class="flex items-center justify-between rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm font-semibold text-zinc-700 dark:border-zinc-800 dark:bg-zinc-800/70 dark:text-zinc-200"
                        >
                            <span
                                @click="slug = tag.slug"
                                class="cursor-pointer"
                                >#{{ tag.name }}</span
                            >
                            <span class="text-xs text-emerald-500">{{
                                tag.questions_count
                            }}</span>
                        </div>
                    </div>
                </div>

                <div
                    class="rounded-2xl border border-dashed border-zinc-300 bg-gradient-to-br from-zinc-100 to-white p-4 text-sm text-zinc-700 dark:border-zinc-700 dark:from-zinc-900 dark:to-zinc-950 dark:text-zinc-200"
                >
                    <p
                        class="text-sm font-semibold text-zinc-900 dark:text-zinc-50"
                    >
                        Hire the best talent
                    </p>
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                        Reach millions of developers where they already work.
                    </p>
                    <button
                        class="mt-3 w-full rounded-lg bg-sky-500 px-3 py-2 text-sm font-semibold text-white shadow-md shadow-sky-500/20 transition hover:brightness-110"
                    >
                        Post a job
                    </button>
                </div>
            </aside>
        </main>
    </div>
</template>

<style></style>
