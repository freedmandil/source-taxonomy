<template>
    <div :class="['p-2', wrapperClass]">
        <label v-if="label" :class="['block mb-1 text-sm fw-bold p-2 pb-1', labelClass]">{{ label }}</label>
        <select
            :class="['form-select input w-full p-2', selectClass]"
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
// Props for styling overrides
defineProps({
    modelValue: [String, Number],
    label: String,
    options: {
        type: Array,
        default: () => [],
    },
    wrapperClass: {
        type: [String, Array, Object],
        default: ''
    },
    labelClass: {
        type: [String, Array, Object],
        default: ''
    },
    selectClass: {
        type: [String, Array, Object],
        default: ''
    }
})

defineEmits(['update:modelValue'])
</script>

