<template>
    <button
        :type="resolvedType"
        :class="['btn', variantClass, 'd-inline-flex', 'align-items-center']"
        :form="form"
        :disabled="disabled || loading"
        @click="handleClick"
        v-bind="$attrs"
    >
    <span v-if="loading">
      <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
      {{ loadingText }}
    </span>
        <template v-else>
            <slot>{{ resolvedText }}</slot>
        </template>
    </button>
</template>

<script setup lang="ts">
import { computed, defineProps, defineEmits } from 'vue'

const props = defineProps<{
    action?: string
    variant?: string
    text?: string
    type?: string
    form?: string | null
    disabled?: boolean
    loading?: boolean
}>()

const emit = defineEmits<{
    (e: 'cancel'): void
}>()

const variantMap: Record<string, string> = {
    submit: 'primary',
    save: 'success',
    cancel: 'secondary',
    delete: 'danger',
    'open-modal': 'outline-secondary',
    default: 'secondary',
}

const textMap: Record<string, string> = {
    submit: 'Submit',
    save: 'Save',
    cancel: 'Cancel',
    delete: 'Delete',
    'open-modal': 'Open',
    default: 'Button',
}

const loadingTextMap: Record<string, string> = {
    submit: 'Submitting…',
    save: 'Saving…',
    delete: 'Deleting…',
    default: 'Loading…',
}

const resolvedType = computed(() => {
    if (props.type) return props.type
    if (props.action === 'submit' || props.action === 'save') return 'submit'
    return 'button'
})

const variantClass = computed(() => {
    return props.variant
        ? `btn-${props.variant}`
        : `btn-${variantMap[props.action || ''] || variantMap.default}`
})

const resolvedText = computed(() => {
    return props.text || textMap[props.action || ''] || textMap.default
})

const loadingText = computed(() => {
    return loadingTextMap[props.action || ''] || loadingTextMap.default
})

function handleClick() {
    if (props.action === 'cancel') {
        emit('cancel')
    }
}
</script>
