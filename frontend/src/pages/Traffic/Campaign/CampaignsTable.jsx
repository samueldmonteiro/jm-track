import React, { useState, useMemo } from 'react';
import formatToBRL from '../../../utils/formatToBRL';
import { Link } from 'react-router-dom';

const statusMap = {
  open: <div className="text-center text-green-500">ABERTA</div>,
  closed: <div className="text-center text-red-500">FECHADA</div>,
  paused: <div className="text-center text-orange-500">PAUSADA</div>
};

const CampaignsTable = ({ campaigns = [] }) => {
  const [sortConfig, setSortConfig] = useState({ key: null, direction: 'asc' });
  const [filterValues, setFilterValues] = useState({
    name: '',
    status: '',
    minProfit: '',
    maxProfit: ''
  });

  const handleSort = (key) => {
    let direction = 'asc';
    if (sortConfig.key === key && sortConfig.direction === 'asc') {
      direction = 'desc';
    }
    setSortConfig({ key, direction });
  };

  const handleFilterChange = (e) => {
    const { name, value } = e.target;
    setFilterValues(prev => ({ ...prev, [name]: value }));
  };

  const filteredAndSortedCampaigns = useMemo(() => {
    let filtered = [...campaigns];

    // Apply filters
    if (filterValues.name) {
      filtered = filtered.filter(c =>
        c.name.toLowerCase().includes(filterValues.name.toLowerCase()));
    }

    if (filterValues.status) {
      filtered = filtered.filter(c => c.status === filterValues.status);
    }

    if (filterValues.minProfit) {
      filtered = filtered.filter(c => c.profit >= Number(filterValues.minProfit));
    }

    if (filterValues.maxProfit) {
      filtered = filtered.filter(c => c.profit <= Number(filterValues.maxProfit));
    }

    // Apply sorting
    if (sortConfig.key) {
      filtered.sort((a, b) => {
        let valueA, valueB;

        if (sortConfig.key === 'spent') {
          valueA = a.trafficExpenses?.reduce((acc, curr) => acc + curr.amount, 0) || 0;
          valueB = b.trafficExpenses?.reduce((acc, curr) => acc + curr.amount, 0) || 0;
        } else if (sortConfig.key === 'returns') {
          valueA = a.trafficReturns?.reduce((acc, curr) => acc + curr.amount, 0) || 0;
          valueB = b.trafficReturns?.reduce((acc, curr) => acc + curr.amount, 0) || 0;
        } else if (sortConfig.key === 'reaches') {
          valueA = a.campaignMetrics?.reduce((acc, curr) => acc + curr.returningCustomers, 0) || 0;
          valueB = b.campaignMetrics?.reduce((acc, curr) => acc + curr.returningCustomers, 0) || 0;
        } else {
          valueA = a[sortConfig.key];
          valueB = b[sortConfig.key];
        }

        if (valueA < valueB) {
          return sortConfig.direction === 'asc' ? -1 : 1;
        }
        if (valueA > valueB) {
          return sortConfig.direction === 'asc' ? 1 : -1;
        }
        return 0;
      });
    }

    return filtered;
  }, [campaigns, sortConfig, filterValues]);

  const getSortIndicator = (key) => {
    if (sortConfig.key !== key) return null;
    return sortConfig.direction === 'asc' ? '↑' : '↓';
  };

  return (
    <div className="col-span-full xl:col-span-8 bg-white dark:bg-gray-800 shadow-xs rounded-xl">
      <header className="px-5 py-4 border-b border-gray-100 dark:border-gray-700/60 flex justify-between items-center">
        <h2 className="font-semibold text-gray-800 dark:text-gray-100">Suas Campanhas</h2>
        <div className="relative">
        </div>
      </header>

      {/* Filters */}
      <div className="px-5 py-3 border-b border-gray-100 dark:border-gray-700/60 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div>
          <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome</label>
          <input
            type="text"
            name="name"
            placeholder="Filtrar por nome"
            className="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
            value={filterValues.name}
            onChange={handleFilterChange}
          />
        </div>
        <div>
          <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
          <select
            name="status"
            className="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
            value={filterValues.status}
            onChange={handleFilterChange}
          >
            <option value="">Todos</option>
            <option value="open">Aberta</option>
            <option value="closed">Fechada</option>
            <option value="paused">Pausada</option>
          </select>
        </div>
        <div>
          <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Lucro Mínimo</label>
          <input
            type="number"
            name="minProfit"
            placeholder="R$ 0,00"
            className="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
            value={filterValues.minProfit}
            onChange={handleFilterChange}
          />
        </div>
        <div>
          <label className="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Lucro Máximo</label>
          <input
            type="number"
            name="maxProfit"
            placeholder="R$ 0,00"
            className="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
            value={filterValues.maxProfit}
            onChange={handleFilterChange}
          />
        </div>
      </div>

      <div className="p-3">
        <div className="overflow-x-auto">
          <table className="table-auto w-full dark:text-gray-300">
            <thead className="text-xs uppercase text-gray-400 dark:text-gray-500 bg-gray-50 dark:bg-gray-700/50 rounded-xs">
              <tr>
                <th className="p-2">
                  <div
                    className="font-semibold text-left cursor-pointer flex items-center"
                    onClick={() => handleSort('name')}
                  >
                    Nome {getSortIndicator('name')}
                  </div>
                </th>
                <th className="p-2">
                  <div
                    className="font-semibold text-center cursor-pointer flex items-center justify-center"
                    onClick={() => handleSort('spent')}
                  >
                    Gastos {getSortIndicator('spent')}
                  </div>
                </th>
                <th className="p-2">
                  <div
                    className="font-semibold text-center cursor-pointer flex items-center justify-center"
                    onClick={() => handleSort('returns')}
                  >
                    Retornos {getSortIndicator('returns')}
                  </div>
                </th>
                <th className="p-2">
                  <div
                    className="font-semibold text-center cursor-pointer flex items-center justify-center"
                    onClick={() => handleSort('profit')}
                  >
                    Lucro líquido {getSortIndicator('profit')}
                  </div>
                </th>
                <th className="p-2">
                  <div
                    className="font-semibold text-center cursor-pointer flex items-center justify-center"
                    onClick={() => handleSort('reaches')}
                  >
                    QT. ALCANCES {getSortIndicator('reaches')}
                  </div>
                </th>
                <th className="p-2">
                  <div
                    className="font-semibold text-center cursor-pointer flex items-center justify-center"
                    onClick={() => handleSort('status')}
                  >
                    STATUS {getSortIndicator('status')}
                  </div>
                </th>
              </tr>
            </thead>
            <tbody className="text-sm font-medium divide-y divide-gray-100 dark:divide-gray-700/60">
              {filteredAndSortedCampaigns.map(c => (
                <tr key={c.id} className="cursor-pointer transition-colors duration-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                  <td className="p-2">
                    <Link to={`${c.id}`} className="flex items-center text-gray-800 dark:text-gray-100 hover:text-blue-500 dark:hover:text-blue-400">
                      {c.name}
                    </Link>
                  </td>
                  <td className="p-2">
                    <Link to={`${c.id}`} className="block text-center text-red-500 hover:text-red-600 dark:hover:text-red-400">
                      {formatToBRL(c?.trafficExpenses?.reduce((acc, curr) => acc + curr.amount, 0) || 0)}
                    </Link>
                  </td>
                  <td className="p-2">
                    <Link to={`${c.id}`} className="block text-center text-green-500 hover:text-green-600 dark:hover:text-green-400">
                      {formatToBRL(c?.trafficReturns?.reduce((acc, curr) => acc + curr.amount, 0) || 0)}
                    </Link>
                  </td>
                  <td className="p-2">
                    <Link to={`${c.id}`} className="block text-center hover:text-blue-500 dark:hover:text-blue-400">
                      {formatToBRL(c.profit || 0)}
                    </Link>
                  </td>
                  <td className="p-2">
                    <Link to={`${c.id}`} className="block text-center hover:text-blue-500 dark:hover:text-blue-400">
                      {c?.campaignMetrics?.reduce((acc, curr) => acc + curr.returningCustomers, 0) || 0}
                    </Link>
                  </td>
                  <td className="p-2">
                    <Link to={`${c.id}`} className="block text-center">
                      {statusMap[c.status] || 'Status Unknown'}
                    </Link>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>

          {filteredAndSortedCampaigns.length === 0 && (
            <div className="text-center py-4 text-gray-500 dark:text-gray-400">
              Nenhuma campanha encontrada com os filtros aplicados
            </div>
          )}
        </div>
      </div>
    </div>
  );
}

export default CampaignsTable;