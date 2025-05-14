<!-- resources/js/components/form/Modal.vue -->
<template>
    <div
        class="modal fade"
        tabindex="-1"
        ref="modalRef"
        role="dialog"
        @click.self="hideModal"
        :inert="!modelValue ? true : null"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header bg-dark text-white">
                    <slot name="title">
                        <h5 class="modal-title">Modal Title</h5>
                    </slot>
                    <button type="button" class="btn-close" @click="hideModal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <slot name="body">Modal Body</slot>
                </div>

                <!-- Modal Footer (outside modal-body) -->
                <div class="modal-footer w-100 d-flex justify-content-end gap-2 px-3 py-2 bg-light border-top rounded-bottom">
                    <slot name="footer">
                        <Button
                            action="cancel"
                            text="Cancel"
                        />
                    </slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, onMounted, onBeforeUnmount, inject} from 'vue'
import * as bootstrap from 'bootstrap'
import { useModalStack } from '@/utils/modalStack'
import Button from "./Button.vue";


const props = defineProps({
    modelValue: { type: Boolean, required: true },
    closeOnSuccess: { type: Boolean, default: true }
})

const insideForm = inject('insideForm', false)
const emit = defineEmits(['update:modelValue'])


const modalRef = ref(null)
let modalInstance = null
const { push, pop } = useModalStack()
const stackIndex = ref(0)

onMounted(() => {
    modalInstance = new bootstrap.Modal(modalRef.value, {
        backdrop: 'static',
        keyboard: true,
        focus: true,
    })

    watch(
        () => props.modelValue,
        (val) => {
            if (val) {
                stackIndex.value = push()
                addBackdropZIndex(stackIndex.value)
                modalInstance.show()
            } else {
                modalInstance.hide()
            }
        },
        { immediate: true }
    )

    modalRef.value.addEventListener('hidden.bs.modal', () => {
        pop()
        cleanupModalStack()
        cleanupBackdrop()
        emit('update:modelValue', false)
    })
})

function hideModal() {
    modalInstance?.hide()
    emit('update:modelValue', false)
}

onBeforeUnmount(() => {
    modalInstance?.dispose()
})

function cleanupModalStack() {
    const modals = Array.from(document.querySelectorAll('.modal.show'))
    modals.forEach(modal => modal.classList.remove('blurred-back'))

    if (modals.length > 1) {
        const previous = modals[modals.length - 2]
        previous.classList.add('blurred-back')
    }

    const backdrops = document.querySelectorAll('.modal-backdrop')
    if (backdrops.length > modals.length) {
        backdrops.forEach((bd, i) => {
            if (i >= modals.length) bd.remove()
        })
    }
}

function addBackdropZIndex(index) {
    setTimeout(() => {
        const backdrop = document.querySelector('.modal-backdrop')
        if (backdrop) {
            backdrop.style.zIndex = 1040 + index * 10
        }
        if (modalRef.value) {
            modalRef.value.style.zIndex = 1050 + index * 10
        }

        const modals = document.querySelectorAll('.modal.show:not(.fade-out)')
        if (modals.length > 1) {
            const belowTop = modals[modals.length - 2]
            belowTop.classList.add('blurred-back')
        }
    }, 0)
}

function cleanupBackdrop() {
    const modals = Array.from(document.querySelectorAll('.modal.show'))
    modals.forEach(modal => modal.classList.remove('blurred-back'))

    if (modals.length > 1) {
        const newTopBelow = modals[modals.length - 2]
        newTopBelow.classList.add('blurred-back')
    }
    reassignZIndices()
}

function reassignZIndices() {
    const modals = Array.from(document.querySelectorAll('.modal.show'))
    modals.forEach((modal, i) => {
        modal.style.zIndex = 1050 + i * 10
        const backdrop = modal.previousElementSibling
        if (backdrop?.classList.contains('modal-backdrop')) {
            backdrop.style.zIndex = 1040 + i * 10
        }
    })
}
</script>
