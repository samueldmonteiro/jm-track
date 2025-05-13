import React, { useState, useEffect } from 'react';
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  BarElement,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend,
  ArcElement
} from 'chart.js';
import { Bar, Line, Pie, Doughnut } from 'react-chartjs-2';
import { getAllCampaigns } from '../../services/company/campaignService';
import { useThemeProvider } from '../../context/ThemeContext';
import Sidebar from '../../partials/Sidebar';
import Header from '../../partials/Header';

ChartJS.register(
  CategoryScale,
  LinearScale,
  BarElement,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend,
  ArcElement
);

const Home = () => {
  const [sidebarOpen, setSidebarOpen] = useState(false);
  const [timeRange, setTimeRange] = useState('daily');
  const [processedData, setProcessedData] = useState(null);

  const { currentTheme: theme } = useThemeProvider();

  useEffect(() => {
    getAllCampaigns().then(resp => {
      if (resp.data.data.campaigns) {
        processData(resp.data.data.campaigns);
      }
    })

  }, []);

  const processData = (campaigns) => {
    // Calcular totais
    let totalReturns = 0;
    let totalExpenses = 0;
    const campaignsData = {};
    const dailyData = {};
    const weeklyData = {};
    const monthlyData = {};
    const yearlyData = {};

    campaigns.forEach(campaign => {
      campaign.trafficTransactions.forEach(transaction => {
        const date = new Date(transaction.date);
        const day = date.toISOString().split('T')[0];
        const week = `${date.getFullYear()}-W${Math.floor(date.getDate() / 7) + 1}`;
        const month = `${date.getFullYear()}-${date.getMonth() + 1}`;
        const year = date.getFullYear();

        // Inicializar estruturas de dados se não existirem
        if (!dailyData[day]) dailyData[day] = { returns: 0, expenses: 0 };
        if (!weeklyData[week]) weeklyData[week] = { returns: 0, expenses: 0 };
        if (!monthlyData[month]) monthlyData[month] = { returns: 0, expenses: 0 };
        if (!yearlyData[year]) yearlyData[year] = { returns: 0, expenses: 0 };
        if (!campaignsData[campaign.name]) campaignsData[campaign.name] = { returns: 0, expenses: 0 };

        const amount = parseFloat(transaction.amount);

        if (transaction.type === 'return') {
          totalReturns += amount;
          campaignsData[campaign.name].returns += amount;
          dailyData[day].returns += amount;
          weeklyData[week].returns += amount;
          monthlyData[month].returns += amount;
          yearlyData[year].returns += amount;
        } else if (transaction.type === 'expense') {
          totalExpenses += amount;
          campaignsData[campaign.name].expenses += amount;
          dailyData[day].expenses += amount;
          weeklyData[week].expenses += amount;
          monthlyData[month].expenses += amount;
          yearlyData[year].expenses += amount;
        }
      });
    });

    const netProfit = totalReturns - totalExpenses;
    const roi = totalExpenses > 0 ? ((netProfit / totalExpenses) * 100).toFixed(2) : 0;

    // Ordenar campanhas por lucro
    const sortedCampaigns = Object.entries(campaignsData)
      .map(([name, data]) => ({
        name,
        returns: data.returns,
        expenses: data.expenses,
        profit: data.returns - data.expenses
      }))
      .sort((a, b) => b.profit - a.profit);

    setProcessedData({
      totals: {
        returns: totalReturns,
        expenses: totalExpenses,
        netProfit,
        roi
      },
      topCampaigns: sortedCampaigns,
      timeData: {
        daily: dailyData,
        weekly: weeklyData,
        monthly: monthlyData,
        yearly: yearlyData
      }
    });
  };

  const getTimeChartData = () => {
    if (!processedData) return null;

    const timeData = processedData.timeData[timeRange];
    const labels = Object.keys(timeData).sort();
    const returnsData = labels.map(label => timeData[label].returns);
    const expensesData = labels.map(label => timeData[label].expenses);

    return {
      labels,
      datasets: [
        {
          label: 'Retornos',
          data: returnsData,
          backgroundColor: theme === 'dark' ? 'rgba(74, 222, 128, 0.7)' : 'rgba(74, 222, 128, 0.5)',
          borderColor: theme === 'dark' ? 'rgba(74, 222, 128, 1)' : 'rgba(74, 222, 128, 1)',
          borderWidth: 1
        },
        {
          label: 'Gastos',
          data: expensesData,
          backgroundColor: theme === 'dark' ? 'rgba(248, 113, 113, 0.7)' : 'rgba(248, 113, 113, 0.5)',
          borderColor: theme === 'dark' ? 'rgba(248, 113, 113, 1)' : 'rgba(248, 113, 113, 1)',
          borderWidth: 1
        }
      ]
    };
  };

  const getTopCampaignsChartData = () => {
    if (!processedData) return null;

    const top5 = processedData.topCampaigns.slice(0, 5);
    const labels = top5.map(campaign => campaign.name);
    const profits = top5.map(campaign => campaign.profit);

    return {
      labels,
      datasets: [
        {
          label: 'Lucro por Campanha',
          data: profits,
          backgroundColor: [
            theme === 'dark' ? 'rgba(167, 139, 250, 0.7)' : 'rgba(167, 139, 250, 0.5)',
            theme === 'dark' ? 'rgba(139, 92, 246, 0.7)' : 'rgba(139, 92, 246, 0.5)',
            theme === 'dark' ? 'rgba(109, 40, 217, 0.7)' : 'rgba(109, 40, 217, 0.5)',
            theme === 'dark' ? 'rgba(76, 29, 149, 0.7)' : 'rgba(76, 29, 149, 0.5)',
            theme === 'dark' ? 'rgba(46, 16, 101, 0.7)' : 'rgba(46, 16, 101, 0.5)'
          ],
          borderColor: theme === 'dark' ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)',
          borderWidth: 1
        }
      ]
    };
  };

  const getROIData = () => {
    if (!processedData) return null;

    return {
      labels: ['ROI'],
      datasets: [
        {
          data: [processedData.totals.roi, 100 - processedData.totals.roi],
          backgroundColor: [
            theme === 'dark' ? 'rgba(34, 211, 238, 0.7)' : 'rgba(34, 211, 238, 0.5)',
            theme === 'dark' ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.05)'
          ],
          borderColor: theme === 'dark' ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)',
          borderWidth: 1
        }
      ]
    };
  };

  if (!processedData) {
    return (
      <div className={`flex items-center justify-center h-screen ${theme === 'dark' ? 'bg-gray-900' : 'bg-gray-50'}`}>
        <div className="animate-spin rounded-full h-32 w-32 border-t-2 border-b-2 border-blue-500"></div>
      </div>
    );
  }

  return (
    <div className="flex h-screen overflow-hidden">

      {/* Sidebar */}
      <Sidebar sidebarOpen={sidebarOpen} setSidebarOpen={setSidebarOpen} />

      {/* Content area */}
      <div className="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

        {/*  Site header */}
        <Header sidebarOpen={sidebarOpen} setSidebarOpen={setSidebarOpen} />

        <main className="grow">
          <div className={`min-h-screen p-6 ${theme === 'dark' ? 'bg-gray-900 text-white' : 'bg-gray-50 text-gray-900'}`}>
            <h1 className="text-3xl font-bold mb-8">Dashboard de Tráfego Pago</h1>

            {/* Cards de Métricas */}
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
              <MetricCard
                title="Retorno Total"
                value={`R$ ${processedData.totals.returns.toFixed(2)}`}
                icon="💰"
                theme={theme}
              />
              <MetricCard
                title="Gastos Totais"
                value={`R$ ${processedData.totals.expenses.toFixed(2)}`}
                icon="💸"
                theme={theme}
              />
              <MetricCard
                title="Lucro Líquido"
                value={`R$ ${processedData.totals.netProfit.toFixed(2)}`}
                icon="📈"
                theme={theme}
                isProfit={processedData.totals.netProfit >= 0}
              />
              <MetricCard
                title="ROI Total"
                value={`${processedData.totals.roi}%`}
                icon="🎯"
                theme={theme}
              />
            </div>

            {/* Gráfico de Campanhas com Mais Lucro */}
            <div className={`p-6 rounded-lg shadow-lg mb-8 ${theme === 'dark' ? 'bg-gray-800' : 'bg-white'}`}>
              <h2 className="text-xl font-semibold mb-4">Top Campanhas por Lucro</h2>
              <div className="h-80">
                {processedData.topCampaigns.length > 0 ? (
                  <Bar
                    data={getTopCampaignsChartData()}
                    options={{
                      responsive: true,
                      maintainAspectRatio: false,
                      plugins: {
                        legend: {
                          position: 'top',
                          labels: {
                            color: theme === 'dark' ? 'white' : 'black'
                          }
                        }
                      },
                      scales: {
                        y: {
                          beginAtZero: true,
                          ticks: {
                            color: theme === 'dark' ? 'white' : 'black'
                          },
                          grid: {
                            color: theme === 'dark' ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                          }
                        },
                        x: {
                          ticks: {
                            color: theme === 'dark' ? 'white' : 'black'
                          },
                          grid: {
                            color: theme === 'dark' ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                          }
                        }
                      }
                    }}
                  />
                ) : (
                  <p className="text-center py-10">Nenhuma campanha com dados suficientes</p>
                )}
              </div>
            </div>

            {/* Gráficos de Desempenho Temporal */}
            <div className={`p-6 rounded-lg shadow-lg mb-8 ${theme === 'dark' ? 'bg-gray-800' : 'bg-white'}`}>
              <div className="flex justify-between items-center mb-4">
                <h2 className="text-xl font-semibold">Desempenho por Período</h2>
                <div className="flex space-x-2">
                  <button
                    onClick={() => setTimeRange('daily')}
                    className={`px-3 py-1 rounded ${timeRange === 'daily' ? (theme === 'dark' ? 'bg-blue-600' : 'bg-blue-500 text-white') : (theme === 'dark' ? 'bg-gray-700' : 'bg-gray-200')}`}
                  >
                    Diário
                  </button>
                  <button
                    onClick={() => setTimeRange('weekly')}
                    className={`px-3 py-1 rounded ${timeRange === 'weekly' ? (theme === 'dark' ? 'bg-blue-600' : 'bg-blue-500 text-white') : (theme === 'dark' ? 'bg-gray-700' : 'bg-gray-200')}`}
                  >
                    Semanal
                  </button>
                  <button
                    onClick={() => setTimeRange('monthly')}
                    className={`px-3 py-1 rounded ${timeRange === 'monthly' ? (theme === 'dark' ? 'bg-blue-600' : 'bg-blue-500 text-white') : (theme === 'dark' ? 'bg-gray-700' : 'bg-gray-200')}`}
                  >
                    Mensal
                  </button>
                  <button
                    onClick={() => setTimeRange('yearly')}
                    className={`px-3 py-1 rounded ${timeRange === 'yearly' ? (theme === 'dark' ? 'bg-blue-600' : 'bg-blue-500 text-white') : (theme === 'dark' ? 'bg-gray-700' : 'bg-gray-200')}`}
                  >
                    Anual
                  </button>
                </div>
              </div>
              <div className="h-80">
                <Line
                  data={getTimeChartData()}
                  options={{
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                      legend: {
                        position: 'top',
                        labels: {
                          color: theme === 'dark' ? 'white' : 'black'
                        }
                      }
                    },
                    scales: {
                      y: {
                        beginAtZero: true,
                        ticks: {
                          color: theme === 'dark' ? 'white' : 'black'
                        },
                        grid: {
                          color: theme === 'dark' ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                        }
                      },
                      x: {
                        ticks: {
                          color: theme === 'dark' ? 'white' : 'black'
                        },
                        grid: {
                          color: theme === 'dark' ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                        }
                      }
                    }
                  }}
                />
              </div>
            </div>

            {/* ROI */}
            <div className={`p-6 rounded-lg shadow-lg ${theme === 'dark' ? 'bg-gray-800' : 'bg-white'}`}>
              <h2 className="text-xl font-semibold mb-4">Retorno sobre Investimento (ROI)</h2>
              <div className="h-64 flex justify-center">
                <Doughnut
                  data={getROIData()}
                  options={{
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                      legend: {
                        position: 'right',
                        labels: {
                          color: theme === 'dark' ? 'white' : 'black'
                        }
                      },
                      tooltip: {
                        callbacks: {
                          label: function (context) {
                            return `${context.label}: ${context.raw}%`;
                          }
                        }
                      }
                    },
                    cutout: '70%'
                  }}
                />
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>

  );
};

const MetricCard = ({ title, value, icon, theme, isProfit }) => {
  let colorClass = '';
  if (isProfit !== undefined) {
    colorClass = isProfit ? (theme === 'dark' ? 'text-green-400' : 'text-green-600') : (theme === 'dark' ? 'text-red-400' : 'text-red-600');
  }

  return (
    <div className={`p-6 rounded-lg shadow ${theme === 'dark' ? 'bg-gray-800' : 'bg-white'}`}>
      <div className="flex justify-between items-center">
        <div>
          <p className={`text-sm font-medium ${theme === 'dark' ? 'text-gray-300' : 'text-gray-500'}`}>{title}</p>
          <p className={`text-2xl font-bold mt-2 ${colorClass || (theme === 'dark' ? 'text-white' : 'text-gray-900')}`}>{value}</p>
        </div>
        <span className="text-3xl">{icon}</span>
      </div>
    </div>
  );
};

export default Home;