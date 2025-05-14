<template>
    <Modal
        :model-value="modelValue"
        @update:modelValue="$emit('update:modelValue', $event)"
    >
        <template #title>
            <h5 class="modal-title">Add Sefer</h5>
        </template>

            <template #body>
                <Form
                    v-model="form"
                    :reset-on-success="true"
                    @submit="handleSubmit"
                    modalStyle
                    id="add-sefer-form"
                >
                <div class="row gx-4 gy-3">
                    <div class="col-md-6">
                        <Input
                            v-model="form.english_name"
                            label="Name (English): "
                            placeholder="Name in English"
                        />
                    </div>
                    <div class="col-md-6">
                        <Input
                            v-model="form.hebrew_name"
                            label="שם (עברית):"
                            placeholder="שם בעברית"
                            dir="rtl"
                            :rtl="true"
                            wrapperClass="text-right"
                        />
                    </div>

                    <div class="col-md-6">
                        <Input
                            v-model="form.edition"
                            label="Edition (Number): "
                            type="number"
                            placeholder="e.g. 1"
                        />
                    </div>
                    <div class="col-md-6">
                        <Input
                            v-model="form.publication_year"
                            label="Pub. Year (Secular): "
                            type="number"
                            placeholder="e.g. 2025"
                        />
                    </div>

                    <div class="col-md-12">
                        <div class="d-flex gap-2 align-items-start">
                            <Select
                                v-model="form.publisher_id"
                                label="Publisher: "
                                :options="publisherOptions"
                                wrapperClass="p-0 w-100"
                                labelClass="mb-0"
                            />
                            <Button
                                action="open-modal"
                                class="px-3 pt-2 mt-5"
                                @click="openPublisherModal"
                            >
                                +
                            </Button>
                        </div>
                    </div>
                </div>
                </Form>
            </template>

            <template #footer>
                <Button action="save" form="add-sefer-form" />
                <Button action="cancel" />
            </template>
    </Modal>

    <AddPublisherModal
        v-model="showAddPublisherModal"
        @success="handlePublisherAdded"
    />
</template>

<script setup>
import { ref, reactive, onMounted, watch } from 'vue'
import Modal from './form/Modal.vue'
import Form from './form/Form.vue'
import Input from './form/Input.vue'
import Select from './form/Select.vue'
import Button from './form/Button.vue'

import AddPublisherModal from './AddPublisherModal.vue'
import axios from 'axios'

const props = defineProps({
    modelValue: Boolean
})

const emit = defineEmits(['update:modelValue', 'success'])

const form = ref({
    hebrew_name: '',
    english_name: '',
    edition: null,
    publication_year: null,
    publisher_id: null
})

const publisherOptions = ref([])
const showAddPublisherModal = ref(false)

onMounted(async () => {
    await loadPublishers()
})

async function loadPublishers() {
    const { data } = await axios.get('/api/publishers')
    publisherOptions.value = data.map(pub => ({
        value: pub.id,
        label: pub.name_english || pub.name_hebrew
    }))
}

function openPublisherModal() {
    emit('update:modelValue', false)
    setTimeout(() => {
        showAddPublisherModal.value = true
    }, 300)
}

function handlePublisherAdded(newPublisher) {
    loadPublishers().then(() => {
        form.value.publisher_id = newPublisher.id
    })
    showAddPublisherModal.value = false

    setTimeout(() => {
        emit('update:modelValue', true)
    }, 300)
}

async function handleSubmit() {
    if (!form.value.hebrew_name || !form.value.english_name) return

    const response = await axios.post('/api/sefarim', { ...form.value })
    emit('success', response.data)
    emit('update:modelValue', false)
}
</script>
