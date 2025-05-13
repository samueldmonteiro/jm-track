// src/components/campaign/Modals/DeleteModal.js
import React, { useState } from 'react';
import Modal from './Modal';
import { deleteCampaign } from '../../../../services/company/campaignService';

const DeleteModal = ({ isOpen, onClose, onConfirm, campaign }) => {

  const [deleted, setDeleted] = useState(false);
  const deleteCampaignAction = () => {
    setDeleted(true)
    deleteCampaign(campaign.id).then(resp => {
      window.location.href = '/painel/empresa/trafego/campanhas/';
    });
  }
  return (
    <Modal isOpen={isOpen} onClose={onClose}>
      <div className="p-6">
        <h3 className="text-xl font-semibold mb-4">Excluir Campanha</h3>
        <p className="mb-6">Tem certeza que deseja excluir esta campanha? Esta ação não pode ser desfeita.</p>
        <div className="flex justify-end space-x-3">
          <button

            onClick={onClose}
            className="cursor-pointer btn border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300"
          >
            Cancelar
          </button>
          <button
            disabled={deleted}
            onClick={deleteCampaignAction}
            className="cursor-pointer btn bg-red-500 hover:bg-red-600 text-white"
          >
            Excluir
          </button>
        </div>
      </div>
    </Modal>
  );
};

export default DeleteModal;