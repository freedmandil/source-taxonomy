<template>
    <div class="ui container">
        <h2 class="ui header">Insert Halachic Entry</h2>

        <!-- Sefer Dropdown + Modal Button -->
        <div class="field">
            <label>Sefer</label>
            <div class="ui action input">
                <select v-model="form.sefer_id" class="ui dropdown">
                    <option v-for="sefer in sefarim" :value="sefer.id" :key="sefer.id">
                        {{ sefer.name_he }} / {{ sefer.name_en }}
                    </option>
                </select>
                <button @click="showSeferModal = true" class="ui icon button">
                    <i class="plus icon"></i>
                </button>
                <TextEntryForm v-model:form="form" :taxonomyOptions="taxonomyOptions" />
            </div>
        </div>

        <!-- Repeat for Topic, Sub-Topic, Keyword, Tag, Reference -->

        <!-- Note Field -->
        <div class="field">
            <label>Note</label>
            <textarea v-model="form.note" class="ui textarea"></textarea>
        </div>

        <!-- Submit Button -->
        <button @click="submitForm" class="ui primary button">Save Entry</button>

        <!-- Modals -->
        <AddSeferModal v-if="showSeferModal" @close="handleSeferClose" />
        <!-- Add other modals similarly -->
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import AddSeferModal from './AddSeferModal.vue'
import TextEntryForm from './TextEntryForm.vue'
const props = defineProps({
    taxonomyOptions: Array
})

const form = ref({
    sefer_id: null,
    note: '',
    references: []
    // other fields like topic_ids, sub_topic_ids etc. to be added
})

const sefarim = ref([])
const showSeferModal = ref(false)

onMounted(fetchSefarim)

function fetchSefarim() {
    fetch('/api/sefarim')
        .then(res => res.json())
        .then(data => sefarim.value = data)
}

function handleSeferClose(updated = false) {
    showSeferModal.value = false
    if (updated) fetchSefarim()
}

function submitForm() {
    fetch('/api/texts', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(form.value),
    }).then(/* handle success */)
}
</script>
