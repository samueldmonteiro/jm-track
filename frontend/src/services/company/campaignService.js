import api from "../../config/api"

export const newCampaign = async (name) => {
    const response = await api.post('company/campaign/create', { name });
    return response;
}

export const editCampaign = async (id, data) => {
    const response = await api.put('company/campaign/update/' + id, data);
    return response;
}

export const deleteCampaign = async (id) => {
    const response = await api.delete('company/campaign/delete/' + id);
    return response;
}

export const findById = async (id) => {
    const response = await api.get('company/campaign/' + id + '/transactions');
    return response;
}

export const getAllCampaigns = async () => {
    const response = await api.get('company/campaigns');
    return response;
}


export const deleteTrafficTransaction = async () => {
    const response = await api.get('company/campaigns');
    return response;
}

export const deleteTrafficReturn = async () => {
    const response = await api.get('company/campaigns');
    return response;
}

