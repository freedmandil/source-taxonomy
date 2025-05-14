<template>
    <div class="row gx-4 gy-3 mb-4">
        <div class="col-md-12">
            <label for="notesTextarea" class="form-label">Notes</label>
            <textarea
                id="notesTextarea"
                class="form-control"
                rows="3"
                placeholder="Enter any notes here…"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
            ></textarea>
        </div>
    </div>
</template>

<script setup>
defineProps(['modelValue'])
defineEmits(['update:modelValue'])
</script>
