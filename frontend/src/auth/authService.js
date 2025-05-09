import api from "../config/api"

export const loginCompany = async (document, password) => {
    const response = await api.post('/auth/company', { document, password })
    return response
}

export const verifyToken = async () => {
    try {
        const response = await api.post('auth/verify')
        return true
    } catch (error) {
        return false
    }
}

export const getUser = async () => {
    try {
        const response = await api.post('auth/user')
        return response.data
    } catch (error) {
        return false
    }
}