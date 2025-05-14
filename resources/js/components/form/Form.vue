<template>
    <form @submit.prevent="handleSubmit">
        <slot name="title" />
        <slot name="body" />
        <slot name="footer" />
    </form>
</template>

<script setup>
const props = defineProps({
    modelValue: Object,
    resetOnSuccess: { type: Boolean, default: false },
})

const emit = defineEmits(['submit', 'success', 'update:modelValue'])

function handleSubmit() {
    emit('submit', props.modelValue)
    emit('success', props.modelValue)

    if (props.resetOnSuccess) {
        reset()
    }
}

function reset() {
    for (const key in props.modelValue) {
        props.modelValue[key] = getDefaultValue(props.modelValue[key])
    }
}

function getDefaultValue(value) {
    if (Array.isArray(value)) return []
    if (typeof value === 'object' && value !== null) return null
    if (typeof value === 'boolean') return false
    return ''
}
</script>
