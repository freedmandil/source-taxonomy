<template>
    <div class="mb-4">
        <label v-if="label" :for="id" class="block font-medium mb-1">
            {{ label }}
        </label>

        <input
            v-bind="$attrs"
            :id="id"
            :type="type"
            class="input w-full"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
        />

        <p v-if="error" class="text-sm text-red-600 mt-1">
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
});
</script>
