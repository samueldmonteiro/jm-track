// src/components/campaign/CampaignMetrics.js
import React from 'react';

const CampaignMetrics = ({ metrics }) => {
  return (
    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <div className="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 className="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Custo Total</h3>
        <p className="text-2xl font-bold text-red-500 dark:text-red-400">
          {metrics?.totalCost?.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}
        </p>
      </div>
      <div className="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 className="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Retorno Total</h3>
        <p className="text-2xl font-bold text-blue-500 dark:text-blue-400">
          {metrics?.totalReturn?.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}
        </p>
      </div>
      <div className="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 className="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Lucro Líquido</h3>
        <p className={`text-2xl font-bold ${metrics?.netProfit >= 0 ? 'text-green-500 dark:text-green-400' : 'text-red-500 dark:text-red-400'}`}>
          {metrics?.netProfit.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}
        </p>
      </div>
      <div className="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 className="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">ROI</h3>
        <p className={`text-2xl font-bold ${parseFloat(metrics?.roi) >= 0 ? 'text-green-500 dark:text-green-400' : 'text-red-500 dark:text-red-400'}`}>
          {metrics?.roi}%
        </p>
      </div>
    </div>
  );
};

export default CampaignMetrics;