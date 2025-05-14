<template>
    <Modal :model-value="modelValue"
           @update:modelValue="$emit('update:modelValue', $event)"
    >
        <template #title>{{ title }}</template>

        <template #body>
            <Form
                v-model="form"
                :reset-on-success="!closeOnSuccess"
                @submit="onSubmit"
                @success="handleSuccess"
                modalStyle
                id="add-entity-form"
                @update:modelValue="showModal = $event"

            >
                <template #body>
                    <Input
                        v-model="form.name_en"
                        label="Name (English):"
                        placeholder=" "
                        :error="errors.name_en"
                    />
                    <Input
                        v-model="form.slug"
                        label="Slug:"
                        placeholder=" "
                        @input="form.slugTouched = true"
                        readonly
                        :error="errors.slug"
                    />
                    <Input
                        v-model="form.name_he"
                        label="שם (עברית):"
                        placeholder=" "
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


            </Form>
        </template>
        <template #footer>
            <Button
                action="save"
                :loading="isSubmitting || isCheckingSlug"
                form="add-entity-form"
                text="Save"
            />
            <Button
                action="cancel"
                text="Cancel"
                @cancel="emit('update:modelValue', false)"
            />
        </template>
    </Modal>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'
import Button from './form/Button.vue'
import Modal from './form/Modal.vue'
import Form from './form/Form.vue'
import Input from './form/Input.vue'
import Textarea from './form/Textarea.vue'
import { slugify } from '@/utils/slugUtils'
import axios from 'axios'

const props = defineProps<{
    modelValue: boolean
    closeOnSuccess?: boolean
    title: string
    apiPath: string
    slugCheckUrl: string
}>()

const emit = defineEmits<{
    (e: 'update:modelValue', value: boolean): void
    (e: 'success', payload: any): void
    (e: 'cancel'): void
}>()

const form = ref({
    name_en: '',
    name_he: '',
    slug: '',
    note: '',
    slugTouched: false
})

const errors = ref<Record<string, string | null>>({})
const isSubmitting = ref(false)
const isCheckingSlug = ref(false)

watch(() => form.value.name_en, (newVal) => {
    if (!form.value.slugTouched) {
        form.value.slug = slugify(newVal || '')
    }
    errors.value.slug = null
})

watch(() => form.value.slug, () => {
    errors.value.slug = null
})

async function onSubmit() {
    isSubmitting.value = true
    try {
        const payload = await handleSubmit()
        if (!payload) return
        const response = await axios.post(props.apiPath, payload)
        emit('success', response.data)
        if (props.closeOnSuccess !== false) {
            emit('update:modelValue', false)
        }
    } catch (err) {
    } finally {
        isSubmitting.value = false
    }
}

function handleSuccess() {
    // Optional hook
}

async function handleSubmit() {
    errors.value = {}
    if (!form.value.name_en || !form.value.slug) {
        if (!form.value.name_en) errors.value.name_en = 'Name (English) is required.'
        if (!form.value.slug) errors.value.slug = 'Slug is required.'
        return null
    }

    const isUnique = await checkSlugUnique()
    if (!isUnique) {
        errors.value.slug = `Slug "${form.value.slug}" already exists. Please modify it.`
        return null
    }

    return { ...form.value }
}

async function checkSlugUnique(): Promise<boolean> {
    const baseSlug = form.value.slug
    if (!baseSlug) return true

    isCheckingSlug.value = true
    errors.value.slug = null

    try {
        let attempt = 0
        let slugToCheck = baseSlug

        while (attempt < 10) {
            const res = await fetch(`${props.slugCheckUrl}?slug=${encodeURIComponent(slugToCheck)}`)
            const data = await res.json()
            if (data.unique) return true

            attempt++
            slugToCheck = `${baseSlug}-${attempt}`
            const nextRes = await fetch(`${props.slugCheckUrl}?slug=${encodeURIComponent(slugToCheck)}`)
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
</script>
