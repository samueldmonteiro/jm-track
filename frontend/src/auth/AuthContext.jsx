import { createContext, useEffect, useState } from "react"
import { useNavigate } from "react-router-dom"
import { getUser, verifyToken } from "./authService"
import BackDrop from "../components/Loads/BackDrop"

export const AuthContext = createContext()

export const AuthProvider = ({ children }) => {
  const [user, setUser] = useState(null)
  const [userType, setUserType] = useState(null)
  const [loadAuth, setLoadAuth] = useState(true)
  const navigate = useNavigate()

  const resetAuth = () => {
    setUser(null)
    setUserType(null)
    localStorage.removeItem('token')
    localStorage.removeItem('companyId')
  }

  useEffect(() => {
    const handleAuth = async () => {
      const token = localStorage.getItem('token')

      if (!token) {
        resetAuth()
        setLoadAuth(false)
        return
      }

      try {
        const [verify, userData] = await Promise.all([
          verifyToken(),
          getUser()
        ])

        if (!verify) {
          resetAuth()
        } else {
          setUser(userData.data.user)
          setUserType(userData.data.type)
        }
      } catch (error) {
        console.error("Erro ao autenticar:", error)
        resetAuth()
      } finally {
        setLoadAuth(false)
      }
    }

    handleAuth()
  }, [])

  const login = async (loginData) => {
    localStorage.setItem('token', loginData.token)

    try {
      const userData = await getUser()
      setUser(userData.data.user)
      localStorage.setItem('companyId', userData.data.user.id)
      setUserType(userData.data.type)
    } catch (error) {
      console.error("Erro no login:", error)
    }
  }

  const logout = () => {
    resetAuth()
    setLoadAuth(false)
    navigate('/login')
  }

  return loadAuth ? <BackDrop isOpen={true} /> : (
    <AuthContext.Provider value={{ user, login, logout, userType }}>
      {children}
    </AuthContext.Provider>
  )
}
