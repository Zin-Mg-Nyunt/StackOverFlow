<script setup>
import { titleCase } from '@/composables/titleCase.js';
import useFilter from '@/composables/useFilter';
import { InfiniteScroll, Link, router } from '@inertiajs/vue3';
import { inject } from 'vue';
import formatTime from '../../composables/formatDate';
import DeleteQuestionModal from './DeleteQuestionModal.vue';

const route = inject('route');
let { search, slug } = useFilter();
let { questions, filters } = defineProps({
    questions: Object,
    filters: Object,
});

const handleEdit = (questionSlug) => {
    router.get(route('question.edit', questionSlug));
};

const handleDelete = (questionId) => {
    router.delete(route('question.delete', questionId));
};
</script>
<template>
    <InfiniteScroll data="questions">
        <article
            v-for="question in questions.data"
            :key="question.id"
            class="group mt-4 cursor-pointer rounded-2xl border border-zinc-200 bg-white/90 p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-zinc-800 dark:bg-zinc-900/80"
        >
            <div class="flex gap-4">
                <div
                    class="flex w-24 shrink-0 flex-col items-start gap-2 text-xs font-semibold text-zinc-500 dark:text-zinc-400"
                >
                    <div
                        class="rounded-lg bg-sky-500/10 px-3 py-2 text-center text-sky-600 ring-1 ring-sky-500/30 dark:text-sky-200"
                    >
                        {{ question.votes_count ?? 0 }} votes
                    </div>
                    <div
                        class="rounded-lg bg-emerald-500/10 px-3 py-2 text-center text-emerald-600 ring-1 ring-emerald-500/30 dark:text-emerald-200"
                    >
                        {{ question.answers_count ?? 0 }} answers
                    </div>
                    <div
                        class="rounded-lg bg-zinc-100 px-3 py-2 text-center text-zinc-700 ring-1 ring-zinc-200 dark:bg-zinc-800 dark:text-zinc-200 dark:ring-zinc-700"
                    >
                        {{ question.views ?? 0 }} views
                    </div>
                </div>
                <div class="flex-1 space-y-2">
                    <Link
                        :href="route('questions.detail', question.slug)"
                        class="text-xl leading-snug font-semibold text-zinc-900 transition group-hover:text-sky-600 dark:text-zinc-50"
                    >
                        {{ titleCase(question.title) }}
                    </Link>
                    <p
                        class="line-clamp-2 text-sm text-zinc-600 dark:text-zinc-400"
                    >
                        {{ question.body }}
                    </p>
                    <div class="flex flex-wrap items-center gap-2">
                        <span
                            v-for="tag in question.tags"
                            :key="tag"
                            class="rounded-full px-3 py-1 text-xs font-semibold transition hover:bg-sky-50 hover:text-sky-600 dark:hover:bg-sky-500/10 dark:hover:text-sky-200"
                            :class="
                                filters.tag == tag.slug
                                    ? 'bg-sky-50 text-sky-600 dark:bg-sky-500/10 dark:text-sky-200'
                                    : 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200'
                            "
                            @click="slug = tag.slug"
                        >
                            {{ tag.name }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div
                            class="flex items-center gap-3 text-xs text-zinc-500 dark:text-zinc-400"
                        >
                            <span class="flex items-center gap-2">
                                <img
                                    class="h-6 w-6 rounded-full"
                                    v-if="question.author.profile_photo_path"
                                    :src="question.author.profile_photo_path"
                                    alt=""
                                />
                                <span
                                    v-else
                                    class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-gradient-to-br from-sky-500 to-indigo-500 text-[10px] font-bold text-white"
                                >
                                    {{
                                        question.author.name
                                            .slice(0, 2)
                                            .toUpperCase()
                                    }}
                                </span>
                                <span
                                    class="font-semibold text-zinc-700 dark:text-zinc-200"
                                    >{{ question.author.name }}</span
                                >
                            </span>
                            <span
                                class="h-1 w-1 rounded-full bg-zinc-300 dark:bg-zinc-600"
                            />
                            <span>{{ formatTime(question.created_at) }}</span>
                        </div>
                        <div
                            class="flex items-center gap-2"
                            v-if="question.authorized"
                        >
                            <button
                                @click.stop="handleEdit(question.slug)"
                                class="flex items-center gap-1.5 rounded-lg border border-zinc-200 bg-white px-3 py-1.5 text-xs font-semibold text-zinc-700 transition hover:border-sky-400 hover:bg-sky-50 hover:text-sky-600 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:border-sky-500 dark:hover:bg-sky-500/10 dark:hover:text-sky-400"
                                title="Edit question"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-3.5 w-3.5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                    />
                                </svg>
                                Edit
                            </button>
                            <DeleteQuestionModal
                                :question-title="question.title"
                                @confirm="handleDelete(question.id)"
                            >
                                <button
                                    @click.stop
                                    class="flex items-center gap-1.5 rounded-lg border border-zinc-200 bg-white px-3 py-1.5 text-xs font-semibold text-red-600 transition hover:border-red-400 hover:bg-red-50 hover:text-red-700 dark:border-zinc-700 dark:bg-zinc-800 dark:text-red-400 dark:hover:border-red-500 dark:hover:bg-red-500/10 dark:hover:text-red-300"
                                    title="Delete question"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-3.5 w-3.5"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                        />
                                    </svg>
                                    Delete
                                </button>
                            </DeleteQuestionModal>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </InfiniteScroll>
</template>

<style></style>
