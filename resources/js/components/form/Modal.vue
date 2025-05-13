<template>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" v-if="$slots.title"> {{ $slots.title() }} </h5>
                <button type="button" class="btn-close" @click="emitUpdate(false)"></button>
            </div>
            <div class="modal-body">
                <slot />
            </div>
            <div class="modal-footer">
                <button
                    class="btn btn-secondary"
                    @click="emitUpdate(false)"
                >
                    Cancel
                </button>
                <button
                    class="btn btn-primary"
                    @click="handleSubmit"
                >
                    Submit
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'

const props = defineProps({
    modelValue: Boolean,
    textOptions: Array,
    keywordOptions: Array,
    subtopicOptions: Array,
    topicOptions: Array
})

const emit = defineEmits(['update:modelValue', 'submit', 'success'])

const emitUpdate = (value) => {
    emit('update:modelValue', value)
}

const handleSubmit = () => {
    // This is where you'd add custom validation logic for each modal
    emit('submit')
}
</script>
