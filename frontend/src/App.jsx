import { Routes, Route, useLocation } from 'react-router-dom';
import React, { useEffect, useState, useMemo } from 'react';
import { createTheme, ThemeProvider as MUIThemeProvider, CssBaseline, Button, Box } from '@mui/material';

import './css/style.css';

import './charts/ChartjsConfig';
import "@radix-ui/themes/styles.css";

// Import pages
import Dashboard from './pages/Dashboard';
import Test from './pages/Test';
import ThemeProvider from './context/ThemeContext';
import Home from './pages/Traffic/Home';
import { AuthProvider } from './auth/AuthContext';
import ProtectedRoute from './auth/ProtectedRoute';

function App() {

  const location = useLocation();

  useEffect(() => {
    document.querySelector('html').style.scrollBehavior = 'auto'
    window.scroll({ top: 0 })
    document.querySelector('html').style.scrollBehavior = ''
  }, [location.pathname]);

  return (
    <>
      <AuthProvider>
        <ThemeProvider>
          <Routes>
            <Route exact path="/" element={
              <ProtectedRoute allowed={['company']}><Dashboard /></ProtectedRoute>} />
            <Route exact path="/teste" element={<Test />} />
            <Route exact path="/trafego" element={<Home />} />

            <Route exact path="/login" element={<h1>LOGINN</h1>} />

          </Routes>
        </ThemeProvider>
      </AuthProvider>
    </>
  );
}

export default App;
