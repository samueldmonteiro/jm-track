import React, { useMemo } from 'react';
import LineChart from '../../charts/LineChart01';
import { chartAreaGradient } from '../../charts/ChartjsConfig';
import CircularProgress from '@mui/material/CircularProgress';
import Box from '@mui/material/Box';
// Import utilities
import { adjustColorOpacity, getCssVariable } from '../../utils/Utils';
import formatToBRL from '../../utils/formatToBRL';

function DashboardCard01({ data = null, title = 'generic', win = true }) {

  console.log("data", data)
  const chartData = useMemo(() => {
    if (!data) return null;

    return {
      labels: data?.dates ?? [],
      datasets: [
        {
          data: data?.amounts ?? [],
          fill: true,
          backgroundColor: function (context) {
            const chart = context.chart;
            const { ctx, chartArea } = chart;
            if (!chartArea) return null;
            return chartAreaGradient(ctx, chartArea, [
              { stop: 0, color: adjustColorOpacity(getCssVariable('--color-violet-500'), 0) },
              { stop: 1, color: adjustColorOpacity(getCssVariable('--color-violet-500'), 0.2) }
            ]);
          },
          borderColor: getCssVariable('--color-violet-500'),
          borderWidth: 2,
          pointRadius: 0,
          pointHoverRadius: 3,
          pointBackgroundColor: getCssVariable('--color-violet-500'),
          pointHoverBackgroundColor: getCssVariable('--color-violet-500'),
          pointBorderWidth: 0,
          pointHoverBorderWidth: 0,
          clip: 20,
          tension: 0.2,
        }
      ]
    };
  }, [data]);



  return (
    <div className="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white dark:bg-gray-800 shadow-xs rounded-xl">
      <div className="px-5 pt-5">
        <header className="flex justify-between items-start mb-2">
          <h2 className="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">{title}</h2>
          {/* Menu button */}

        </header>
        <div className="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase mb-1">Valor</div>
        <div className="flex items-start">
          <div className="text-3xl font-bold text-gray-800 dark:text-gray-100 mr-2">{data ? formatToBRL(data.totalAmount) : (<Box sx={{ display: 'flex' }}>
            <div className="pb-3 pt-3">
            <CircularProgress />
            </div>
          </Box>)}</div>
          {win && data?.totalAmount >= 0 ? <div className="text-sm font-medium text-green-700 px-1.5 bg-green-500/20 rounded-full">R$</div> : <div className="text-sm font-medium text-red-700 px-1.5 bg-red-500/20 rounded-full">R$</div>}
        </div>
      </div>
      {/* Chart built with Chart.js 3 */}
      <div className="grow max-sm:max-h-[128px] xl:max-h-[128px]">
        {/* Change the height attribute to adjust the chart height */}
        {chartData ? (
          <LineChart data={chartData} width={389} height={128} />
        ) : null
        }
      </div>
    </div>
  );
}

export default DashboardCard01;
