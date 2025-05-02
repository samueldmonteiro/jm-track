import React from 'react';
import { CircularProgress } from '@mui/material';

const LoadAuth = () => {
  return (
    <div className="fixed inset-0 z-50 bg-white/70 flex items-center justify-center">
      <CircularProgress size={60} thickness={5} />
    </div>
  );
};

export default LoadAuth;