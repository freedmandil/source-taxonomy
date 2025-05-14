<template>
    <Modal
        :model-value="modelValue"
        @update:modelValue="$emit('update:modelValue', $event)"
        @submit="handleSubmit"
        @success="handleSuccess"
    >
        <template #title>Add Topic</template>

        <Input v-model="form.name_english" label="Name (English)" />
        <Input v-model="form.name_hebrew" label="Name (Hebrew)" />
    </Modal>
</template>

<script setup>
import { ref } from 'vue'
import Modal from './form/Modal.vue'

const props = defineProps({ modelValue: Boolean })
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
