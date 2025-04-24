<template>
    <ModalForm
        :model-value="modelValue"
        @update:modelValue="$emit('update:modelValue', $event)"
        @submit="handleSubmit"
        @success="handleSuccess"
    >
        <template #title>Add Sub-Topic</template>

        <Dropdown
            v-model="form.topic_id"
            :options="topicOptions"
            value-key="id"
            label-key="name_english"
            label="Topic"
        />
        <Input v-model="form.name_english" label="Name (English)" />
        <Input v-model="form.name_hebrew" label="Name (Hebrew)" />
    </ModalForm>
</template>

<script setup>
import { ref, watch } from 'vue'
import ModalForm from './ModalForm.vue'

const props = defineProps({
    modelValue: Boolean,
    topics: Array
})
const emit = defineEmits(['update:modelValue', 'success'])

const form = ref({
    topic_id: null,
    name_english: '',
    name_hebrew: ''
})

const topicOptions = ref([])

watch(
    () => props.topics,
    (newTopics) => {
        topicOptions.value = newTopics
    },
    { immediate: true }
)

const handleSubmit = () => {
    return new Promise((resolve, reject) => {
        if (!form.value.topic_id) return reject('Topic is required')
        if (!form.value.name_english && !form.value.name_hebrew)
            return reject('At least one name is required')

        resolve({ ...form.value })
    })
}

const handleSuccess = (data) => {
    emit('success', data)
    form.value.topic_id = null
    form.value.name_english = ''
    form.value.name_hebrew = ''
}
</script>
