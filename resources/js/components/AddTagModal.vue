<template>
    <div class="ui modal active" id="addTagModal">
        <i class="close icon" @click="$emit('close')"></i>
        <div class="header">Add New Tag</div>
        <div class="content">
            <form class="ui form" @submit.prevent="submitForm">
                <div class="field">
                    <label>Hebrew Name</label>
                    <input type="text" v-model="tag.name_he" placeholder="הזן שם בעברית" required />
                </div>
                <div class="field">
                    <label>English Name</label>
                    <input type="text" v-model="tag.name_en" placeholder="Enter English Name" required />
                </div>
                <div class="field">
                    <label>Other Languages (JSON)</label>
                    <textarea v-model="tag.name_languages" placeholder='{"fr": "Nom", "es": "Nombre"}'></textarea>
                </div>
                <div class="field">
                    <label>Note (Optional)</label>
                    <textarea v-model="tag.note" placeholder="Additional note or description"></textarea>
                </div>
                <button class="ui primary button" type="submit">Save Tag</button>
            </form>
        </div>
    </div>
</template>

<template>
    <Modal
        :model-value="modelValue"
        @update:modelValue="$emit('update:modelValue', $event)"
        @submit="handleSubmit"
        @success="handleSuccess"
    >
        <template #title>Add Tag</template>

        <Input v-model="form.name_english" label="Name (English)" />
        <Input v-model="form.name_hebrew" label="Name (Hebrew)" />
    </Modal>
</template>

<script setup>
import { ref } from 'vue'
import Modal from './form/Modal.vue'

const props = defineProps({ modelValue: Boolean })
const emit = defineEmits(['update:modelValue', 'success'])

const form = ref({
    name_english: '',
    name_hebrew: ''
})

const handleSubmit = () => {
    return new Promise((resolve, reject) => {
        if (!form.value.name_english && !form.value.name_hebrew) {
            return reject('At least one name is required')
        }
        resolve({ ...form.value })
    })
}

const handleSuccess = (data) => {
    emit('success', data)
    form.value.name_english = ''
    form.value.name_hebrew = ''
}
</script>
