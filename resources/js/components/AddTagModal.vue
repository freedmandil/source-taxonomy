<template>
    <Modal
        :model-value="modelValue"
        @update:modelValue="$emit('update:modelValue', $event)"
    >
        <template #title>Add Tag</template>

        <template #body>
            <Form
                v-model="form"
                :reset-on-success="!closeOnSuccess"
                @submit="onSubmit"
                @success="handleSuccess"
                modalStyle
            >
                <template #body>
                    <Input
                        v-model="form.name_en"
                        label="Name (English):"
                        placeholder="e.g. Prohibited, Permissible..."
                        :error="errors.name_en"
                    />
                    <Input
                        v-model="form.slug"
                        label="Slug:"
                        placeholder="e.g. prohibited, permissible..."
                        @input="form.slugTouched = true"
                        readonly
                        :error="errors.slug"
                    />
                    <Input
                        v-model="form.name_he"
                        label="שם (עברית):"
                        placeholder="e.g. אסור, מותר..."
                        dir="rtl"
                        :rtl="true"
                        wrapperClass="text-right"
                    />
                    <Textarea
                        v-model="form.note"
                        label="Note (optional):"
                        rows="2"
                    />
                </template>

                <template #footer>
                    <button
                        class="btn btn-success"
                        :disabled="isSubmitting || isCheckingSlug"
                        type="submit"
                    >
                        <span
                            v-if="isSubmitting || isCheckingSlug"
                            class="spinner-border spinner-border-sm me-2"
                            role="status"
                            aria-hidden="true"
                        ></span>
                        Save
                    </button>
                    <button
                        class="btn btn-secondary"
                        type="button"
                        @click="$emit('update:modelValue', false)"
                    >
                        Close
                    </button>
                </template>
            </Form>
        </template>
    </Modal>
</template>

<script setup>
import { ref, watch } from 'vue'
import Modal from './form/Modal.vue'
import Form from './form/Form.vue'
import Input from './form/Input.vue'
import Textarea from './form/Textarea.vue'
import { slugify } from '@/utils/slugUtils'
import axios from 'axios'

const isSubmitting = ref(false)
const isCheckingSlug = ref(false)
const errors = ref({})

const props = defineProps({
    modelValue: Boolean,
    closeOnSuccess: { type: Boolean, default: true }
})
const emit = defineEmits(['update:modelValue', 'submit', 'success'])

const form = ref({
    name_en: '',
    name_he: '',
    slug: '',
    note: '',
    slugTouched: false
})

const onSubmit = async () => {
    isSubmitting.value = true
    try {
        const payload = await handleSubmit()
        const response = await axios.post('/api/tag-action', payload)

        emit('success', response.data)

        if (props.closeOnSuccess) {
            emit('update:modelValue', false)
        }
    } catch (err) {
        // Optional error handling
    } finally {
        isSubmitting.value = false
    }
}

const handleSuccess = () => {
    // Optional, handled by Form
}

const handleSubmit = async () => {
    errors.value = {}

    if (!form.value.name_en || !form.value.slug) {
        if (!form.value.name_en) errors.value.name_en = 'Name (English) is required.'
        if (!form.value.slug) errors.value.slug = 'Slug is required.'
        throw 'Please fill in all required fields.'
    }

    const isUnique = await checkSlugUnique()
    if (!isUnique) {
        errors.value.slug = `Slug "${form.value.slug}" already exists. Please modify it.`
        throw 'Slug must be unique.'
    }

    return { ...form.value }
}

const checkSlugUnique = async () => {
    const baseSlug = form.value.slug
    if (!baseSlug) return true

    isCheckingSlug.value = true
    errors.value.slug = null

    try {
        let attempt = 0
        let slugToCheck = baseSlug

        while (attempt < 10) {
            const res = await fetch(`/api/tag-action/checkSlug?slug=${encodeURIComponent(slugToCheck)}`)
            const data = await res.json()

            if (data.unique) return true

            attempt++
            slugToCheck = `${baseSlug}-${attempt}`
            const nextRes = await fetch(`/api/tag-action/checkSlug?slug=${encodeURIComponent(slugToCheck)}`)
            const nextData = await nextRes.json()

            if (nextData.unique) {
                const confirmed = confirm(`Slug "${baseSlug}" is taken. Use "${slugToCheck}" instead?`)
                if (confirmed) {
                    form.value.slug = slugToCheck
                    return true
                } else {
                    errors.value.slug = `Slug "${baseSlug}" is already taken. Please modify it.`
                    return false
                }
            }
        }

        errors.value.slug = 'Could not find a unique slug after multiple attempts.'
        return false
    } catch (err) {
        console.error('Slug check failed:', err)
        errors.value.slug = 'Slug check failed. Try again later.'
        return false
    } finally {
        isCheckingSlug.value = false
    }
}

watch(() => form.value.name_en, (newVal) => {
    if (!form.value.slugTouched) {
        form.value.slug = slugify(newVal || '')
    }
    errors.value.slug = null
})

watch(() => form.value.slug, () => {
    errors.value.slug = null
})
</script>
