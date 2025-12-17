<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import formatTime from '../../composables/formatDate';

const props = defineProps({
    user: Object,
    stats: Object,
    questions: Array,
    answers: Array,
});

let questionOrAnswer = ref(true);

const formatNumber = (num) => {
    if (num >= 1000000) {
        return (num / 1000000).toFixed(1) + 'M';
    }
    if (num >= 1000) {
        return (num / 1000).toFixed(1) + 'k';
    }
    return num.toString();
};
</script>

<template>
    <Head title="User Profile" />

    <div class="min-h-screen bg-zinc-50 dark:bg-zinc-950">
        <!-- Profile Header -->
        <div
            class="border-b border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-900"
        >
            <div class="mx-auto max-w-screen-2xl px-6 py-8">
                <div
                    class="flex flex-col gap-6 md:flex-row md:items-start md:gap-8"
                >
                    <!-- Avatar -->
                    <div
                        class="flex items-center justify-center md:flex-shrink-0"
                    >
                        <div
                            class="flex h-32 w-32 items-center justify-center rounded-2xl bg-gradient-to-br from-sky-500 via-indigo-500 to-blue-600 text-4xl font-bold text-white shadow-lg shadow-sky-500/20"
                        >
                            {{ user.name.charAt(0).toUpperCase() }}
                        </div>
                    </div>

                    <!-- User Info -->
                    <div class="flex-1 space-y-4">
                        <div>
                            <h1
                                class="text-center text-3xl font-bold text-zinc-900 md:text-left dark:text-zinc-50"
                            >
                                {{ user.name }}
                            </h1>
                            <p
                                class="mt-1 text-center text-sm text-zinc-600 md:text-left dark:text-zinc-400"
                            >
                                {{ user.email }}
                            </p>
                        </div>

                        <!-- Stats Grid -->
                        <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                            <div
                                class="rounded-xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-900"
                            >
                                <div
                                    class="text-2xl font-bold text-zinc-900 dark:text-zinc-50"
                                >
                                    {{ formatNumber(stats.reputation) }}
                                </div>
                                <div
                                    class="text-xs font-medium text-zinc-600 dark:text-zinc-400"
                                >
                                    Reputation
                                </div>
                            </div>
                            <div
                                class="rounded-xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-900"
                            >
                                <div
                                    class="text-2xl font-bold text-zinc-900 dark:text-zinc-50"
                                >
                                    {{ stats.questions }}
                                </div>
                                <div
                                    class="text-xs font-medium text-zinc-600 dark:text-zinc-400"
                                >
                                    Questions
                                </div>
                            </div>
                            <div
                                class="rounded-xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-900"
                            >
                                <div
                                    class="text-2xl font-bold text-zinc-900 dark:text-zinc-50"
                                >
                                    {{ stats.answers }}
                                </div>
                                <div
                                    class="text-xs font-medium text-zinc-600 dark:text-zinc-400"
                                >
                                    Answers
                                </div>
                            </div>
                            <div
                                class="rounded-xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-900"
                            >
                                <div
                                    class="text-2xl font-bold text-zinc-900 dark:text-zinc-50"
                                >
                                    {{ formatNumber(stats.views) }}
                                </div>
                                <div
                                    class="text-xs font-medium text-zinc-600 dark:text-zinc-400"
                                >
                                    Profile Views
                                </div>
                            </div>
                        </div>

                        <!-- Member Since -->
                        <div
                            class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400"
                        >
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
                                    stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                />
                            </svg>
                            <span
                                >Member since
                                {{ formatTime(user.created_at) }}</span
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Tabs -->
        <div class="mx-auto max-w-screen-2xl px-6 py-8">
            <div class="mb-6 border-b border-zinc-200 dark:border-zinc-800">
                <nav class="-mb-px flex gap-6">
                    <button
                        class="px-1 pb-4 text-sm font-semibold transition hover:text-zinc-900 dark:hover:text-zinc-50"
                        :class="{
                            'border-b-2 border-sky-500 text-sky-600 dark:text-sky-400':
                                questionOrAnswer,
                        }"
                        @click="questionOrAnswer = true"
                    >
                        Questions ({{ stats.questions }})
                    </button>
                    <button
                        class="px-1 pb-4 text-sm font-semibold transition hover:text-zinc-900 dark:hover:text-zinc-50"
                        :class="{
                            'border-b-2 border-sky-500 text-sky-600 dark:text-sky-400':
                                !questionOrAnswer,
                        }"
                        @click="questionOrAnswer = false"
                    >
                        Answers ({{ stats.answers }})
                    </button>
                </nav>
            </div>
            <!-- Questions Section -->
            <div class="space-y-4" v-if="questionOrAnswer">
                <h2 class="text-xl font-bold text-zinc-900 dark:text-zinc-50">
                    Recent Questions
                </h2>

                <div
                    v-if="questions.length === 0"
                    class="rounded-xl border border-zinc-200 bg-white p-8 text-center dark:border-zinc-800 dark:bg-zinc-900"
                >
                    <p class="text-zinc-600 dark:text-zinc-400">
                        No questions yet. Start asking questions to help the
                        community!
                    </p>
                </div>

                <article
                    v-for="question in questions"
                    :key="question.id"
                    class="group rounded-xl border border-zinc-200 bg-white p-6 shadow-sm transition hover:shadow-md dark:border-zinc-800 dark:bg-zinc-900"
                >
                    <div class="flex gap-4">
                        <div
                            class="flex w-22 shrink-0 flex-col items-start gap-2 text-xs font-semibold text-zinc-500 dark:text-zinc-400"
                        >
                            <div
                                class="rounded-lg bg-sky-500/10 px-3 py-1.5 text-center text-sky-600 ring-1 ring-sky-500/30 dark:text-sky-200"
                            >
                                {{ question.votes || 0 }} votes
                            </div>
                            <div
                                class="rounded-lg bg-emerald-500/10 px-3 py-1.5 text-center text-emerald-600 ring-1 ring-emerald-500/30 dark:text-emerald-200"
                            >
                                {{ question.answers_count }} answers
                            </div>
                            <div
                                class="rounded-lg bg-zinc-100 px-3 py-1.5 text-center text-zinc-700 ring-1 ring-zinc-200 dark:bg-zinc-800 dark:text-zinc-200 dark:ring-zinc-700"
                            >
                                {{ question.views || 0 }} views
                            </div>
                        </div>
                        <div class="flex-1 space-y-3">
                            <Link
                                :href="route('questions.detail', question.id)"
                                class="block text-lg leading-snug font-semibold text-zinc-900 transition hover:text-sky-600 dark:text-zinc-50 dark:hover:text-sky-400"
                            >
                                {{ question.title }}
                            </Link>
                            <p
                                class="line-clamp-2 text-sm text-zinc-600 dark:text-zinc-400"
                            >
                                {{ question.body }}
                            </p>
                            <div class="flex flex-wrap items-center gap-2">
                                <span
                                    v-for="tag in question.tags"
                                    :key="tag.id"
                                    class="rounded-full bg-zinc-100 px-3 py-1 text-xs font-semibold text-zinc-700 transition hover:bg-sky-50 hover:text-sky-600 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-sky-500/10 dark:hover:text-sky-200"
                                >
                                    {{ tag.name }}
                                </span>
                            </div>
                            <div
                                class="flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400"
                            >
                                <span>{{
                                    formatTime(question.created_at)
                                }}</span>
                            </div>
                        </div>
                    </div>
                </article>
            </div>

            <!-- Answers Section -->
            <div class="space-y-4" v-if="!questionOrAnswer">
                <h2 class="text-xl font-bold text-zinc-900 dark:text-zinc-50">
                    Recent Answers
                </h2>

                <div
                    v-if="answers.length === 0"
                    class="rounded-xl border border-zinc-200 bg-white p-8 text-center dark:border-zinc-800 dark:bg-zinc-900"
                >
                    <p class="text-zinc-600 dark:text-zinc-400">
                        No answers yet. Start answering questions to help the
                        community!
                    </p>
                </div>

                <article
                    v-for="answer in answers"
                    :key="answer.id"
                    class="group rounded-xl border border-zinc-200 bg-white p-6 shadow-sm transition hover:shadow-md dark:border-zinc-800 dark:bg-zinc-900"
                >
                    <div class="space-y-3">
                        <Link
                            :href="
                                route('questions.detail', answer.question.id)
                            "
                            class="block text-lg leading-snug font-semibold text-zinc-900 transition hover:text-sky-600 dark:text-zinc-50 dark:hover:text-sky-400"
                        >
                            {{ answer.question.title }}
                        </Link>
                        <p
                            class="line-clamp-3 text-sm text-zinc-600 dark:text-zinc-400"
                        >
                            {{ answer.body }}
                        </p>
                        <div class="flex flex-wrap items-center gap-2">
                            <span
                                v-for="tag in answer.question.tags"
                                :key="tag.id"
                                class="rounded-full bg-zinc-100 px-3 py-1 text-xs font-semibold text-zinc-700 transition hover:bg-sky-50 hover:text-sky-600 dark:bg-zinc-800 dark:text-zinc-200 dark:hover:bg-sky-500/10 dark:hover:text-sky-200"
                            >
                                {{ tag.name }}
                            </span>
                        </div>
                        <div
                            class="flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400"
                        >
                            <span
                                >Answered
                                {{ formatTime(answer.created_at) }}</span
                            >
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</template>

<style></style>
