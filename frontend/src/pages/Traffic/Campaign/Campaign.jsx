import React, { useEffect, useState } from 'react'
import Sidebar from '../../../partials/Sidebar';
import Header from '../../../partials/Header';
import { useParams, useNavigate } from 'react-router-dom';
import { findById, deleteCampaign, deleteTrafficExpense, deleteTrafficReturn } from '../../../services/company/campaignService';
import BackDrop from '../../../components/Loads/BackDrop';
import { Bar, Pie } from 'react-chartjs-2';
import { Chart, registerables } from 'chart.js';
import { FiEdit, FiTrash2, FiPlus, FiChevronLeft } from 'react-icons/fi';

import { FiX } from 'react-icons/fi';

const Modal = ({ 
  isOpen, 
  onClose, 
  children, 
  width = 'max-w-md',
  closeOnOverlayClick = true 
}) => {
  useEffect(() => {
    if (isOpen) {
      document.body.style.overflow = 'hidden';
    } else {
      document.body.style.overflow = 'auto';
    }

    return () => {
      document.body.style.overflow = 'auto';
    };
  }, [isOpen]);

  // Fecha modal ao pressionar ESC
  useEffect(() => {
    const handleKeyDown = (e) => {
      if (e.key === 'Escape') {
        onClose();
      }
    };

    if (isOpen) {
      document.addEventListener('keydown', handleKeyDown);
    }

    return () => {
      document.removeEventListener('keydown', handleKeyDown);
    };
  }, [isOpen, onClose]);

  if (!isOpen) return null;

  return (
    <div className="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center">
      {/* Overlay */}
      <div 
        className="absolute inset-0 bg-black bg-opacity-50"
        onClick={closeOnOverlayClick ? onClose : null}
      />
  
      {/* Modal container */}
      <div 
        className={`relative z-10 bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full ${width}`}
        role="dialog"
        aria-modal="true"
        aria-labelledby="modal-headline"
      >
        {/* Close button */}
        <button
          onClick={onClose}
          className="absolute top-4 right-4 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none"
          aria-label="Fechar modal"
        >
          <FiX className="h-6 w-6" />
        </button>
  
        {/* Content */}
        {children}
      </div>
    </div>
  );
  
};

