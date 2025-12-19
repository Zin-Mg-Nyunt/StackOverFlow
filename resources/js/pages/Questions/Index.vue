<script setup>
import { Link } from '@inertiajs/vue3';
import SingleQuestion from '../components/SingleQuestion.vue';

const tags = ['Interesting', 'Bountied', 'Hot', 'Week', 'Month'];

let { questions, filters } = defineProps({
    questions: Object,
    filters: Object,
});
</script>

<template>
    <div
        class="overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-sm dark:border-zinc-800 dark:bg-zinc-900"
    >
        <div
            class="bg-gradient-to-r from-sky-500 via-indigo-500 to-blue-500 px-6 py-6 text-white"
        >
            <p class="text-sm tracking-[0.2em] text-white/80 uppercase">
                Stack Overflow
            </p>
            <h1 class="mt-2 text-3xl leading-tight font-bold">
                Every developer has a tab open here.
            </h1>
            <p class="mt-2 max-w-2xl text-sm text-white/80">
                Find the best answers, share what you know, and build momentum
                with the community that ships the web.
            </p>
            <div class="mt-4 flex flex-wrap items-center gap-3">
                <Link
                    href="/questions/ask"
                    class="rounded-full bg-white px-4 py-2 text-sm font-semibold text-sky-600 shadow-md shadow-sky-500/20 transition hover:brightness-105"
                >
                    Ask question
                </Link>
                <button
                    class="rounded-full border border-white/60 px-4 py-2 text-sm font-semibold text-white/90 transition hover:bg-white/10"
                >
                    Browse jobs
                </button>
            </div>
        </div>
        <div
            class="flex flex-wrap items-center gap-2 border-t border-zinc-200 px-4 py-3 dark:border-zinc-800"
        >
            <button
                v-for="filter in tags"
                :key="filter"
                class="rounded-full border border-zinc-200 px-3 py-1.5 text-xs font-semibold text-zinc-700 transition hover:border-sky-300 hover:text-sky-600 dark:border-zinc-800 dark:text-zinc-200 dark:hover:border-sky-500/60 dark:hover:text-sky-300"
            >
                {{ filter }}
            </button>
            <span class="ml-auto text-xs text-zinc-500 dark:text-zinc-400"
                >{{ questions.data.length }} questions · updated live</span
            >
        </div>
    </div>

    <div class="space-y-4">
        <SingleQuestion :questions="questions" :filters="filters" />
    </div>
</template>

<style scoped></style>
