<template>
    <div :class="['mb-1', rtl ? 'text-end' : 'text-start', wrapperClass]">
        <label
            v-if="label"
            :for="id"
            :class="['block fw-bold mb-0 p-2 pb-1 text-sm', labelClass]"
            :dir="dir"
            :style="rtl ? 'text-align: right;' : ''"
        >

            <bdi>{{ label }}</bdi>
        </label>

        <textarea
            v-bind="$attrs"
            :id="id"
            :class="['form-control input w-full', textareaClass]"
            :value="modelValue"
            :dir="dir"
            :style="rtl ? 'text-align: right;' : ''"
            @input="$emit('update:modelValue', $event.target.value)"
            :rows="rows"
        />

        <p v-if="error" class="text-sm text-danger mt-1">
            {{ error }}
        </p>
    </div>
</template>

<script setup>
import Input from "./Input.vue";

defineProps({
    modelValue: String,
    label: String,
    rows: {
        type: [Number, String],
        default: 3
    },
    wrapperClass: {
        type: [String, Array, Object],
        default: ''
    },
    labelClass: {
        type: [String, Array, Object],
        default: ''
    },
    textareaClass: {
        type: [String, Array, Object],
        default: ''
    }
})
defineEmits(['update:modelValue'])
</script>
