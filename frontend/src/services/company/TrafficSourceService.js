import api from "../../config/api"

export const findAll = async () => {
    const response = await api.get('traffic_source');
    return response;
}
