import { Routes, Route, useLocation } from 'react-router-dom';
import React, { useEffect, useState, useMemo } from 'react';
import { createTheme, ThemeProvider as MUIThemeProvider, CssBaseline, Button, Box } from '@mui/material';

import './css/style.css';

import './charts/ChartjsConfig';
import "@radix-ui/themes/styles.css";

// Import pages
import Dashboard from './pages/Dashboard';
import Test from './pages/Test';
import ThemeProvider from './utils/ThemeContext';

function App() {

  const location = useLocation();

  useEffect(() => {
    document.querySelector('html').style.scrollBehavior = 'auto'
    window.scroll({ top: 0 })
    document.querySelector('html').style.scrollBehavior = ''
  }, [location.pathname]);

  return (
    <>
      <ThemeProvider>
        <Routes>
          <Route exact path="/" element={<Dashboard />} />
          <Route exact path="/teste" element={<Test />} />
        </Routes>
      </ThemeProvider>

    </>
  );
}

export default App;
