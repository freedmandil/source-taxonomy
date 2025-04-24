<template>
    <ModalForm
        :model-value="modelValue"
        @update:modelValue="$emit('update:modelValue', $event)"
        @submit="handleSubmit"
        @success="handleSuccess"
    >
        <template #title>Add Reference</template>

        <Dropdown
            v-model="form.reference_type"
            label="Reference Type"
            :options="referenceTypes"
            :clearable="false"
        />
        <Input v-model="form.text_value" label="Text Value" />
        <Input v-model="form.position" type="number" label="Integer Value (optional)" />
    </ModalForm>
</template>

<script setup>
import { ref } from 'vue'
import ModalForm from './ModalForm.vue'

const props = defineProps({
    modelValue: Boolean
})
const emit = defineEmits(['update:modelValue', 'success'])

const referenceTypes = [
    { value: 'volume', label: 'Volume' },
    { value: 'column', label: 'Column' },
    { value: 'siman', label: 'Siman' },
    { value: 'seif', label: 'Seif' },
    { value: 'commentary', label: 'Commentary' },
    { value: 'seif_katan', label: 'Seif Katan' },
    { value: 'mishnah', label: 'Mishnah' },
    { value: 'perek', label: 'Perek' },
    { value: 'number', label: 'Number' },
    { value: 'halacha', label: 'Halacha' },
    { value: 'letter', label: 'Letter' },
    { value: 'section', label: 'Section' },
    { value: 'commentary_section', label: 'Commentary Section' },
    { value: 'commentary_subsection', label: 'Commentary Subsection' },
    { value: 'dh', label: 'DH' },
    { value: 'pasuk', label: 'Pasuk' },
    { value: 'line', label: 'Line' },
    { value: 'page', label: 'Page' },
    { value: 'footnote', label: 'Footnote' },
    { value: 'paragraph', label: 'Paragraph' },
]

const form = ref({
    reference_type: '',
    text_value: '',
    position: null
})

const handleSubmit = () => {
    return new Promise((resolve, reject) => {
        if (!form.value.reference_type || !form.value.text_value) {
            return reject('Reference type and value are required.')
        }
        resolve({ ...form.value })
    })
}

const handleSuccess = (data) => {
    emit('success', data)
    form.value.reference_type = ''
    form.value.text_value = ''
    form.value.position = null
}
</script>
