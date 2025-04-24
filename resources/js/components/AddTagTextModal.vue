<template>
    <ModalForm
        :model-value="modelValue"
        @update:modelValue="$emit('update:modelValue', $event)"
        @submit="handleSubmit"
        @success="handleSuccess"
    >
        <template #title>Add Tag to Text</template>

        <Dropdown v-model="form.text_id" label="Text" :options="textOptions" />
        <Dropdown v-model="form.tag_id" label="Tag" :options="tagOptions" />
        <Input v-model="form.note" label="Note (optional)" type="textarea" />
    </ModalForm>
</template>

<script setup>
import { ref } from 'vue'
import ModalForm from './ModalForm.vue'

const props = defineProps({
    modelValue: Boolean,
    textOptions: Array,
    tagOptions: Array
})
const emit = defineEmits(['update:modelValue', 'success'])

const form = ref({
    text_id: null,
    tag_id: null,
    note: ''
})

const handleSubmit = () => {
    return new Promise((resolve, reject) => {
        if (!form.value.text_id || !form.value.tag_id) {
            return reject('Both Text and Tag are required.')
        }
        resolve({ ...form.value })
    })
}

const handleSuccess = (data) => {
    emit('success', data)
    form.value.text_id = null
    form.value.tag_id = null
    form.value.note = ''
}
</script>
