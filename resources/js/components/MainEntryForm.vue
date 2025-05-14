<template>
    <div class="container mt-4">
        <Form @submit="saveEntry">
            <!-- Title -->
            <template #title>
                <h2 class="mb-4">Halachic Sefarim Index</h2>
            </template>

            <!-- Body -->
            <template #body>
                <SeferPicker
                    v-model:sefer-id="form.sefer_id"
                    :sefarim="sefarim"
                    @open-modal="showSeferModal = true"
                />
                <AddSeferModal v-model="showSeferModal" @close="handleSeferClose" />

                <TaxonomySection
                    v-model:entries="form.taxonomies"
                    :taxonomy-options="sortedTaxonomyOptions"
                    @add-new-type="showAddTaxonomyModal = true"
                    @remove-entry="removeTaxonomy"
                />
                <AddTaxonomyModal
                    v-model="showAddTaxonomyModal"
                    :taxonomyOptions="sortedTaxonomyOptions"
                    @success="handleNewTaxonomy"
                />

                <ReferenceSelector
                    v-model="form.references"
                    :reference-list="referencesList"
                    @open-modal="showReferenceModal = true"
                />
                <AddReferenceModal v-model="showReferenceModal" @success="handleReferenceSuccess" />

                <NoteInput v-model="form.notes" />
            </template>

            <!-- Footer -->
            <template #footer>
                <div class="row">
                    <div class="col text-end">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </template>
        </Form>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import Form from './form/Form.vue'

// Subcomponents from ./sub/
import SeferPicker from './sub/SeferPicker.vue'
import TaxonomySection from './sub/TaxonomySection.vue'
import ReferenceSelector from './sub/ReferenceSelector.vue'
import NoteInput from './sub/NoteInput.vue'

// Modals
import AddSeferModal from './AddSeferModal.vue'
import AddTaxonomyModal from './AddTaxonomyModal.vue'
import AddReferenceModal from './AddReferenceModal.vue'

const props = defineProps({
    taxonomyOptions: Array
})

const sortedTaxonomyOptions = computed(() => {
    return [...props.taxonomyOptions].sort((a, b) =>
        a.name_en.localeCompare(b.name_en)
    )
})

const form = ref({
    sefer_id: null,
    taxonomies: [],
    references: [],
    notes: ''
})

const sefarim = ref([])
const referencesList = ref([])

const showSeferModal = ref(false)
const showReferenceModal = ref(false)
const showAddTaxonomyModal = ref(false)

onMounted(() => {
    fetchSefarim()
    fetchReferences()
})

function fetchSefarim() {
    fetch('/api/sefarim')
        .then(res => res.json())
        .then(data => (sefarim.value = data))
}

function fetchReferences() {
    fetch('/api/references')
        .then(res => res.json())
        .then(data => (referencesList.value = data))
}

function handleSeferClose(updated = false) {
    showSeferModal.value = false
    if (updated) fetchSefarim()
}

function handleNewTaxonomy(newItem) {
    props.taxonomyOptions.push(newItem)
    showAddTaxonomyModal.value = false
}

function handleReferenceSuccess(newRef) {
    referencesList.value.push(newRef)
    form.value.references.push(newRef.id)
    showReferenceModal.value = false
}

function removeTaxonomy(index) {
    form.value.taxonomies.splice(index, 1)
}

async function saveEntry() {
    try {
        // STEP 1: Create the `text` entry
        const textResponse = await fetch('/api/texts', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                sefer_id: form.value.sefer_id,
                note: form.value.notes
            })
        })

        if (!textResponse.ok) throw new Error('Failed to create text entry')

        const newText = await textResponse.json()
        const textId = newText.id

        // STEP 2: Create related text_references
        const textReferencesPayload = form.value.taxonomies.map(t => ({
            text_id: textId,
            taxonomy_id: t.type,
            text_value: t.text_value,
            numeric_value: t.numeric_value,
            note: t.note || null
        }))

        const refResponse = await fetch('/api/text-references/bulk', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(textReferencesPayload)
        })

        if (!refResponse.ok) throw new Error('Failed to save taxonomy references')

        alert('Entry saved successfully!')
    } catch (err) {
        console.error('Save failed:', err)
        alert('Save failed.')
    }
}
</script>
