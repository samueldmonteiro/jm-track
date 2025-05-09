import React from 'react'
import { Navigate } from "react-router-dom"
import { useAuth } from './useAuth'


const ProtectedRoute = ({allowed, children}) => {
    const { user, userType } = useAuth()

    if (!user) {
      const redirectTo = allowed.includes("admin") ? "/login" : "/login/company"
      return <Navigate to={'/login'} replace />
    }
  
    if (!allowed.includes(userType)) {
      return <Navigate to="/" replace />
    }
  
    return children
}

export default ProtectedRoute