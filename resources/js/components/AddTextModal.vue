<template>
    <ModalForm
        :model-value="modelValue"
        @update:modelValue="$emit('update:modelValue', $event)"
        @submit="handleSubmit"
        @success="handleSuccess"
    >
        <template #title>Add Text Entry</template>

        <Dropdown v-model="form.sefer_id" label="Sefer" :options="seferOptions" />
        <Input v-model="form.section" label="Section / Siman (optional)" />
        <Input v-model="form.subsection" label="Subsection / Seif (optional)" />
        <Input v-model="form.note" label="Note" type="textarea" />
    </ModalForm>
</template>

<script setup>
import { ref } from 'vue'
import ModalForm from './ModalForm.vue'

const props = defineProps({
    modelValue: Boolean,
    seferOptions: Array
})
const emit = defineEmits(['update:modelValue', 'success'])

const form = ref({
    sefer_id: null,
    section: '',
    subsection: '',
    note: ''
})

const handleSubmit = () => {
    return new Promise((resolve, reject) => {
        if (!form.value.sefer_id) return reject('Sefer is required.')
        resolve({ ...form.value })
    })
}

const handleSuccess = (data) => {
    emit('success', data)
    form.value.sefer_id = null
    form.value.section = ''
    form.value.subsection = ''
    form.value.note = ''
}
</script>
