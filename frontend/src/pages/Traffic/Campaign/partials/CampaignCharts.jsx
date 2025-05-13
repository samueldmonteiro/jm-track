// src/components/campaign/CampaignCharts.js
import React from 'react';
import { Bar, Pie } from 'react-chartjs-2';

const CampaignCharts = ({ barChartData, pieChartData }) => {
  return (
    <div className="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
      <div className="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 className="text-lg font-semibold mb-4">Resumo Financeiro</h3>
        <div className="h-64">
          <Bar 
            data={barChartData}
            options={{
              responsive: true,
              maintainAspectRatio: false,
              scales: {
                y: {
                  beginAtZero: true
                }
              }
            }}
          />
        </div>
      </div>
      <div className="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 className="text-lg font-semibold mb-4">Distribuição de Custos por Fonte</h3>
        <div className="h-64">
          <Pie 
            data={pieChartData}
            options={{
              responsive: true,
              maintainAspectRatio: false
            }}
          />
        </div>
      </div>
    </div>
  );
};

export default CampaignCharts;