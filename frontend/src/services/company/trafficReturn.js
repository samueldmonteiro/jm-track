import api from "../../config/api";

export const getAllTrafficReturnsWithTotalAmount = async () => {

    const response = await api.get('company/traffic_returns');
    return response;
}