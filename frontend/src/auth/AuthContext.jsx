import { createContext, useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import { getUser, verifyToken } from "./authService";
import LoadAuth from "../components/Loads/LoadAuth";

export const AuthContext = createContext();

export const AuthProvider = ({ children }) => {
  const [user, setUser] = useState(null);
  const [userType, setUserType] = useState(null);
  const [loadAuth, setLoadAuth] = useState(true);
  const navigate = useNavigate();

  useEffect(() => {

    const handleAuth = async () => {

      const token = localStorage.getItem('token');
      console.log("TOKNE", token)

      const resetAuth = () => {
        setUser(null);
        setUserType(null);
        setLoadAuth(false);
        localStorage.removeItem('token');
        localStorage.removeItem('userType');
      }

      const verify = await verifyToken();
      console.log("VERIGY", verify)
      if (!token || !verify) {
        resetAuth();
      }

      if (verify) {
        const userData = await getUser();
        console.log(userData);
        setUser(userData.data.user);
        setUserType(userData.data.type);
        console.log("TYPE: ", userType)
        setLoadAuth(false);
      }
    }

    handleAuth();
  }, [navigate]);

  const login = (loginData) => {
    localStorage.setItem('token', loginData.token);
    navigate('/');
    exit();
  };

  const logout = () => {
    resetAuth();
    return;
  };

  return loadAuth ? <LoadAuth /> : (
    <AuthContext.Provider value={{ user, login, logout, userType }}>
      {children}
    </AuthContext.Provider>
  );
};
