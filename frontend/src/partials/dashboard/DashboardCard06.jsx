import React, { useMemo } from 'react';
import DoughnutChart from '../../charts/DoughnutChart';
import { getCssVariable } from '../../utils/Utils';

function DashboardCard06({ data, title }) {
  const chartData = useMemo(() => {
    if (!data || !data.trafficExpenses) return null;

    const expenseMap = {};

    data.trafficExpenses.forEach((item) => {
      const sourceName = item.trafficSource.name;
      if (!expenseMap[sourceName]) {
        expenseMap[sourceName] = 0;
      }
      expenseMap[sourceName] += item.amount;
    });

    const labels = Object.keys(expenseMap);
    const values = Object.values(expenseMap);

    const baseColors = [
      '--color-violet-500',
      '--color-sky-500',
      '--color-emerald-500',
      '--color-rose-500',
      '--color-yellow-500',
    ];

    const backgroundColor = labels.map((_, i) =>
      getCssVariable(baseColors[i % baseColors.length])
    );
    const hoverBackgroundColor = labels.map((_, i) =>
      getCssVariable(baseColors[i % baseColors.length].replace('500', '600'))
    );

    return {
      labels,
      datasets: [
        {
          label: title,
          data: values,
          backgroundColor,
          hoverBackgroundColor,
          borderWidth: 0,
        },
      ],
    };
  }, [data]);

  return (
    <div className="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white dark:bg-gray-800 shadow-xs rounded-xl">
      <header className="px-5 py-4 border-b border-gray-100 dark:border-gray-700/60">
        <h2 className="font-semibold text-gray-800 dark:text-gray-100">Gastos por Tráfego Pago</h2>
      </header>
      {chartData ? (
        <DoughnutChart data={chartData} width={389} height={260} />
      ) : (
        <div className="p-4 text-gray-500 dark:text-gray-400">Carregando dados...</div>
      )}
    </div>
  );
}

export default DashboardCard06;
