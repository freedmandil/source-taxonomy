<template>
    <div>
        <label v-if="label" class="block mb-1 text-sm font-medium">{{ label }}</label>
        <select
            class="input w-full"
            :value="modelValue"
            @change="$emit('update:modelValue', $event.target.value)"
        >
            <option v-for="(option, index) in options" :key="index" :value="option.value">
                {{ option.label }}
            </option>
        </select>
    </div>
</template>

<script setup>
defineProps({
    modelValue: [String, Number],
    label: String,
    options: {
        type: Array,
        default: () => [],
    },
})
defineEmits(['update:modelValue'])
</script>
