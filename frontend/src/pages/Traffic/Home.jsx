import React, { useEffect, useState } from 'react'
import Sidebar from '../../partials/Sidebar';
import Header from '../../partials/Header';
import DashboardCard01 from '../../partials/dashboard/DashboardCard01';
import { getAllTrafficReturnsWithTotalAmount } from '../../services/company/trafficReturn';
import { getAllTrafficExpenses } from '../../services/company/trafficExpense';
import DashboardCard06 from '../../partials/dashboard/DashboardCard06';
import DashboardCard04 from '../../partials/dashboard/DashboardCard04';

const Home = () => {

  const [sidebarOpen, setSidebarOpen] = useState(false);
  const [trafficReturnData, setTrafficReturnData] = useState(null);
  const [trafficExpenseData, setTrafficExpenseData] = useState(null);
  const [profitData, setProfitData] = useState(null);

  const [trafficExpenseOriginalData, setTrafficExpenseOriginalData] = useState(null);


  const extractTrafficReturnData = (data) => {
    const totalAmount = data.totalAmount;
    const dates = data.trafficReturns.map(item => item.date);
    const amounts = data.trafficReturns.map(item => item.amount);

    return {
      totalAmount,
      dates,
      amounts
    };
  }

  const extractTrafficExpenseData = (data) => {
    const totalAmount = data.totalAmount;
    const dates = data.trafficExpenses.map(item => item.date);
    const amounts = data.trafficExpenses.map(item => item.amount);

    return {
      totalAmount,
      dates,
      amounts
    };
  }
  useEffect(() => {

    getAllTrafficReturnsWithTotalAmount().then(resp => {
      setTrafficReturnData(extractTrafficReturnData(resp.data.data));
    });

    getAllTrafficExpenses().then(resp => {
      setTrafficExpenseData(extractTrafficExpenseData(resp.data.data));
      setTrafficExpenseOriginalData(resp.data.data)
    });



  }, []);

  useEffect(() => {
    if (trafficReturnData && trafficExpenseData) {
      setProfitData({
        dates: [],
        amounts: [],
        totalAmount: trafficReturnData.totalAmount - trafficExpenseData.totalAmount
      })
    }
  }, [trafficReturnData, trafficExpenseData])

  const apiData = {
    trafficExpenses: [
      {
        id: 1,
        date: "01-12-2023",
        amount: 1500,
        trafficSource: { id: 1, name: "Google Ads", image: "google_ads.png" }
      },
      {
        id: 2,
        date: "05-12-2023",
        amount: 2300.5,
        trafficSource: { id: 2, name: "Facebook Ads", image: "facebook_ads.png" }
      },
      {
        id: 3,
        date: "01-11-2023",
        amount: 1800.75,
        trafficSource: { id: 1, name: "Google Ads", image: "google_ads.png" }
      }
    ],
    totalAmount: "5601.25"
  };
  
  return (
    <div className="flex h-screen overflow-hidden">

      {/* Sidebar */}
      <Sidebar sidebarOpen={sidebarOpen} setSidebarOpen={setSidebarOpen} />

      {/* Content area */}
      <div className="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

        {/*  Site header */}
        <Header sidebarOpen={sidebarOpen} setSidebarOpen={setSidebarOpen} />

        <main className="grow">
          <div className="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

            {/* Dashboard actions */}
            <div className="sm:flex sm:justify-between sm:items-center mb-8">

              {/* Left: Title */}
              <div className="mb-4 sm:mb-0">
                <h1 className="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Visão Geral</h1>
              </div>

              {/* Right: Actions */}
              <div className="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">

              </div>

            </div>

            {/* Cards */}
            <div className="grid grid-cols-12 gap-6">

              {/* Line chart (Acme Plus) */}
              <DashboardCard01 data={trafficReturnData} title='Retorno Total de Adesão' />

              <DashboardCard01 data={trafficExpenseData} title='Gasto Total' win={false} />
              <DashboardCard01 data={profitData} title='Lucro Líquido' />
              <DashboardCard06 data={trafficExpenseOriginalData} title='Gastos por Tráfego Pago'/>

              <DashboardCard04 data={trafficExpenseOriginalData} title='Gastos por Tráfego Pago'/>
            </div>

          </div>
        </main>
      </div>
    </div>
  )
}

export default Home