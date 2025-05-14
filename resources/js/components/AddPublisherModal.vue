<template>
    <Modal
        :model-value="modelValue"
        @update:modelValue="$emit('update:modelValue', $event)"
    >
        <!-- Modal Title -->
        <template #title>
            <h5 class="modal-title">Add Publisher</h5>
        </template>

        <!-- Modal Body -->
        <template #body>
            <Form
                v-model="form"
                :reset-on-success="true"
                @submit="submit"
                form-id="publisher-form"
            >
                <template #body>
                    <Input
                        v-model="form.name_hebrew"
                        label="שם (עברית):"
                        placeholder="שם בעברית"
                        dir="rtl"
                        :rtl="true"
                        wrapperClass="text-right"
                    />
                    <Input
                        v-model="form.name_english"
                        label="Name (English)"
                        placeholder="Name in English"
                    />
                </template>
            </Form>
        </template>

        <!-- Modal Footer -->
        <template #footer>
            <button
                class="btn btn-success"
                type="submit"
                form="publisher-form"
            >
                Save
            </button>
            <button
                type="button"
                class="btn btn-secondary"
                @click="$emit('update:modelValue', false)"
            >
                Close
            </button>
        </template>
    </Modal>
</template>

<script setup>
import { ref } from 'vue'
import Modal from './form/Modal.vue'
import Form from './form/Form.vue'
import Input from './form/Input.vue'
import axios from 'axios'

const props = defineProps({ modelValue: Boolean })
const emit = defineEmits(['update:modelValue', 'success'])

const form = ref({
    name_hebrew: '',
    name_english: ''
})

async function submit() {
    if (!form.value.name_hebrew || !form.value.name_english) return

    const response = await axios.post('/api/publishers', form.value)

    emit('success', response.data)
    emit('update:modelValue', false)

    // Clear form manually in case reset-on-success doesn't cover deep keys
    form.value.name_hebrew = ''
    form.value.name_english = ''
}
</script>
