import React, { useState } from 'react'

const useFetchData = () => {

  const [data, setData] = useState(null);
  const [error, setError] = useState(null);
  const [statusCode, setStatusCode] = useState(null);
  const [loading, setLoading] = useState(false);

  const request = async (fetchFunction, params = []) => {
    setLoading(true);
    setError(null);

    try {
      const response = await fetchFunction(...params);
      setData(response.data);
      setLoading(false);
      setStatusCode(response.status);
      return response;
      
    } catch (error) {
      setData(null);
      setLoading(false);
      setError(error.response.data.message);
      setStatusCode(error.status);
      console.log("ERROOO PORRA", error)
      return error;
    }
  }

  return { data, error, loading, request, statusCode }
}

export default useFetchData