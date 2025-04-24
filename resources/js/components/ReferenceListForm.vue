<template>
    <div>
        <div v-for="(reference, index) in references" :key="index" class="mb-2 border p-2">
            <div>{{ getLabel(reference.taxonomy_id) }}: {{ reference.text_value }}</div>
            <small>{{ reference.note }}</small>
            <button class="btn btn-red btn-sm" @click="remove(index)">Remove</button>
        </div>

        <button class="btn btn-blue mt-2" @click="showModal = true">+ Add Reference</button>

        <AddReferenceModal
            v-model="showModal"
            @save="addReference"
        />

    </div>
</template>

<script setup>
import { ref } from 'vue'
import AddReferenceModal from './AddReferenceModal.vue'

const emit = defineEmits(['update:modelValue'])
const props = defineProps({
    modelValue: Array,
    taxonomyOptions: Array
})

const showModal = ref(false)
const references = ref(props.modelValue || [])

watch(references, (val) => {
    emit('update:modelValue', val)
}, { deep: true })

const addReference = (reference) => {
    references.value.push(reference)
    showModal.value = false
}

const remove = (index) => {
    references.value.splice(index, 1)
}

const getLabel = (id) => {
    const match = props.taxonomyOptions?.find(opt => opt.id === id)
    return match?.name_en || 'Unknown'
}
</script>
