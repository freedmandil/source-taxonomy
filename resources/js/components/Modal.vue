<!-- Modal.vue -->
<template>
    <div
        class="modal fade"
        tabindex="-1"
        :class="{ show: modelValue }"
        :style="{ display: modelValue ? 'block' : 'none' }"
        ref="modal"
        @click.self="handleBackdropClick"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <slot name="title"><h5 class="modal-title">Modal Title</h5></slot>
                    <button type="button" class="btn-close" @click="close"></button>
                </div>
                <div class="modal-body">
                    <slot name="body">Modal Body</slot>
                </div>
                <div class="modal-footer">
                    <slot name="footer">
                        <button class="btn btn-secondary" @click="close">Close</button>
                    </slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { watch, ref } from 'vue'

const props = defineProps({
    modelValue: { type: Boolean, required: true }
})
const emit = defineEmits(['update:modelValue'])

const modal = ref(null)

watch(
    () => props.modelValue,
    (val) => {
        if (val) {
            document.body.classList.add('modal-open')
        } else {
            document.body.classList.remove('modal-open')
        }
    }
)

const close = () => {
    emit('update:modelValue', false)
}

const handleBackdropClick = () => {
    close()
}
</script>

<style scoped>
.modal {
    background: rgba(0, 0, 0, 0.5);
}
</style>
