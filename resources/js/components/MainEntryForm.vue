<template>
    <div class="container mt-4">
        <Form @submit="saveEntry">
            <!-- Title -->
            <template #title>
                <h2 class="mb-4">Halachic Sefarim Index</h2>
            </template>

            <!-- Body -->
            <template #body>
                <!-- Sefer Picker -->
                <SeferPicker
                    v-model:sefer-id="form.sefer_id"
                    :sefarim="sefarim"
                    @open-modal="showSeferModal = true"
                />
                <AddSeferModal v-model="showSeferModal" @close="handleSeferClose" />

                <!-- Taxonomies -->
                <TaxonomySection
                    v-model:entries="form.taxonomies"
                    :taxonomy-options="sortedTaxonomyOptions"
                    @add-new-type="showAddTaxonomyModal = true"
                    @remove-entry="removeTaxonomy"
                />

                <!-- Add Taxonomy Modal (still custom, for now) -->
                <AddTaxonomyModal
                    v-model="showAddTaxonomyModal"
                    :taxonomyOptions="sortedTaxonomyOptions"
                    @success="handleNewTaxonomy"
                />

                <!-- Notes -->
                <NoteInput v-model="form.notes" />

                <!-- Add Tag Button -->
                <div class="mt-3">
                    <button type="button" class="btn btn-outline-secondary" @click="showAddTagModal = true">
                        + Add Tag
                    </button>
                </div>
                <div class="mt-3">
                    <button type="button" class="btn btn-outline-secondary" @click="showAddKeywordModal = true">
                        + Add Keyword
                    </button>
                </div>
                <div class="mt-3">
                    <button type="button" class="btn btn-outline-secondary" @click="showAddTopicModal = true">
                        + Add Topic
                    </button>
                </div>

                <!-- Reusable Tag Modal -->
                <AddEntityModal
                    v-model="showAddTagModal"
                    title="Add Tag"
                    api-path="/api/tag-action"
                    slug-check-url="/api/tag-action/checkSlug"
                    @success="handleNewTag"
                />
                <AddEntityModal
                    v-model="showAddKeywordModal"
                    title="Add Keyword"
                    api-path="/api/keyword-action"
                    slug-check-url="/api/keyword-action/checkSlug"
                    @success="handleNewTag"
                />
                <AddEntityModal
                    v-model="showAddTopicModal"
                    title="Add Topic"
                    api-path="/api/topic-action"
                    slug-check-url="/api/topic-action/checkSlug"
                    @success="handleNewTag"
                />
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

// Subcomponents
import SeferPicker from './sub/SeferPicker.vue'
import TaxonomySection from './sub/TaxonomySection.vue'
import NoteInput from './sub/NoteInput.vue'

// Modals
import AddSeferModal from './AddSeferModal.vue'
import AddTaxonomyModal from './AddTaxonomyModal.vue'
import AddEntityModal from './AddEntityModal.vue' // 🆕 REUSABLE modal

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
const showAddTaxonomyModal = ref(false)
const showAddTagModal = ref(false)
const showAddKeywordModal = ref(false)
const showAddTopicModal = ref(false)

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

function handleNewTag(newTag) {
    // Example logic — adjust depending on where you're using tags
    showAddTagModal.value = false
}
function handleNewKeyword(newKeyword) {
    // Example logic — adjust depending on where you're using keywords
    showAddKeywordModal.value = false
}

function handleNewTopic(newTopic) {
    // Example logic — adjust depending on where you're using topics
    showAddTopicModal.value = false
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

        const refResponse = await fetch('/api/references-action/bulk', {
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
