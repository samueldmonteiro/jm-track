// src/components/campaign/Modals/EditModal.js
import React from 'react';
import Modal from './Modal';
import { editCampaign } from '../../../../services/company/campaignService';

const EditModal = ({ isOpen, onClose, campaignName, onSave, onNameChange, campaign }) => {

  const editCampaignName = () => {
    editCampaign(campaign.id, {name: campaignName}).then(resp=>{
      window.location.reload(); 
    });
  }
  return (
    <Modal isOpen={isOpen} onClose={onClose}>
      <div className="p-6">
        <h3 className="text-xl font-semibold mb-4">Editar Campanha</h3>
        <div className="mb-4">
          <label className="block text-sm font-medium mb-1">Nome da Campanha</label>
          <input
            type="text"
            className="form-input w-full"
            value={campaignName}
            onChange={onNameChange}
          />
        </div>
        <div className="flex justify-end space-x-3">
          <button
            onClick={onClose}
            className="btn border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300"
          >
            Cancelar
          </button>
          <button
            onClick={editCampaignName}
            className="btn bg-indigo-500 hover:bg-indigo-600 text-white"
          >
            Salvar
          </button>
        </div>
      </div>
    </Modal>
  );
};

export default EditModal;