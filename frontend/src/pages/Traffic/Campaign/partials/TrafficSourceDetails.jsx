// src/components/campaign/TrafficSourceDetails.js
import React, { useState } from 'react';
import { FiPlus, FiTrash2 } from 'react-icons/fi';
import Modal from './Modal';

const TrafficSourceDetails = ({ 
  source, 
  onClose, 
  onAddEntryClick,
  onDeleteTransaction,
  getTrafficSourceData 
}) => {
  const [selectedTab, setSelectedTab] = useState('expenses');

  return (
    <Modal isOpen={!!source} onClose={onClose} width="max-w-4xl">
      <div className="p-6">
        <div className="flex items-center justify-between mb-6">
          <div className="flex items-center">
            <img 
              src={source?.image} 
              alt={source?.name} 
              className="w-12 h-12 rounded-full mr-4 object-cover"
            />
            <h3 className="text-xl font-semibold">{source?.name}</h3>
          </div>
          {null &&<>
          <button
            onClick={onAddEntryClick}
            className="btn bg-indigo-500 hover:bg-indigo-600 text-white"
          >
            <FiPlus className="mr-2" /> Adicionar Entrada
          </button></>}
        </div>

        <div className="mb-6">
          <div className="flex border-b border-gray-200 dark:border-gray-700">
            <button
              className={`py-2 px-4 font-medium ${selectedTab === 'expenses' ? 'text-indigo-500 border-b-2 border-indigo-500' : 'text-gray-500'}`}
              onClick={() => setSelectedTab('expenses')}
            >
              Gastos
            </button>
            <button
              className={`py-2 px-4 font-medium ${selectedTab === 'returns' ? 'text-indigo-500 border-b-2 border-indigo-500' : 'text-gray-500'}`}
              onClick={() => setSelectedTab('returns')}
            >
              Retornos
            </button>
          </div>
        </div>

        <div className="overflow-auto">
          <table className="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead className="bg-gray-50 dark:bg-gray-800">
              <tr>
                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Data</th>
                <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Valor</th>
                <th className="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ações</th>
              </tr>
            </thead>
            <tbody className="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
              {selectedTab === 'expenses' ? (
                getTrafficSourceData(source?.id).expenses.length > 0 ? (
                  getTrafficSourceData(source?.id).expenses.map(expense => (
                    <tr key={expense.id}>
                      <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        {new Date(expense.date).toLocaleDateString()}
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-red-500">
                        {parseFloat(expense.amount).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button
                          onClick={() => onDeleteTransaction(expense.id)}
                          className="text-red-500 hover:text-red-700 ml-4"
                        >
                          <FiTrash2 />
                        </button>
                      </td>
                    </tr>
                  ))
                ) : (
                  <tr>
                    <td colSpan="3" className="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                      Nenhum gasto registrado para esta fonte
                    </td>
                  </tr>
                )
              ) : (
                getTrafficSourceData(source?.id).returns.length > 0 ? (
                  getTrafficSourceData(source?.id).returns.map(ret => (
                    <tr key={ret.id}>
                      <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        {new Date(ret.date).toLocaleDateString()}
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-500">
                        {parseFloat(ret.amount).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}
                      </td>
                      <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button
                          onClick={() => onDeleteTransaction(ret.id)}
                          className="text-red-500 hover:text-red-700 ml-4"
                        >
                          <FiTrash2 />
                        </button>
                      </td>
                    </tr>
                  ))
                ) : (
                  <tr>
                    <td colSpan="3" className="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                      Nenhum retorno registrado para esta fonte
                    </td>
                  </tr>
                )
              )}
            </tbody>
          </table>
        </div>
      </div>
    </Modal>
  );
};

export default TrafficSourceDetails;