<template>
    <div class="p-4">
        <h1 class="text-3xl font-bold mb-4">Halachic Sefarim Index</h1>

        <div class="space-x-4 mb-4">
            <button class="btn" @click="showSeferModal = true">+ Add Sefer</button>
            <button class="btn" @click="showPublisherModal = true">+ Add Publisher</button>
        </div>

        <!-- Modals -->
        <AddSeferModal v-model="showSeferModal" />
        <AddPublisherModal v-model="showPublisherModal" />
        <MainEntryForm :taxonomyOptions="taxonomyOptions" />
    </div>
    <!-- Toast Container -->
    <div
        aria-live="polite"
        aria-atomic="true"
        class="position-fixed bottom-0 end-0 p-3"
        style="z-index: 1100"
    >
        <div
            id="successToast"
            class="toast align-items-center text-white bg-success border-0"
            role="alert"
            aria-live="assertive"
            aria-atomic="true"
        >
            <div class="d-flex">
                <ToastMessage v-if="toastMessage" :message="toastMessage" :showTrigger="showToast" />
            </div>
        </div>
    </div>

</template>

<script setup>
import { ref } from 'vue'
import ToastMessage from '@/components/ToastMessage.vue'
import AddSeferModal from './AddSeferModal.vue'
import AddPublisherModal from './AddPublisherModal.vue'
import MainEntryForm from './MainEntryForm.vue'
import axios from 'axios'


const toastMessage = ref('')
const showToast = ref(false)

const showSuccessToast = (text) => {
    toastMessage.value = text
    showToast.value = false
    nextTick(() => {
        showToast.value = true
    })
}
const showSeferModal = ref(false)
const showPublisherModal = ref(false)
const fetchTaxonomy = async () => {
    const { data } = await axios.get('/api/taxonomy')
    taxonomyOptions.value = data
}
onMounted(fetchTaxonomy)
const taxonomyOptions = ref([])
</script>

<style scoped>
.btn {
    @apply bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition;
}
</style>
