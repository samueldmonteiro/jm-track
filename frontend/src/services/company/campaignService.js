import api from "../../config/api"

export const newCampaign = async (name) => {
    const response = await api.post('company/campaigns/store', { name });
    return response;
}

export const findById = async (id) => {
    const response = await api.get('company/campaigns/' + id);
    return response;
}

export const getAllCampaigns = async() => {
    const response = await api.get('company/campaigns');
    return response;
}

export const deleteCampaign = async() => {
    const response = await api.get('company/campaigns');
    return response;
}

export const deleteTrafficExpense = async() => {
    const response = await api.get('company/campaigns');
    return response;
}


export const deleteTrafficReturn = async() => {
    const response = await api.get('company/campaigns');
    return response;
}

