<template>
    <div :class="['mb-1', rtl ? 'text-end' : 'text-start', wrapperClass]">
        <label
            v-if="label"
            :for="id"
            :class="['block fw-bold mb-0 p-2 pb-1', { 'text-danger': error }, labelClass]"
            :dir="dir"
            :style="rtl ? 'text-align: right;' : ''"
        >

            <bdi>{{ label }}</bdi>
        </label>

        <input
            v-bind="$attrs"
            :id="id"
            :type="type"
            :class="['form-control w-100', inputClass, { 'is-invalid': error }]"
            :value="modelValue"
            :dir="dir"
            :style="rtl ? 'text-align: right;' : ''"
            @input="$emit('update:modelValue', $event.target.value)"
        />

        <p v-if="error" class="invalid-feedback d-block mt-1">
            {{ error }}
        </p>
    </div>
</template>

<script setup>

defineProps({
    modelValue: [String, Number],
    label: String,
    type: {
        type: String,
        default: 'text',
    },
    id: String,
    error: String,
    dir: {
        type: String,
        default: 'ltr' // can be overridden to 'rtl'
    },
    rtl: {
        type: Boolean,
        default: false // when true, also sets text-align: right
    },
    labelClass: {
        type: String,
        default: ''
    },
    inputClass: {
        type: String,
        default: ''
    },
    wrapperClass: {
        type: [String, Array, Object],
        default: ''
    }
});
</script>
