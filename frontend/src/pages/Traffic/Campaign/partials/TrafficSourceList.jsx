// src/components/campaign/TrafficSourceList.js
import React from 'react';

const TrafficSourceList = ({ trafficSources, onSourceClick, campaign }) => {
  return (
    <div className="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden mb-8">
      <div className="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <h3 className="text-lg font-semibold">Fontes de Tráfego</h3>
      </div>
      <div className="divide-y divide-gray-200 dark:divide-gray-700">
        {trafficSources.map(source => {
          const sourceTransactions = campaign?.trafficTransactions?.filter(t => t.trafficSource?.id === source.id) || [];
          const expenses = sourceTransactions.filter(t => t.type === 'expense');
          const returns = sourceTransactions.filter(t => t.type === 'return');
          const totalExpense = expenses.reduce((sum, exp) => sum + parseFloat(exp.amount), 0);
          const totalReturn = returns.reduce((sum, ret) => sum + parseFloat(ret.amount), 0);

          return (
            <div 
              key={source.id} 
              className="p-6 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer"
              onClick={() => onSourceClick(source)}
            >
              <div className="flex items-center justify-between">
                <div className="flex items-center">
                  <img 
                    src={source.image} 
                    alt={source.name} 
                    className="w-10 h-10 rounded-full mr-4 object-cover"
                  />
                  <div>
                    <h4 className="font-medium">{source.name}</h4>
                    <p className="text-sm text-gray-500 dark:text-gray-400">
                      {expenses.length} gastos • {returns.length} retornos
                    </p>
                  </div>
                </div>
                <div className="text-right">
                  <p className="font-medium">
                    {totalExpense.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}
                  </p>
                  <p className={`text-sm ${totalReturn >= totalExpense ? 'text-green-500 dark:text-green-400' : 'text-red-500 dark:text-red-400'}`}>
                    {totalReturn.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}
                  </p>
                </div>
              </div>
            </div>
          );
        })}
      </div>
    </div>
  );
};

export default TrafficSourceList;