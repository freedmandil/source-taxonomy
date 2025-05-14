<template>
    <div class="row gx-4 gy-3 mb-4 align-items-center">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <label for="seferSelect" class="form-label me-2 mb-0">Sefer:</label>
                <select
                    id="seferSelect"
                    class="form-select flex-fill"
                    :value="seferId"
                    @input="$emit('update:seferId', $event.target.value)"
                >
                    <option disabled value="">Choose a Sefer…</option>
                    <option v-for="s in sefarim" :key="s.id" :value="s.id">
                        {{ s.english_name }} <span v-if="s.hebrew_name">({{ s.hebrew_name }})</span>
                    </option>
                </select>
                <button
                    type="button"
                    class="btn btn-outline-secondary ms-2"
                    @click="$emit('open-modal')"
                >
                    + Add Sefer
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps(['seferId', 'sefarim'])
defineEmits(['update:seferId', 'open-modal'])
</script>
