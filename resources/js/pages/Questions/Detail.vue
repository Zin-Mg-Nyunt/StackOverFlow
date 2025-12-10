<script setup>
let { question } = defineProps({
    question: Object,
});
</script>
<template>
    <h1>{{ question.title }}</h1>
</template>

<style></style>
