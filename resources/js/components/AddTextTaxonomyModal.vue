<template>
    <ModalForm
        :model-value="modelValue"
        @update:modelValue="$emit('update:modelValue', $event)"
        @submit="handleSubmit"
        @success="handleSuccess"
    >
        <template #title>Add Text Reference</template>

        <Dropdown v-model="form.text_id" label="Text" :options="textOptions" />
        <Dropdown v-model="form.taxonomy_id" label="Reference Type" :options="taxonomyOptions" />
        <Input v-model="form.text_value" label="Text Value (Hebrew or Reference)" />
        <Input v-model="form.int_value" label="Number (optional)" type="number" />
        <Input v-model="form.note" label="Note (optional)" type="textarea" />
    </ModalForm>
</template>

<script setup>
import { ref } from 'vue'
import ModalForm from './ModalForm.vue'

const props = defineProps({
    modelValue: Boolean,
    textOptions: Array,
    taxonomyOptions: Array
})
const emit = defineEmits(['update:modelValue', 'success'])

const form = ref({
    text_id: null,
    taxonomy_id: null,
    text_value: '',
    int_value: null,
    note: ''
})

const handleSubmit = () => {
    return new Promise((resolve, reject) => {
        if (!form.value.text_id || !form.value.taxonomy_id || !form.value.text_value) {
            return reject('All required fields must be filled.')
        }
        resolve({ ...form.value })
    })
}

const handleSuccess = (data) => {
    emit('success', data)
    form.value.text_id = null
    form.value.taxonomy_id = null
    form.value.text_value = ''
    form.value.int_value = null
    form.value.note = ''
}
</script>
