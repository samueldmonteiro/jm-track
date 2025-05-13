// src/pages/Campaign.js
import React, { useEffect, useState } from 'react';
import Sidebar from '../../../partials/Sidebar';
import Header from '../../../partials/Header';
import { useParams, useNavigate } from 'react-router-dom';
import { findById, deleteCampaign } from '../../../services/company/campaignService';
import BackDrop from '../../../components/Loads/BackDrop';
import { Chart, registerables } from 'chart.js';
import CampaignHeader from './partials/CampaignHeader';
import CampaignMetrics from './partials/CampaignMetrics';
import CampaignCharts from './partials/CampaignCharts';
import TrafficSourceList from './partials/TrafficSourceList';
import TrafficSourceDetails from './partials/TrafficSourceDetails';
import TrafficSourceModal from './partials/TrafficSourceModal';
import EditModal from './partials/EditModal';
import DeleteModal from './partials/DeleteModal';
import { deleteTrafficTransaction } from '../../../services/company/TrafficTransactionService';

Chart.register(...registerables);

const Campaign = () => {
  const [sidebarOpen, setSidebarOpen] = useState(false);
  const [campaign, setCampaign] = useState(null);
  const [loading, setLoading] = useState(true);
  const [editModalOpen, setEditModalOpen] = useState(false);
  const [deleteModalOpen, setDeleteModalOpen] = useState(false);
  const [trafficSourceModalOpen, setTrafficSourceModalOpen] = useState(false);
  const [selectedTrafficSource, setSelectedTrafficSource] = useState(null);
  const [campaignName, setCampaignName] = useState('');
  const { id } = useParams();
  const navigate = useNavigate();

  useEffect(() => {
    fetchCampaign();
  }, []);

  const fetchCampaign = () => {
    setLoading(true);
    findById(id).then(resp => {
      setCampaign(resp.data.data.campaign);
      setCampaignName(resp.data.data.campaign.name);
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

  const handleDeleteTransaction = (transactionId) => {
    deleteTrafficTransaction(transactionId).then(() => {
      fetchCampaign();
    });
  };

  const calculateMetrics = () => {
    if (!campaign) return {};

    const expenses = campaign.trafficTransactions?.filter(t => t.type === 'expense') || [];
    const returns = campaign.trafficTransactions?.filter(t => t.type === 'return') || [];

    const totalCost = expenses.reduce((sum, expense) => sum + parseFloat(expense.amount), 0);
    const totalReturn = returns.reduce((sum, ret) => sum + parseFloat(ret.amount), 0);
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

    const transactions = campaign.trafficTransactions || [];
    const expenses = transactions.filter(t => t.type === 'expense' && t.trafficSource?.id === sourceId);
    const returns = transactions.filter(t => t.type === 'return' && t.trafficSource?.id === sourceId);

    return { expenses, returns };
  };

  const getUniqueTrafficSources = () => {
    if (!campaign || !campaign.trafficTransactions) return [];

    const sources = new Map();
    campaign.trafficTransactions.forEach(transaction => {
      if (transaction.trafficSource && !sources.has(transaction.trafficSource.id)) {
        sources.set(transaction.trafficSource.id, transaction.trafficSource);
      }
    });

    return Array.from(sources.values());
  };

  const metrics = calculateMetrics();
  const trafficSources = getUniqueTrafficSources();

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
        const sourceExpenses = campaign.trafficTransactions
          ?.filter(t => t.type === 'expense' && t.trafficSource?.id === source.id)
          ?.reduce((sum, t) => sum + parseFloat(t.amount), 0) || 0;
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
      <Sidebar sidebarOpen={sidebarOpen} setSidebarOpen={setSidebarOpen} />

      <div className="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
        <Header sidebarOpen={sidebarOpen} setSidebarOpen={setSidebarOpen} />

        <main className="grow">
          <div className="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
            {!campaign ? (
              <BackDrop isOpen={true} />
            ) : (
              <>
                <CampaignHeader
                  campaign={campaign}
                  campaignName={campaignName}
                  onEditClick={() => setEditModalOpen(true)}
                  onDeleteClick={() => setDeleteModalOpen(true)}
                  onAddTrafficClick={() => setTrafficSourceModalOpen(true)}
                />

                <CampaignMetrics metrics={metrics} />

                <CampaignCharts
                  barChartData={barChartData}
                  pieChartData={pieChartData}
                />

                <TrafficSourceList
                  campaign={campaign}
                  trafficSources={trafficSources}
                  onSourceClick={setSelectedTrafficSource}
                />

                {campaign?.campaignMetrics?.length > 0 && (
                  <div className="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden mb-8">
                    <div className="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                      <h3 className="text-lg font-semibold">Métricas da Campanha</h3>
                    </div>
                    <div className="p-6">
                      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {campaign.campaignMetrics.map((metric, index) => (
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
                )}
              </>
            )}
          </div>
        </main>
      </div>

      <EditModal
      campaign={campaign}
        isOpen={editModalOpen}
        onClose={() => setEditModalOpen(false)}
        campaignName={campaignName}
        onNameChange={(e) => setCampaignName(e.target.value)}
        onSave={() => {
          // Implement update logic here
          setEditModalOpen(false);
        }}
      />

      <DeleteModal
        isOpen={deleteModalOpen}
        onClose={() => setDeleteModalOpen(false)}
        onConfirm={handleDeleteCampaign}
        campaign={campaign}
      />

      <TrafficSourceDetails
        source={selectedTrafficSource}
        onClose={() => setSelectedTrafficSource(null)}
        onAddEntryClick={() => setTrafficSourceModalOpen(true)}
        onDeleteTransaction={handleDeleteTransaction}
        getTrafficSourceData={getTrafficSourceData}
      />

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