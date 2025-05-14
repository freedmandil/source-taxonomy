import { createApp } from 'vue'
import HalachicIndexApp from './components/HalachicIndexApp.vue'

// Import form components
import Input from './components/form/Input.vue'
import Textarea from './components/form/Textarea.vue'
import Select from './components/form/Select.vue'

import submitForm from './lib/submitForm.js'
import api from './lib/axios.js'
// Create the app
const app = createApp(HalachicIndexApp)
app.config.devtools = true
app.config.globalProperties.$submitForm = submitForm
app.config.globalProperties.$api = api
// Global registration
app.component('Input', Input)
app.component('Textarea', Textarea)
app.component('Select', Select)
app.component('Form', Select)

app.mount('#halachic-index')
