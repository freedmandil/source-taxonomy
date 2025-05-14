<template>
    <div class="row gx-4 gy-2 mb-4">
        <div
            v-for="(tax, idx) in entries"
            :key="idx"
            class="col-12 d-flex flex-wrap align-items-start gap-2 mb-2"
        >
            <select v-model="tax.type" class="form-select" style="min-width: 200px;">
                <option disabled value="">Select taxonomy type…</option>
                <option v-for="opt in taxonomyOptions" :key="opt.id" :value="opt.id">
                    {{ opt.name_en }} ({{ opt.name_he }})
                </option>
            </select>

            <input
                v-model="tax.text_value"
                type="text"
                class="form-control"
                placeholder="Text Value"
                style="min-width: 200px;"
            />

            <input
                v-model.number="tax.numeric_value"
                type="number"
                class="form-control"
                placeholder="Numeric Value"
                style="min-width: 150px;"
            />

            <input
                v-model="tax.note"
                type="text"
                class="form-control"
                placeholder="Note"
                style="min-width: 200px;"
            />

            <button
                type="button"
                class="btn btn-outline-danger"
                @click="$emit('remove-entry', idx)"
            >
                &times;
            </button>
        </div>

        <div class="col-12">
            <button type="button" class="btn btn-outline-secondary me-2" @click="add">
                + Add Taxonomy Entry
            </button>
            <button type="button" class="btn btn-outline-secondary" @click="$emit('add-new-type')">
                + Add New Taxonomy Type
            </button>
        </div>
    </div>
</template>

<script setup>
const props = defineProps(['entries', 'taxonomyOptions'])
const emit = defineEmits(['update:entries', 'add-new-type', 'remove-entry'])

function add() {
    props.entries.push({
        type: null,
        text_value: '',
        numeric_value: null,
        note: ''
    })
}
</script>
