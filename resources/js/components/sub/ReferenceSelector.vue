<template>
    <div class="row gx-4 gy-3 mb-4 align-items-center">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <label class="form-label me-2 mb-0">References:</label>
                <select class="form-select flex-fill" multiple :value="modelValue" @change="updateRefs">
                    <option v-for="r in referenceList" :key="r.id" :value="r.id">
                        {{ r.reference_type }}: {{ r.text_value }}
                        <span v-if="r.int_value">({{ r.int_value }})</span>
                    </option>
                </select>
                <button
                    type="button"
                    class="btn btn-outline-secondary ms-2"
                    @click="$emit('open-modal')"
                >
                    + Add Reference
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps(['modelValue', 'referenceList'])
const emit = defineEmits(['update:modelValue', 'open-modal'])

function updateRefs(event) {
    const options = Array.from(event.target.selectedOptions)
    emit('update:modelValue', options.map(o => o.value))
}
</script>
