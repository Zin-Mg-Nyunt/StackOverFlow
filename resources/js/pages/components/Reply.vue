<script setup>
import formatTime from '@/composables/formatDate';
import { titleCase } from '@/composables/titleCase';
import useLike from '@/composables/useLike.js';
import useReply from '@/composables/useReply.js';

const { reply } = defineProps({
    reply: {
        type: Object,
        required: true,
    },
});

const { like, processing } = useLike();
const {
    loadReply,
    handleReply,
    replies,
    isReplying,
    replyBody,
    submitting,
    isLoaded,
} = useReply();
</script>

<template>
    <div>
        <div class="border-l-2 border-zinc-200 py-3 pl-4 dark:border-zinc-700">
            <div class="flex items-start gap-3">
                <!-- Author Info -->
                <div class="flex w-full items-start gap-4">
                    <img
                        class="h-7 w-7 rounded-full"
                        v-if="reply.author.profile_photo_path"
                        :src="reply.author.profile_photo_path"
                        alt=""
                    />
                    <span
                        v-else
                        class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-gradient-to-br from-sky-500 to-indigo-500 text-xs font-bold text-white"
                    >
                        {{ reply.author?.name.slice(0, 2).toUpperCase() }}
                    </span>
                    <div class="w-full">
                        <div class="flex items-center gap-3 text-xs">
                            <p
                                class="w-auto shrink-1 rounded-sm bg-sky-500/10 p-1 text-sky-600 dark:text-sky-200"
                            >
                                {{
                                    titleCase(reply.author?.name) || 'Anonymous'
                                }}
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
                                        reply.isLiked
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
                                    @click="isReplying = !isReplying"
                                >
                                    Reply
                                </button>
                            </div>

                            <!-- to show reply section -->
                            <div class="flex flex-col gap-2">
                                <!-- before taking replies -->
                                <template v-if="!isLoaded">
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
                                        <span
                                            class="h-1 w-1 rounded-full bg-zinc-600"
                                        ></span>
                                        {{ reply.total_replies_count }} Reply
                                    </span>
                                    <span
                                        class="cursor-pointer text-sm text-zinc-600 dark:text-zinc-400"
                                        v-if="reply.total_replies_count > 1"
                                        @click="loadReply(reply.id)"
                                    >
                                        View all
                                        {{ reply.total_replies_count }} replies
                                    </span>
                                </template>
                                <!-- after taking replies -->
                                <div v-if="replies.data.length > 0">
                                    <Reply
                                        v-for="reply in replies.data"
                                        :key="reply.id"
                                        :reply="reply"
                                    />
                                </div>
                            </div>

                            <!-- reply input box -->
                            <div v-if="isReplying" class="mt-4">
                                <textarea
                                    v-model="replyBody"
                                    placeholder="Write your reply..."
                                    rows="3"
                                    class="w-full rounded-lg border border-zinc-200 bg-zinc-50 p-3 text-sm text-zinc-900 shadow-sm transition focus:border-sky-400 focus:bg-white focus:outline-none dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100 dark:placeholder-zinc-400 dark:focus:bg-zinc-900"
                                    :disabled="submitting"
                                ></textarea>
                                <div class="flex justify-end gap-2">
                                    <button
                                        type="button"
                                        class="rounded-md px-4 py-1.5 text-xs font-medium text-zinc-600 transition hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-700"
                                        @click="isReplying = false"
                                        :disabled="submitting"
                                    >
                                        Cancel
                                    </button>
                                    <button
                                        type="submit"
                                        class="rounded-md bg-sky-600 px-4 py-1.5 text-xs font-semibold text-white shadow transition hover:bg-sky-700 dark:bg-sky-500 dark:hover:bg-sky-600"
                                        :disabled="
                                            submitting || !replyBody.trim()
                                        "
                                        @click="
                                            handleReply(
                                                reply.id,
                                                reply.question_id,
                                            )
                                        "
                                    >
                                        <span v-if="submitting"
                                            >Posting...</span
                                        >
                                        <span v-else>Post Reply</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style></style>
