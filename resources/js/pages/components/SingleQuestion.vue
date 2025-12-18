<script setup>
import useFilter from '@/composables/useFilter';
import { Link } from '@inertiajs/vue3';
import formatTime from '../../composables/formatDate';

let { search, slug } = useFilter();
let { questions, filters } = defineProps({
    questions: Array,
    filters: Object,
});
</script>
<template>
    <article
        v-for="question in questions"
        :key="question.id"
        class="group cursor-pointer rounded-2xl border border-zinc-200 bg-white/90 p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-zinc-800 dark:bg-zinc-900/80"
    >
        <div class="flex gap-4">
            <div
                class="flex w-24 shrink-0 flex-col items-start gap-2 text-xs font-semibold text-zinc-500 dark:text-zinc-400"
            >
                <div
                    class="rounded-lg bg-sky-500/10 px-3 py-2 text-center text-sky-600 ring-1 ring-sky-500/30 dark:text-sky-200"
                >
                    {{ question.votes }} votes
                </div>
                <div
                    class="rounded-lg bg-emerald-500/10 px-3 py-2 text-center text-emerald-600 ring-1 ring-emerald-500/30 dark:text-emerald-200"
                >
                    {{ question.answers_count }} answers
                </div>
                <div
                    class="rounded-lg bg-zinc-100 px-3 py-2 text-center text-zinc-700 ring-1 ring-zinc-200 dark:bg-zinc-800 dark:text-zinc-200 dark:ring-zinc-700"
                >
                    {{ question.views }} views
                </div>
            </div>
            <div class="flex-1 space-y-2">
                <Link
                    :href="route('questions.detail', question.id)"
                    class="text-xl leading-snug font-semibold text-zinc-900 transition group-hover:text-sky-600 dark:text-zinc-50"
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
                <div
                    class="flex items-center gap-3 text-xs text-zinc-500 dark:text-zinc-400"
                >
                    <span class="flex items-center gap-2">
                        <span
                            class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-gradient-to-br from-sky-500 to-indigo-500 text-[10px] font-bold text-white"
                        >
                            {{ question.author.name.slice(0, 2).toUpperCase() }}
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
            </div>
        </div>
    </article>
</template>

<style></style>
