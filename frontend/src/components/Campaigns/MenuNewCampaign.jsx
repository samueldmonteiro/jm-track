import React, { useEffect, useState } from 'react';
import Drawer from '@mui/material/Drawer';
import { useForm } from 'react-hook-form';
import { zodResolver } from '@hookform/resolvers/zod';
import { z } from 'zod';
import useFetchData from '../../hooks/useFetchData';
import { findById, newCampaign } from '../../services/company/campaignService';
import GeneralAlert from '../Alerts/GeneralAlert';
import BackDrop from '../Loads/BackDrop';
import { useGeneralProvider } from '../../context/GeneralContext';

const schema = z.object({
  name: z.string().min(1, 'O nome é obrigatório'),
  /**status: z.enum(['open', 'paused', 'closed'], {
    errorMap: () => ({ message: 'Selecione um estado válido' }),
  }),**/
});

export default function MenuNewCampaign({ open, setOpen }) {

  const {
    register,
    handleSubmit,
    formState: { errors },
  } = useForm({
    resolver: zodResolver(schema),
  });

  const { request, error, data, loading } = useFetchData();
  const {toggleNewCampaignCreated, newCampaignCreated} = useGeneralProvider();


  const onSubmit = (data) => {
    console.log('Dados enviados:', data);
    request(newCampaign, [data.name]);
  };

  useEffect(() => {
    if (data) {
      findById(data.data.campaign.id).then(resp => {
        toggleNewCampaignCreated(true);
      })
    }
  }, [data]);

  return (
    <div>
      <Drawer anchor="right" open={open} onClose={() => setOpen(false)}>
        <div className="w-[400px] h-full p-6 bg-white dark:bg-gray-900 text-gray-800 dark:text-white">
          <h2 className="text-2xl font-semibold mb-4">Criar Campanha</h2>

          <form onSubmit={handleSubmit(onSubmit)} className="space-y-4">
            {/* Campo Nome */}
            <BackDrop isOpen={loading} />
            {(error || data) &&  newCampaignCreated ? <GeneralAlert message={error ?? 'Nova Campanha Criada'} type={error ? 'error' : 'success'} /> : null}
            <div>
              <label className="block mb-1 font-medium">Nome da Campanha</label>
              <input
                {...register('name')}
                type="text"
                className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600"
              />
              {errors.name && (
                <p className="text-red-500 text-sm mt-1">{errors.name.message}</p>
              )}
            </div>

            {/* Campo Estado */}
            {null && <div>
              <label className="block mb-1 font-medium">Estado da Campanha</label>
              <select
                {...register('status')}
                className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600"
              >
                <option value="open">Aberta</option>
                <option value="paused">Pausada</option>
                <option value="closed">Fechada</option>
              </select>
              {errors.status && (
                <p className="text-red-500 text-sm mt-1">{errors.status.message}</p>
              )}
            </div>}

            {/* Botões */}
            <div className="flex justify-end gap-2 mt-4">
              <button
                type="button"
                onClick={() => setOpen(false)}
                className="cursor-pointer px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-white rounded hover:bg-gray-300"
              >
                Cancelar
              </button>
              <button
                type="submit"
                className="cursor-pointer px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
              >
                Salvar
              </button>
            </div>
          </form>
        </div>
      </Drawer>
    </div>
  );
}
