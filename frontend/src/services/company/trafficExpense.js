import api from "../../config/api"

export const getAllTrafficExpenses = async () => {

    const response = await api.get('company/traffic_expenses');
    return response;
}