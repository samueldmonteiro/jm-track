import React, { useEffect, useState } from 'react'
import Sidebar from '../../../partials/Sidebar';
import Header from '../../../partials/Header';
import CampaignsTable from './CampaignsTable';
import MenuNewCampaign from '../../../components/Campaigns/MenuNewCampaign';
import { getAllCampaigns } from '../../../services/company/campaignService';
import { useGeneralProvider } from '../../../context/GeneralContext';

const Campaigns = () => {

  const [sidebarOpen, setSidebarOpen] = useState(false);
  const [menuNewCampaignOpen, setMenuNewCampaignOpen] = useState(false);
  const [campaigns, setCampaigns] = useState([]);
  const { newCampaignCreated } = useGeneralProvider();

  useEffect(() => {
    getAllCampaigns().then(resp => {
      setCampaigns(resp.data.data.campaigns);
    })
  }, []);

  useEffect(() => {
    if (newCampaignCreated) {
      getAllCampaigns().then(resp => {
        setCampaigns(resp.data.data.campaigns);
      })
    }
  }, [newCampaignCreated]);

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
                <h1 className="text-2xl md:text-3xl text-gray-800 dark:text-gray-100 font-bold">Campanhas</h1>
              </div>


              <div className="cursor-pointer not-first-of-type:grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                <button className="cursor-pointer btn bg-gray-900 text-gray-100 hover:bg-gray-800 dark:bg-gray-100 dark:text-gray-800 dark:hover:bg-white">
                  <svg className="fill-current shrink-0 xs:hidden" width="16" height="16" viewBox="0 0 16 16">
                    <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z" />
                  </svg>
                  <span className="max-xs:sr-only" onClick={() => setMenuNewCampaignOpen(true)}>Nova Campanha</span>
                </button>
              </div>
            </div>

            {/* Cards */}
            <div className="grid grid-cols-6">

              <CampaignsTable campaigns={campaigns} />
              <MenuNewCampaign open={menuNewCampaignOpen} setOpen={setMenuNewCampaignOpen} />
            </div>

          </div>
        </main>
      </div>
    </div>
  )
}

export default Campaigns