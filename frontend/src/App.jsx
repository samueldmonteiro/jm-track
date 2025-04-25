import { Routes, Route, useLocation } from 'react-router-dom';
import React, { useEffect, useState, useMemo } from 'react';
import { createTheme, ThemeProvider, CssBaseline, Button, Box } from '@mui/material';

import './css/style.css';

import './charts/ChartjsConfig';
import "@radix-ui/themes/styles.css";

// Import pages
import Dashboard from './pages/Dashboard';
import Test from './pages/Test';

function App() {

  const location = useLocation();

  const isDarkMode = true;

  const theme = useMemo(() =>
    createTheme({
      palette: {
        mode: isDarkMode ? 'dark' : 'light',
        primary: {
          main: '#90caf9', // azul claro
        },
        secondary: {
          main: '#f48fb1', // rosa claro
        },
        background: {
          default: isDarkMode ? '#1f2937' : '#ffffff',
          paper: isDarkMode ? '#1e1e1e' : '#f5f5f5',
        },
        text: {
          primary: isDarkMode ? '#ffffff' : '#000000',
          secondary: isDarkMode ? '#aaaaaa' : '#555555',
        },
      },
      typography: {
        fontFamily: '"Inter", "Roboto", "Helvetica", "Arial", sans-serif',
      },
    }), []);

  useEffect(() => {
    document.querySelector('html').style.scrollBehavior = 'auto'
    window.scroll({ top: 0 })
    document.querySelector('html').style.scrollBehavior = ''
  }, [location.pathname]); // triggered on route change

  return (
    <>
      <ThemeProvider theme={theme}>
        <Routes>
          <Route exact path="/" element={<Dashboard />} />
          <Route exact path="/teste" element={<Test />} />
        </Routes>
      </ThemeProvider>

    </>
  );
}

export default App;
