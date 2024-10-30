<!-- resources/js/Components/Card.vue -->

<template>
    <div
        class="border border-slate-600 rounded-lg p-4 cursor-pointer hover:bg-slate-700 transition"
        @click="selectModel"
    >
        <h3 class="text-lg font-semibold text-white">{{ model.name }}</h3>
        <p class="text-gray-400 text-sm">{{ model.description }}</p>
    </div>
</template>

<script setup>
const props = defineProps({
    model: Object,
});
const emit = defineEmits(['select']);

const selectModel = () => {
    emit('select', props.model);
};
</script>
