import React from 'react'
import { Navigate } from "react-router-dom";
import { useAuth } from './useAuth';


const ProtectedRoute = ({allowed, children}) => {
    const { user, userType } = useAuth();
    console.log("USER TYPE", userType)

    if (!user) {
      // Redireciona para a tela de login adequada
      const redirectTo = allowed.includes("admin") ? "/login" : "/login/company";
      return <Navigate to={'/login'} replace />;
    }
  
    if (!allowed.includes(userType)) {
      return <Navigate to="/" replace />; // Ou uma tela de acesso negado
    }
  
    return children;
}

export default ProtectedRoute