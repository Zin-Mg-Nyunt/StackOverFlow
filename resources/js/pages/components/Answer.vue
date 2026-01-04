<script setup>
import formatTime from '@/composables/formatDate';
import useLike from '@/composables/useLike.js';
import useReply from '@/composables/useReply';
import Vote from '../components/Vote.vue';
import Reply from './Reply.vue';

const { answers } = defineProps({ answers: Array });

let { like, processing } = useLike();
let { loadReply, replies } = useReply();
</script>
<template>
    <div
        v-for="answer in answers"
        :key="answer.id"
        :id="'answer-' + answer.id"
        class="rounded-2xl border border-zinc-200 bg-white/90 shadow-sm dark:border-zinc-800 dark:bg-zinc-900/80"
    >
        <div class="flex gap-6 p-6">
            <!-- Voting Section -->
            <div class="flex w-16 shrink-0 flex-col items-center gap-4">
                <Vote
                    :userVote="answer.user_vote?.value"
                    :id="answer.id"
                    type="answer"
                    :upvotesCount="answer.upvotes_count"
                    :downvotesCount="answer.downvotes_count"
                />
            </div>

            <!-- Answer Body -->
            <div class="flex-1 space-y-4">
                <div
                    class="prose prose-zinc dark:prose-invert prose-p:text-zinc-700 dark:prose-p:text-zinc-300 prose-code:text-sky-600 dark:prose-code:text-sky-400 max-w-none"
                >
                    <p class="text-zinc-700 dark:text-zinc-300">
                        {{ answer.body }}
                    </p>
                </div>

                <!-- Answer Actions -->
                <div
                    class="flex flex-wrap items-center justify-between gap-4 border-t border-zinc-200 pt-4 dark:border-zinc-800"
                >
                    <div class="flex flex-wrap items-center gap-4">
                        <button
                            class="cursor-pointer text-sm transition hover:text-sky-600 dark:hover:text-sky-400"
                            @click="like('answer', answer.id)"
                            :class="
                                answer.likedUser
                                    ? 'text-sky-600 dark:text-sky-400'
                                    : 'text-zinc-600 dark:text-zinc-400'
                            "
                        >
                            {{
                                answer.likes_count == 0
                                    ? 'Like'
                                    : `${answer.likes_count} Like${answer.likes_count > 1 ? 's' : ''}`
                            }}
                        </button>
                        <button
                            v-if="answer.authorized"
                            class="cursor-pointer text-sm text-zinc-600 transition hover:text-sky-600 dark:text-zinc-400 dark:hover:text-sky-400"
                        >
                            Edit
                        </button>
                        <button
                            class="cursor-pointer text-sm text-zinc-600 transition hover:text-sky-600 dark:text-zinc-400 dark:hover:text-sky-400"
                        >
                            Reply
                        </button>
                    </div>

                    <!-- Author Info -->
                    <div
                        class="rounded-lg bg-sky-50/50 px-4 py-3 dark:bg-sky-500/5"
                    >
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">
                            answered
                            <span
                                class="font-semibold text-zinc-700 dark:text-zinc-300"
                            >
                                {{ formatTime(answer.created_at) }}
                            </span>
                        </p>
                        <div class="mt-2 flex items-center gap-2">
                            <span
                                class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-br from-sky-500 to-indigo-500 text-xs font-bold text-white"
                            >
                                {{
                                    answer.author?.name
                                        .slice(0, 2)
                                        .toUpperCase()
                                }}
                            </span>
                            <div>
                                <p
                                    class="text-sm font-semibold text-zinc-900 dark:text-zinc-50"
                                >
                                    {{ answer.author?.name || 'Anonymous' }}
                                </p>
                                <p
                                    class="text-xs text-zinc-500 dark:text-zinc-400"
                                >
                                    5,678 reputation
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- to show reply section -->
                <div class="flex items-center gap-2">
                    <!-- before taking replies -->
                    <template v-if="!replies[answer.id]">
                        <span
                            class="flex cursor-pointer items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400"
                            v-if="
                                answer.total_replies_count === 1 &&
                                answer.latest_reply
                            "
                            @click="loadReply(answer.id)"
                        >
                            {{ answer.latest_reply.author.name }}
                            replied
                            <span
                                class="h-1 w-1 rounded-full bg-zinc-600"
                            ></span>
                            {{ answer.total_replies_count }} Reply
                        </span>
                        <span
                            class="cursor-pointer text-sm text-zinc-600 dark:text-zinc-400"
                            v-if="answer.total_replies_count > 1"
                            @click="loadReply(answer.id)"
                        >
                            View all {{ answer.total_replies_count }} replies
                        </span>
                    </template>
                    <!-- after taking replies -->
                    <div v-else>
                        <Reply :answerReplies="replies[answer.id].data" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style></style>
