import { useLocation } from 'react-router-dom';
import React, { useEffect } from 'react';
import ThemeProvider from './context/ThemeContext';
import { AuthProvider } from './auth/AuthContext';
import GeneralProvider from './context/GeneralContext';
import Router from './Router';

import './css/style.css';
import './charts/ChartjsConfig';
import "@radix-ui/themes/styles.css";

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
          <GeneralProvider>
            <Router />
          </GeneralProvider>
        </ThemeProvider>
      </AuthProvider>
    </>
  );
}

export default App;
