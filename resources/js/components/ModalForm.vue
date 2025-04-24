<template>
    <div class="modal fade show d-block" tabindex="-1" role="dialog" v-if="modelValue">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <slot name="title" />
                    </h5>
                    <button type="button" class="btn-close" @click="handleClose" />
                </div>
                <form @submit.prevent="handleSubmit">
                    <div class="modal-body">
                        <slot />
                    </div>
                    <div class="modal-footer">
                        <slot name="footer">
                            <button type="button" class="btn btn-secondary" @click="handleClose" :disabled="loading">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary" :disabled="loading">
                                <span v-if="loading">Saving...</span>
                                <span v-else>Save</span>
                            </button>
                        </slot>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import submitForm from '../lib/submitForm'


const props = defineProps({
    modelValue: { type: Boolean, required: true },
    form: { type: Object, required: true },
    apiEndpoint: { type: String, required: true },
    resetOnClose: { type: Boolean, default: true }
})

const emit = defineEmits(['update:modelValue', 'submit', 'success', 'close'])
const loading = ref(false)

const handleClose = () => {
    emit('update:modelValue', false)
    emit('close')
    if (props.resetOnClose) resetForm()
}

const handleSubmit = async () => {
    loading.value = true
    try {
        const result = await submitForm(props.apiEndpoint, props.form)
        emit('success', result)
        handleClose()
    } catch (e) {
        console.error(e)
    } finally {
        loading.value = false
    }
}

const resetForm = () => {
    const form = document.querySelector('form')
    if (form) form.reset()
}
</script>
