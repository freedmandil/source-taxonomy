<template>
    <ModalForm
        :model-value="modelValue"
        @update:modelValue="$emit('update:modelValue', $event)"
        @submit="handleSubmit"
        @success="handleSuccess"
    >
        <template #title>Add Keyword</template>

        <Input v-model="form.name_english" label="Name (English)" />
        <Input v-model="form.name_hebrew" label="Name (Hebrew)" />
    </ModalForm>
</template>

<script setup>
import { ref } from 'vue'
import ModalForm from './ModalForm.vue'

const props = defineProps({
    modelValue: Boolean
})
const emit = defineEmits(['update:modelValue', 'success'])

const form = ref({
    name_english: '',
    name_hebrew: ''
})

const handleSubmit = () => {
    return new Promise((resolve, reject) => {
        if (!form.value.name_english && !form.value.name_hebrew) {
            return reject('At least one name is required')
        }
        resolve({ ...form.value })
    })
}

const handleSuccess = (data) => {
    emit('success', data)
    form.value.name_english = ''
    form.value.name_hebrew = ''
}
</script>
