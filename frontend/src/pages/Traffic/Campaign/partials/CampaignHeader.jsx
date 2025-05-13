// src/components/campaign/CampaignHeader.js
import React from 'react';
import { FiChevronLeft, FiEdit, FiPlus, FiTrash2 } from 'react-icons/fi';
import { useNavigate } from 'react-router-dom';

const CampaignHeader = ({ 
  campaign, 
  campaignName, 
  onEditClick, 
  onDeleteClick, 
  onAddTrafficClick 
}) => {
  const navigate = useNavigate();

  return (
    <div className="sm:flex sm:justify-between sm:items-center mb-8">
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
              onClick={onEditClick}
              className="ml-2 text-blue-500 hover:text-blue-700"
            >
              <FiEdit className="inline" />
            </button>
          </h1>
          <p className="text-sm text-gray-500 dark:text-gray-400">
            {new Date(campaign?.startDate).toLocaleDateString()} - {campaign?.endDate ? new Date(campaign.endDate).toLocaleDateString() : 'Presente'}
          </p>
        </div>
      </div>

      <div className="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
        <button
          onClick={onAddTrafficClick}
          className="btn bg-indigo-500 hover:bg-indigo-600 text-white"
        >
          <FiPlus className="mr-2" /> Adicionar Tráfego
        </button>
        <button
          onClick={onDeleteClick}
          className="btn bg-red-500 hover:bg-red-600 text-white"
        >
          <FiTrash2 className="mr-2" /> Excluir Campanha
        </button>
      </div>
    </div>
  );
};

export default CampaignHeader;