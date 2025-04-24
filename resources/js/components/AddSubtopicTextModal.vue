<template>
    <ModalForm
        :model-value="modelValue"
        @update:modelValue="$emit('update:modelValue', $event)"
        @submit="handleSubmit"
        @success="handleSuccess"
    >
        <template #title>Add Subtopic to Text</template>

        <Dropdown v-model="form.text_id" label="Text" :options="textOptions" />
        <Dropdown v-model="form.subtopic_id" label="Subtopic" :options="subtopicOptions" />
        <Input v-model="form.note" label="Note (optional)" type="textarea" />
    </ModalForm>
</template>

<script setup>
import { ref } from 'vue'
import ModalForm from './ModalForm.vue'

const props = defineProps({
    modelValue: Boolean,
    textOptions: Array,
    subtopicOptions: Array
})
const emit = defineEmits(['update:modelValue', 'success'])

const form = ref({
    text_id: null,
    subtopic_id: null,
    note: ''
})

const handleSubmit = () => {
    return new Promise((resolve, reject) => {
        if (!form.value.text_id || !form.value.subtopic_id) {
            return reject('Both Text and Subtopic are required.')
        }
        resolve({ ...form.value })
    })
}

const handleSuccess = (data) => {
    emit('success', data)
    form.value.text_id = null
    form.value.subtopic_id = null
    form.value.note = ''
}
</script>