const TrafficSourceModal = ({ isOpen, onClose, campaignId, trafficSources, selectedSource, onSuccess }) => {
  const [formData, setFormData] = useState({
    date: '',
    amount: '',
    trafficSourceId: selectedSource?.id || '',
    type: 'expense'
  });

  const handleSubmit = (e) => {
    e.preventDefault();
    // Implement API call to add traffic entry
    console.log('Submitting:', formData);
    onSuccess();
  };

  return (
    <Modal isOpen={isOpen} onClose={onClose}>
      <div className="p-6">
        <div className="flex justify-between items-center mb-4">
          <h3 className="text-xl font-semibold">
            {selectedSource ? `Adicionar entrada para ${selectedSource.name}` : 'Adicionar nova entrada de tráfego'}
          </h3>
          <button onClick={onClose} className="text-gray-500 hover:text-gray-700">
            <FiX className="text-xl" />
          </button>
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
                  {trafficSources.map(source => (
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


Chart.register(...registerables);

const Campaign = () => {
  const [sidebarOpen, setSidebarOpen] = useState(false);
  const [campaign, setCampaign] = useState(null);
  const [loading, setLoading] = useState(true);
  const [editModalOpen, setEditModalOpen] = useState(false);
  const [deleteModalOpen, setDeleteModalOpen] = useState(false);
  const [trafficSourceModalOpen, setTrafficSourceModalOpen] = useState(false);
  const [selectedTrafficSource, setSelectedTrafficSource] = useState(null);
  const [selectedTab, setSelectedTab] = useState('expenses');
  const [campaignName, setCampaignName] = useState('');
  const { id } = useParams();
  const navigate = useNavigate();

  useEffect(() => {
    fetchCampaign();
  }, []);

  const fetchCampaign = () => {
    setLoading(true);
    findById(id).then(resp => {
      setCampaign(resp.data.data);
      console.log(resp.data.data)
      setCampaignName(resp.data.data.name);
      setLoading(false);
    }).catch(() => {
      setLoading(false);
    });
  };

  const handleDeleteCampaign = () => {
    deleteCampaign(id).then(() => {
      navigate('/campaigns');
    });
  };

  const handleDeleteExpense = (expenseId) => {
    deleteTrafficExpense(id, expenseId).then(() => {
      fetchCampaign();
    });
  };

  const handleDeleteReturn = (returnId) => {
    deleteTrafficReturn(id, returnId).then(() => {
      fetchCampaign();
    });
  };

  const calculateMetrics = () => {
    if (!campaign) return {};
    
    const totalCost = campaign?.trafficExpenses?.reduce((sum, expense) => sum + expense.amount, 0);
    const totalReturn = campaign?.trafficReturns?.reduce((sum, ret) => sum + ret.amount, 0);
    const netProfit = totalReturn - totalCost;
    const roi = totalCost > 0 ? ((totalReturn - totalCost) / totalCost) * 100 : 0;
    
    return {
      totalCost,
      totalReturn,
      netProfit,
      roi: roi.toFixed(2)
    };
  };

  const getTrafficSourceData = (sourceId) => {
    if (!campaign) return { expenses: [], returns: [] };
    
    const expenses = campaign?.trafficExpenses?.filter(exp => exp.trafficSource?.id === sourceId);
    const returns = campaign?.trafficReturns?.filter(ret => ret.trafficSource?.id === sourceId);
    
    return { expenses, returns };
  };

  const metrics = calculateMetrics();
  const trafficSources = [...new Set([
    ...(campaign?.trafficExpenses?.map(exp => exp.trafficSource) || []),
    ...(campaign?.trafficReturns?.map(ret => ret.trafficSource) || [])
  ])];

  // Chart data
  const barChartData = {
    labels: ['Custo Total', 'Retorno Total', 'Lucro Líquido'],
    datasets: [{
      label: 'Valores Financeiros',
      data: [metrics?.totalCost, metrics?.totalReturn, metrics?.netProfit],
      backgroundColor: [
        'rgba(255, 99, 132, 0.7)',
        'rgba(54, 162, 235, 0.7)',
        'rgba(75, 192, 192, 0.7)'
      ],
      borderColor: [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(75, 192, 192, 1)'
      ],
      borderWidth: 1
    }]
  };

  const pieChartData = {
    labels: trafficSources.map(source => source.name),
    datasets: [{
      data: trafficSources.map(source => {
        const sourceExpenses = campaign?.trafficExpenses
          .filter(exp => exp.trafficSource?.id === source.id)
          .reduce((sum, exp) => sum + exp.amount, 0);
        return sourceExpenses;
      }),
      backgroundColor: [
        'rgba(255, 99, 132, 0.7)',
        'rgba(54, 162, 235, 0.7)',
        'rgba(255, 206, 86, 0.7)',
        'rgba(75, 192, 192, 0.7)',
        'rgba(153, 102, 255, 0.7)',
        'rgba(255, 159, 64, 0.7)'
      ],
      borderWidth: 1
    }]
  };

  if (loading) return <BackDrop isOpen={true} />;

  return (
    <div className="flex h-screen overflow-hidden">
      {/* Sidebar */}
      <Sidebar sidebarOpen={sidebarOpen} setSidebarOpen={setSidebarOpen} />

      {/* Content area */}
      <div className="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
        {/* Site header */}
        <Header sidebarOpen={sidebarOpen} setSidebarOpen={setSidebarOpen} />

        <main className="grow">
          <div className="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
            {/* Dashboard actions */}
            {!campaign ? (
              <BackDrop isOpen={true} />
            ) : (
              <>
                <div className="sm:flex sm:justify-between sm:items-center mb-8">
                  {/* Left: Title and back button */}
                  <div className="mb-4 sm:mb-0 flex items-center">
                    <button 
                      onClick={() => navigate(-1)} 
                      className="mr-4 p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700"
                    >
                      <FiChevronLeft className="text-xl" />
                    </button>
                    <div>
                      <h1 className="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">
                        {campaign?.name}
                        <button 
                          onClick={() => setEditModalOpen(true)}
                          className="ml-2 text-blue-500 hover:text-blue-700"
                        >
                          <FiEdit className="inline" />
                        </button>
                      </h1>
                      <p className="text-sm text-gray-500 dark:text-gray-400">
                        {new Date(campaign?.start_date).toLocaleDateString()} - {new Date(campaign?.end_date).toLocaleDateString()}
                      </p>
                    </div>
                  </div>

                  {/* Right: Actions */}
                  <div className="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                    <button
                      onClick={() => setTrafficSourceModalOpen(true)}
                      className="btn bg-indigo-500 hover:bg-indigo-600 text-white"
                    >
                      <FiPlus className="mr-2" /> Adicionar Tráfego
                    </button>
                    <button
                      onClick={() => setDeleteModalOpen(true)}
                      className="btn bg-red-500 hover:bg-red-600 text-white"
                    >
                      <FiTrash2 className="mr-2" /> Excluir Campanha
                    </button>
                  </div>
                </div>

                {/* Metrics Cards */}
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

                {/* Charts */}
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

                {/* Traffic Sources */}
                <div className="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden mb-8">
                  <div className="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 className="text-lg font-semibold">Fontes de Tráfego</h3>
                  </div>
                  <div className="divide-y divide-gray-200 dark:divide-gray-700">
                    {trafficSources.map(source => (
                      <div 
                        key={source.id} 
                        className="p-6 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer"
                        onClick={() => setSelectedTrafficSource(source)}
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
                                {campaign?.trafficExpenses?.filter(exp => exp.trafficSource?.id === source.id).length} gastos • 
                                {campaign?.trafficReturns?.filter(ret => ret.trafficSource?.id === source.id).length} retornos
                              </p>
                            </div>
                          </div>
                          <div className="text-right">
                            <p className="font-medium">
                              {campaign?.trafficExpenses
                                .filter(exp => exp.trafficSource?.id === source.id)
                                .reduce((sum, exp) => sum + exp.amount, 0)
                                .toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}
                            </p>
                            <p className={`text-sm ${campaign?.trafficReturns
                              .filter(ret => ret.trafficSource?.id === source.id)
                              .reduce((sum, ret) => sum + ret.amount, 0) >= 
                              campaign?.trafficExpenses
                                .filter(exp => exp.trafficSource?.id === source.id)
                                .reduce((sum, exp) => sum + exp.amount, 0) ? 
                              'text-green-500 dark:text-green-400' : 'text-red-500 dark:text-red-400'}`}
                            >
                              {campaign?.trafficReturns
                                .filter(ret => ret.trafficSource?.id === source.id)
                                .reduce((sum, ret) => sum + ret.amount, 0)
                                .toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}
                            </p>
                          </div>
                        </div>
                      </div>
                    ))}
                  </div>
                </div>

                {/* Campaign Metrics */}
                <div className="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden mb-8">
                  <div className="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 className="text-lg font-semibold">Métricas da Campanha</h3>
                  </div>
                  <div className="p-6">
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                      {campaign?.campaignMetrics?.map((metric, index) => (
                        <div key={index} className="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                          <h4 className="font-medium mb-2">Clientes Retornando</h4>
                          <p className="text-2xl font-bold text-indigo-500 dark:text-indigo-400">
                            {metric.returningCustomers}
                          </p>
                        </div>
                      ))}
                    </div>
                  </div>
                </div>
              </>
            )}
          </div>
        </main>
      </div>

      {/* Edit Campaign Modal */}
      <Modal isOpen={editModalOpen} onClose={() => setEditModalOpen(false)}>
        <div className="p-6">
          <h3 className="text-xl font-semibold mb-4">Editar Campanha</h3>
          <div className="mb-4">
            <label className="block text-sm font-medium mb-1">Nome da Campanha</label>
            <input
              type="text"
              className="form-input w-full"
              value={campaignName}
              onChange={(e) => setCampaignName(e.target.value)}
            />
          </div>
          <div className="flex justify-end space-x-3">
            <button
              onClick={() => setEditModalOpen(false)}
              className="btn border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300"
            >
              Cancelar
            </button>
            <button
              onClick={() => {
                // Implement update logic here
                setEditModalOpen(false);
              }}
              className="btn bg-indigo-500 hover:bg-indigo-600 text-white"
            >
              Salvar
            </button>
          </div>
        </div>
      </Modal>

      {/* Delete Campaign Modal */}
      <Modal isOpen={deleteModalOpen} onClose={() => setDeleteModalOpen(false)}>
        <div className="p-6">
          <h3 className="text-xl font-semibold mb-4">Excluir Campanha</h3>
          <p className="mb-6">Tem certeza que deseja excluir esta campanha? Esta ação não pode ser desfeita.</p>
          <div className="flex justify-end space-x-3">
            <button
              onClick={() => setDeleteModalOpen(false)}
              className="btn border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300"
            >
              Cancelar
            </button>
            <button
              onClick={handleDeleteCampaign}
              className="btn bg-red-500 hover:bg-red-600 text-white"
            >
              Excluir
            </button>
          </div>
        </div>
      </Modal>

      {/* Traffic Source Details Modal */}
      {selectedTrafficSource && (
        <Modal isOpen={!!selectedTrafficSource} onClose={() => setSelectedTrafficSource(null)} width="max-w-4xl">
          <div className="p-6">
            <div className="flex items-center justify-between mb-6">
              <div className="flex items-center">
                <img 
                  src={selectedTrafficSource?.image} 
                  alt={selectedTrafficSource?.name} 
                  className="w-12 h-12 rounded-full mr-4 object-cover"
                />
                <h3 className="text-xl font-semibold">{selectedTrafficSource?.name}</h3>
              </div>
              <button
                onClick={() => setTrafficSourceModalOpen(true)}
                className="btn bg-indigo-500 hover:bg-indigo-600 text-white"
              >
                <FiPlus className="mr-2" /> Adicionar Entrada
              </button>
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
                    getTrafficSourceData(selectedTrafficSource?.id).expenses.length > 0 ? (
                      getTrafficSourceData(selectedTrafficSource?.id).expenses.map(expense => (
                        <tr key={expense.id}>
                          <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {new Date(expense.date).toLocaleDateString()}
                          </td>
                          <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-red-500">
                            {expense.amount.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}
                          </td>
                          <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button
                              onClick={() => handleDeleteExpense(expense.id)}
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
                    getTrafficSourceData(selectedTrafficSource?.id).returns.length > 0 ? (
                      getTrafficSourceData(selectedTrafficSource?.id).returns.map(ret => (
                        <tr key={ret.id}>
                          <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {new Date(ret.date).toLocaleDateString()}
                          </td>
                          <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-500">
                            {ret.amount.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}
                          </td>
                          <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button
                              onClick={() => handleDeleteReturn(ret.id)}
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
      )}

      {/* Add Traffic Source Entry Modal */}
      <TrafficSourceModal 
        isOpen={trafficSourceModalOpen}
        onClose={() => setTrafficSourceModalOpen(false)}
        campaignId={id}
        trafficSources={trafficSources}
        selectedSource={selectedTrafficSource}
        onSuccess={() => {
          fetchCampaign();
          setTrafficSourceModalOpen(false);
          setSelectedTrafficSource(null);
        }}
      />
    </div>
  );
};

export default Campaign;