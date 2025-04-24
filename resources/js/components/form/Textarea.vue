<template>
    <div>
        <label v-if="label" class="block mb-1 text-sm font-medium">{{ label }}</label>
        <textarea
            class="input w-full"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            rows="3"
        ></textarea>
    </div>
</template>

<script setup>
defineProps({
    modelValue: String,
    label: String,
})
defineEmits(['update:modelValue'])
</script>
