<template>
    <div
        aria-live="polite"
        aria-atomic="true"
        class="position-fixed bottom-0 end-0 p-3"
        style="z-index: 1100"
    >
        <div
            ref="toast"
            class="toast align-items-center text-white bg-success border-0"
            role="alert"
            aria-live="assertive"
            aria-atomic="true"
        >
            <div class="d-flex">
                <div class="toast-body">
                    {{ message }}
                </div>
                <button
                    type="button"
                    class="btn-close btn-close-white me-2 m-auto"
                    data-bs-dismiss="toast"
                    aria-label="Close"
                ></button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { onMounted, defineExpose } from 'vue'

const props = defineProps({
    message: {
        type: String,
        required: true,
    },
    showTrigger: {
        type: Boolean,
        default: false,
    },
})

const toast = ref(null)
let bsToast = null

onMounted(() => {
    if (toast.value) {
        bsToast = new bootstrap.Toast(toast.value, { delay: 3000 })
        if (props.showTrigger) bsToast.show()
    }
})

watch(() => props.showTrigger, (newVal) => {
    if (newVal && bsToast) {
        bsToast.show()
    }
})

// Optional: expose show method if you want to trigger manually
defineExpose({
    show: () => {
        if (bsToast) bsToast.show()
    }
})
</script>
