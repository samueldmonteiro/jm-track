import React, { useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import LoginCompany from './LoginCompany';
import LoginTechnical from './LoginTechnical';
import Logo from '../../images/logo.png'

const Login = () => {
  const [userType, setUserType] = useState('companhia');

  return (
    <section className="bg-gray-50 dark:bg-gray-900 min-h-screen flex items-center justify-center px-4">
      <div className="w-full max-w-md bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <div className="mb-6 text-center">
          <img
            className="w-10 h-10 mx-auto mb-2"
            src={Logo}
            alt="logo"
          />
          <h1 className="text-2xl font-bold text-gray-900 dark:text-white">JM Track</h1>
        </div>

        {/* Tabs */}
        <div className="flex justify-center mb-6 border-b dark:border-gray-700">
          {['companhia', 'tecnico'].map((type) => (
            <button
              key={type}
              onClick={() => setUserType(type)}
              className={`cursor-pointer px-4 py-2 text-sm font-medium transition-all duration-200 ${
                userType === type
                  ? 'text-indigo-600 border-b-2 border-indigo-600'
                  : 'text-gray-500 hover:text-indigo-600'
              }`}
            >
              {type === 'companhia' ? 'Companhia' : 'Técnico'}
            </button>
          ))}
        </div>

        {/* Formulário com animação */}
        <AnimatePresence mode="wait">
          <motion.div
            key={userType}
            initial={{ opacity: 0, x: 30 }}
            animate={{ opacity: 1, x: 0 }}
            exit={{ opacity: 0, x: -30 }}
            transition={{ duration: 0.3 }}
          >
            {userType === 'companhia' ? <LoginCompany /> : <LoginTechnical />}
          </motion.div>
        </AnimatePresence>
      </div>
    </section>
  );
};

export default Login;
