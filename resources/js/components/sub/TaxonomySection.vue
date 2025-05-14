<template>
    <div class="row gx-4 gy-2 mb-4">
        <div
            v-for="(tax, idx) in entries"
            :key="idx"
            class="row gx-2 align-items-start mb-2"
        >
            <div class="col-md-3">
                <select v-model="tax.type" class="form-select">
                    <option disabled value="">Select taxonomy type…</option>
                    <option v-for="opt in taxonomyOptions" :key="opt.id" :value="opt.id">
                        {{ opt.name_en }} ({{ opt.name_he }})
                    </option>
                </select>
            </div>

            <div class="col-md-3">
                <input
                    v-model="tax.text_value"
                    type="text"
                    class="form-control"
                    placeholder="Text Value"
                />
            </div>

            <div class="col-md-2">
                <input
                    v-model.number="tax.numeric_value"
                    type="number"
                    class="form-control"
                    placeholder="Numeric Value"
                />
            </div>

            <div class="col-md-3">
                <input
                    v-model="tax.note"
                    type="text"
                    class="form-control"
                    placeholder="Note"
                />
            </div>

            <div class="col-md-1 d-flex align-items-start">
                <Button
                    action="delete"
                    class="btn-sm"
                    @click="$emit('remove-entry', idx)"
                >
                    &times;
                </Button>
            </div>
        </div>

        <div class="col-12">
            <Button
                action="open-modal"
                class="me-2"
                text="+ Add Taxonomy Entry"
                @click="add"
            />
            <Button
                action="open-modal"
                text="+ Add New Taxonomy Type"
                @click="$emit('add-new-type')"
            />
        </div>
    </div>
</template>

<script setup>
import Button from '../form/Button.vue'
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
