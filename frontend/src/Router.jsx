import { Routes, Route } from 'react-router-dom';

import './css/style.css';
import './charts/ChartjsConfig';
import "@radix-ui/themes/styles.css";

// Import pages
import Dashboard from './pages/Dashboard';
import Home from './pages/Traffic/Home';
import Campaigns from './pages/Traffic/Campaign/Campaigns';
import Campaign from './pages/Traffic/Campaign/Campaign';
import ProtectedRoute from './auth/ProtectedRoute';
import Login from './pages/auth/LoginController';

function Router() {
  return (
    <Routes>
      {/* Company  */}
      <Route exact path="/" element={
        <ProtectedRoute allowed={['company']}><Dashboard /></ProtectedRoute>} />

      <Route exact path="/painel/empresa" element={
        <ProtectedRoute allowed={['company']}><Dashboard /></ProtectedRoute>} />

      {/* Company - Paid Traffic */}
      <Route exact path="/painel/empresa/trafego" element={
        <ProtectedRoute allowed={['company']}>
          <Home />
        </ProtectedRoute>} />

      <Route exact path="/painel/empresa/trafego/campanhas" element={
        <ProtectedRoute allowed={['company']}>
          <Campaigns />
        </ProtectedRoute>} />

      <Route exact path="/painel/empresa/trafego/campanhas/:id" element={
        <ProtectedRoute allowed={['company']}>
          <Campaign />
        </ProtectedRoute>} />

      {/* Auth */}
      <Route exact path="/login" element={<Login />} />

    </Routes>
  );
}

export default Router;
