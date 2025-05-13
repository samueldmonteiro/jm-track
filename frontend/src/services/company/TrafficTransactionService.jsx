import api from "../../config/api"

export const createTrafficTransaction = async (data) => {
    const response = await api.post('company/traffic_transaction/create', data);
    return response;
}


export const deleteTrafficTransaction = async (id) => {
    const response = await api.delete('company/traffic_transaction/delete/'+id);
    return response;
}
