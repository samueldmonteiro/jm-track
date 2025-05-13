// src/components/campaign/TrafficSourceModal.js
import React, { useEffect, useState } from 'react';
import { FiX } from 'react-icons/fi';
import Modal from './Modal';
import { findAll } from '../../../../services/company/TrafficSourceService';
import { createTrafficTransaction } from '../../../../services/company/TrafficTransactionService';

const TrafficSourceModal = ({ isOpen, onClose, campaignId, trafficSources, selectedSource, onSuccess }) => {
  const [formData, setFormData] = useState({
    date: '',
    amount: '',
    trafficSourceId: selectedSource?.id || '',
    type: 'expense',
    campaignId: campaignId
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    // Implement API call to add traffic entry
    console.log('Submitting:', formData, campaignId);

    createTrafficTransaction(formData).then(resp=>{
      console.log("RESILTADI", resp.data)
      onSuccess();

    })
  };

  const [realTrafficSources, setRealTrafficSources] = useState([]);
  useEffect(() => {
    findAll().then(resp => {
      setRealTrafficSources(resp.data.data.trafficSources);
    })
  }, [])

  return (
    <Modal isOpen={isOpen} onClose={onClose}>
      <div className="p-6">
        <div className="flex justify-between items-center mb-4">
          <h3 className="text-xl font-semibold">
            {selectedSource ? `Adicionar entrada para ${selectedSource.name}` : 'Adicionar nova entrada de tráfego'}
          </h3>
        </div>

        <form onSubmit={handleSubmit}>
          <div className="space-y-4">
            {!selectedSource && (
              <div>
                <label className="block text-sm font-medium mb-1">Fonte de Tráfego</label>
                <select
                  className="form-select w-full"
                  value={formData.trafficSourceId}
                  onChange={(e) => setFormData({ ...formData, trafficSourceId: e.target.value })}
                  required
                >
                  <option value="">Selecione uma fonte</option>
                  {realTrafficSources.map(source => (
                    <option key={source.id} value={source.id}>{source.name}</option>
                  ))}
                </select>
              </div>
            )}

            <div>
              <label className="block text-sm font-medium mb-1">Tipo</label>
              <div className="flex space-x-4">
                <label className="inline-flex items-center">
                  <input
                    type="radio"
                    className="form-radio"
                    name="type"
                    value="expense"
                    checked={formData.type === 'expense'}
                    onChange={() => setFormData({ ...formData, type: 'expense' })}
                  />
                  <span className="ml-2">Gasto</span>
                </label>
                <label className="inline-flex items-center">
                  <input
                    type="radio"
                    className="form-radio"
                    name="type"
                    value="return"
                    checked={formData.type === 'return'}
                    onChange={() => setFormData({ ...formData, type: 'return' })}
                  />
                  <span className="ml-2">Retorno</span>
                </label>
              </div>
            </div>

            <div>
              <label className="block text-sm font-medium mb-1">Data</label>
              <input
                type="date"
                className="form-input w-full"
                value={formData.date}
                onChange={(e) => setFormData({ ...formData, date: e.target.value })}
                required
              />
            </div>

            <div>
              <label className="block text-sm font-medium mb-1">Valor</label>
              <input
                type="number"
                step="0.01"
                className="form-input w-full"
                placeholder="0,00"
                value={formData.amount}
                onChange={(e) => setFormData({ ...formData, amount: e.target.value })}
                required
              />
            </div>
          </div>

          <div className="flex justify-end space-x-3 mt-6">
            <button
              type="button"
              onClick={onClose}
              className="btn border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300"
            >
              Cancelar
            </button>
            <button
              type="submit"
              className="btn bg-indigo-500 hover:bg-indigo-600 text-white"
            >
              Salvar
            </button>
          </div>
        </form>
      </div>
    </Modal>
  );
};

export default TrafficSourceModal;