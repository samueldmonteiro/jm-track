import React, { useState, useEffect } from 'react';
import BarChart from '../../charts/BarChart01';
import dayjs from 'dayjs';
import 'dayjs/locale/pt-br'; // Import Portuguese locale if needed

import isoweek from 'dayjs/plugin/isoWeek';
import localeData from 'dayjs/plugin/localeData';

dayjs.extend(isoweek);
dayjs.extend(localeData);

function DashboardCard04({ data }) {
  const [period, setPeriod] = useState('mensal');
  const [chartData, setChartData] = useState({
    labels: [],
    datasets: [],
  });

  useEffect(() => {
    if (!data || !data.trafficExpenses) return;

    const groupedData = groupDataByPeriod(data.trafficExpenses, period);
    const labels = groupedData.map((item) => item.label);
    const values = groupedData.map((item) => item.value);

    setChartData({
      labels,
      datasets: [
        {
          label: 'Despesas de Tráfego',
          data: values,
          backgroundColor: '#3b82f6',
          borderColor: '#3b82f6',
          borderWidth: 1,
          borderRadius: 4,
        },
      ],
    });
  }, [data, period]);

  const groupDataByPeriod = (expenses, period) => {
    const map = new Map();

    expenses.forEach((item) => {
      const date = dayjs(item.date, 'DD-MM-YYYY');
      let key, label;

      switch (period) {
        case 'diario':
          key = date.format('YYYY-MM-DD');
          label = date.locale('pt-br').format('DD MMM');
          break;
        case 'semanal':
          key = `${date.year()}-W${date.isoWeek()}`;
          const weekStart = date.startOf('week');
          const weekEnd = date.endOf('week');
          label = `${weekStart.format('DD MMM')}-${weekEnd.format('DD MMM')}`;
          break;
        case 'mensal':
          key = date.format('YYYY-MM');
          label = date.locale('pt-br').format('MMM YYYY');
          break;
        case 'anual':
          key = date.format('YYYY');
          label = date.format('YYYY');
          break;
        default:
          key = date.format('YYYY-MM');
          label = date.locale('pt-br').format('MMM YYYY');
      }

      if (!map.has(key)) {
        map.set(key, { date, label, value: 0 });
      }

      const current = map.get(key);
      current.value += item.amount;
    });

    return Array.from(map.values()).sort((a, b) => a.date - b.date);
  };

  return (
    <div className="flex flex-col col-span-full sm:col-span-6 xl:col-span-6 bg-white dark:bg-gray-800  shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
      <header className="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
        <div className="flex justify-between items-center">
          <h2 className="font-semibold text-slate-800 dark:text-slate-100">Despesas de Tráfego</h2>
          <select
            value={period}
            onChange={(e) => setPeriod(e.target.value)}
            className="form-select bg-white dark:bg-gray-800  border dark:border-slate-600 text-sm"
          >
            <option value="diario">Diário</option>
            <option value="semanal">Semanal</option>
            <option value="mensal">Mensal</option>
            <option value="anual">Anual</option>
          </select>
        </div>
      </header>
      <div className="px-5 py-3">
        <BarChart data={chartData} width={595} height={248} period={period} />
      </div>
    </div>
  );
}

export default DashboardCard04;