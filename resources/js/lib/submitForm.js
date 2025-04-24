import axios from 'axios'

export default async function submitForm(endpoint, formData) {
    const response = await axios.post(`/api/${endpoint}`, formData)
    return response.data
}
