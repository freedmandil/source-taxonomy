<template>
    <ModalForm
        :model-value="modelValue"
        @update:modelValue="$emit('update:modelValue', $event)"
        :form="form"
        api-endpoint="sefarim"
        @success="handleSuccess"
    >
        <template #title>Add Sefer</template>

        <Input v-model="form.hebrew_name" label="Name (Hebrew)" />
        <Input v-model="form.english_name" label="Name (English)" />
        <Input v-model="form.edition" label="Edition (Integer)" />
        <Input v-model="form.publication_year" label="Publication Year (Secular)" />
        <Select
            v-model="form.publisher_id"
            label="Publisher"
            :options="publisherOptions"
        />
    </ModalForm>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import ModalForm from './ModalForm.vue'
import axios from 'axios'

const props = defineProps({ modelValue: Boolean })
const emit = defineEmits(['update:modelValue', 'success'])

const form = ref({
    hebrew_name: '',
    english_name: '',
    publisher_id: '',
    edition: '',
    publication_year: '',
})

const publisherOptions = ref([])

onMounted(async () => {
    const { data } = await axios.get('/api/publishers')
    publisherOptions.value = data.map(pub => ({
        value: pub.id,
        label: pub.name_english || pub.name_hebrew
    }))
})

const handleSuccess = (data) => {
    emit('success', data)
    form.value = {  hebrew_name: '',
        english_name: '',
        publisher_id: '',
        edition: '',
        publication_year: '' }
    axios.post('/api/sefarim', form.value).then((response) => {
        showSuccessToast('📚 Sefer added successfully!')
    })
}
</script>
