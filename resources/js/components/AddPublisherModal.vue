<template>
    <ModalForm
        :model-value="modelValue"
        :form="form"
        api-endpoint="publishers"
        @update:modelValue="$emit('update:modelValue', $event)"
        @success="handleSuccess"
    >
        <template #title>Add Publisher</template>

        <Input v-model="form.name_hebrew" label="Name (Hebrew)" />
        <Input v-model="form.name_english" label="Name (English)" />

    </ModalForm>
</template>

<script setup>
import { ref } from 'vue'
import ModalForm from './ModalForm.vue'

const props = defineProps({ modelValue: Boolean })
const emit = defineEmits(['update:modelValue', 'success'])

const form = ref({
    name_english: '',
    name_hebrew: ''
})

const handleSuccess = (data) => {
    emit('success', data)
    form.value.name_english = ''
    form.value.name_hebrew = ''
}
</script>
