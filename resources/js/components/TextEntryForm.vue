<template>
    <div class="ui container">
        <h2 class="ui header">Add New Halachic Text</h2>
        <form class="ui form" @submit.prevent="submitForm">
            <!-- Sefer dropdown with modal -->
            <div class="field">
                <label>Sefer</label>
                <div class="ui action input">
                    <select v-model="form.sefer_id" class="ui dropdown">
                        <option :value="null" disabled>Select Sefer</option>
                        <option v-for="sefer in seforim" :key="sefer.id" :value="sefer.id">
                            {{ sefer.name_english || sefer.name_hebrew }}
                        </option>
                    </select>
                    <button class="ui icon button" @click="showModal('sefer')" type="button"><i class="plus icon"></i></button>
                </div>
            </div>

            <!-- Text fields -->
            <div class="field"><label>Section</label><input v-model="form.section" placeholder="Section" /></div>
            <div class="field"><label>Siman</label><input v-model="form.siman" placeholder="Siman" /></div>
            <div class="field"><label>Seif</label><input v-model="form.seif" placeholder="Seif" /></div>
            <div class="field"><label>Seif Katan</label><input v-model="form.seif_katan" placeholder="Seif Katan" /></div>

            <!-- Notes -->
            <div class="field"><label>Note</label><textarea v-model="form.note" placeholder="Notes..."></textarea></div>

            <!-- Multiselect fields with modals -->
            <div v-for="field in multiFields" :key="field.key" class="field">
                <label>{{ field.label }}</label>
                <div class="ui action input">
                    <select class="ui fluid multiple dropdown" v-model="form[field.key]" multiple>
                        <option v-for="opt in options[field.key]" :key="opt.id" :value="opt.id">
                            {{ opt.name_en || opt.name_he || opt.slug }}
                        </option>
                    </select>
                    <button class="ui icon button" @click="showModal(field.key)" type="button"><i class="plus icon"></i></button>
                </div>
            </div>

            <!-- Submit -->
            <button class="ui primary button" type="submit">Save</button>
        </form>

        <!-- Modals -->
        <component v-if="activeModal" :is="`Add${capitalize(activeModal)}Modal`" @close="activeModal = null" @refresh="loadOptions" />
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                sefer_id: null,
                section: '',
                siman: '',
                seif: '',
                seif_katan: '',
                note: '',
                topics: [],
                sub_topics: [],
                tags: [],
                keywords: [],
                references: []
            },
            seforim: [],
            options: {
                topics: [],
                sub_topics: [],
                tags: [],
                keywords: [],
                references: []
            },
            multiFields: [
                { key: 'topics', label: 'Topics' },
                { key: 'sub_topics', label: 'Sub-Topics' },
                { key: 'tags', label: 'Tags' },
                { key: 'keywords', label: 'Keywords' },
                { key: 'references', label: 'References' }
            ],
            activeModal: null
        };
    },
    methods: {
        async loadOptions() {
            this.seforim = await this.fetchOptions('/api/sefarim');
            for (const field of this.multiFields) {
                this.options[field.key] = await this.fetchOptions(`/api/${field.key}`);
            }
        },
        async fetchOptions(endpoint) {
            try {
                const response = await fetch(endpoint);
                return await response.json();
            } catch (e) {
                console.error('Fetch failed:', e);
                return [];
            }
        },
        async submitForm() {
            try {
                const res = await fetch('/api/texts', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(this.form)
                });
                const result = await res.json();
                alert('Saved successfully!');
            } catch (e) {
                console.error('Submission error:', e);
            }
        },
        showModal(key) {
            this.activeModal = key;
        },
        capitalize(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }
    },
    mounted() {
        this.loadOptions();
    }
};
</script>
