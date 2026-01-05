<script setup>
import formatTime from '@/composables/formatDate';
import useLike from '@/composables/useLike.js';
import useReply from '@/composables/useReply.js';

const { answerReplies } = defineProps({
    answerReplies: {
        type: Array,
        required: true,
    },
});

const { like, processing } = useLike();
const { loadReply, replies } = useReply();
</script>

<template>
    <div v-for="reply in answerReplies" :key="reply.id">
        <div class="border-l-2 border-zinc-200 py-3 pl-4 dark:border-zinc-700">
            <div class="flex items-start gap-3">
                <!-- Author Info -->
                <div class="flex shrink-0 items-start gap-4">
                    <span
                        class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-gradient-to-br from-sky-500 to-indigo-500 text-xs font-bold text-white"
                    >
                        {{ reply.author?.name.slice(0, 2).toUpperCase() }}
                    </span>
                    <div>
                        <div class="flex items-center gap-3 text-xs">
                            <p
                                class="w-auto shrink-1 rounded-sm bg-sky-500/10 p-1 text-sky-600 dark:text-sky-200"
                            >
                                {{ reply.author?.name || 'Anonymous' }}
                            </p>
                            <span class="text-zinc-500 dark:text-zinc-500">
                                {{ formatTime(reply.created_at) }}
                            </span>
                        </div>
                        <!-- Reply Body -->
                        <div class="flex-1 space-y-2">
                            <div
                                class="prose prose-sm prose-zinc dark:prose-invert prose-p:text-zinc-700 dark:prose-p:text-zinc-300 max-w-none"
                            >
                                <p
                                    class="text-sm text-zinc-700 dark:text-zinc-300"
                                >
                                    {{ reply.body }}
                                </p>
                            </div>

                            <!-- Reply Actions -->
                            <div
                                class="flex flex-wrap items-center gap-3 text-xs"
                            >
                                <button
                                    class="cursor-pointer text-sm transition hover:text-sky-600 dark:hover:text-sky-400"
                                    @click="like('answer', reply.id, reply)"
                                    :disabled="processing"
                                    :class="
                                        reply.likedUser
                                            ? 'text-sky-600 dark:text-sky-400'
                                            : 'text-zinc-600 dark:text-zinc-400'
                                    "
                                >
                                    {{
                                        reply.likes_count == 0
                                            ? 'Like'
                                            : `${reply.likes_count} Like${reply.likes_count > 1 ? 's' : ''}`
                                    }}
                                </button>
                                <button
                                    class="cursor-pointer text-zinc-600 transition hover:text-sky-600 dark:text-zinc-400 dark:hover:text-sky-400"
                                >
                                    Reply
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- to show reply section -->
            <div class="flex items-center gap-2">
                <!-- before taking replies -->
                <template v-if="!replies[reply.id]">
                    <span
                        class="flex cursor-pointer items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400"
                        v-if="
                            reply.total_replies_count === 1 &&
                            reply.latest_reply
                        "
                        @click="loadReply(reply.id)"
                    >
                        {{ reply.latest_reply.author.name }}
                        replied {{ reply.author.name }}
                        <span class="h-1 w-1 rounded-full bg-zinc-600"></span>
                        {{ reply.total_replies_count }} Reply
                    </span>
                    <span
                        class="cursor-pointer text-sm text-zinc-600 dark:text-zinc-400"
                        v-if="reply.total_replies_count > 1"
                        @click="loadReply(reply.id)"
                    >
                        View all {{ reply.total_replies_count }} replies
                    </span>
                </template>
                <!-- after taking replies -->
                <div v-else>
                    <Reply :answerReplies="replies[reply.id].data" />
                </div>
            </div>
        </div>
    </div>
</template>

<style></style>
