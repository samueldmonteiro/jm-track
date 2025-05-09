import React, { useEffect, useState } from 'react';
import { useForm } from 'react-hook-form';
import { zodResolver } from '@hookform/resolvers/zod';
import { z } from 'zod';
import useFetchData from '../../hooks/useFetchData';
import { loginCompany } from '../../auth/authService';
import BackDrop from '../../components/Loads/BackDrop';
import GeneralAlert from '../../components/Alerts/GeneralAlert';
import { useAuth } from '../../auth/useAuth';
import { Howl } from 'howler';
import okSound from '../../assets/songs/ok.wav';
import errorSound from '../../assets/songs/error.wav'
import { useNavigate } from 'react-router-dom';

const validation = z.object({
  document: z.string()
    .min(11, 'Documento deve ter no mínimo 11 caracteres (CPF)')
    .max(18, 'Documento deve ter no máximo 18 caracteres (CNPJ)')
    .refine((val) => {
      const cleanVal = val.replace(/\D/g, '');
      return cleanVal.length === 11 || cleanVal.length === 14;
    }, 'Documento inválido (deve ser CPF ou CNPJ)'),
  password: z.string()
    .min(3, 'Senha deve ter no mínimo 6 caracteres')
    .max(20, 'Senha deve ter no máximo 20 caracteres')
});


const LoginCompany = () => {
  const {
    register,
    handleSubmit,
    formState: { errors, isSubmitting },
  } = useForm({
    resolver: zodResolver(validation)
  });

  const { request, data, error, loading } = useFetchData();
  const { login } = useAuth();
  const navigate = useNavigate();

  const onSubmit = async (data) => {

    request(loginCompany, [data.document, data.password]);
    // Simulando envio para o backend
    console.log('Dados enviados:', data);
  };

  useEffect(() => {
    if (data) {

      const test = async () => {
        new Howl({ src: [okSound], volume: 0.5 }).play();
        await login(data.data);
        setTimeout(() => {
          navigate('/painel/empresa');
        }, 400);
      }

      test();

    }

    if (error) {
      new Howl({ src: [errorSound], volume: 0.5 }).play();
    }
  }, [data, error]);

  return (
    <form className="space-y-4" onSubmit={handleSubmit(onSubmit)}>
      <BackDrop isOpen={loading} />
      {(error || data) ? <GeneralAlert message={error ?? 'Login Efetuado com Sucesso!'} type={error ? 'error' : 'success'} /> : null}
      <div>
        <label className="block text-sm font-medium text-gray-700 dark:text-white">Documento</label>
        <input required
          type="text"
          className={`mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm ${errors.document ? 'border-red-500 dark:border-red-500' : ''
            }`}
          placeholder="CPF ou CNPJ"
          {...register('document')}
        />
        {errors.document && (
          <p className="mt-1 text-sm text-red-600 dark:text-red-400">
            {errors.document.message}
          </p>
        )}
      </div>
      <div>
        <label className="block text-sm font-medium text-gray-700 dark:text-white">Senha</label>
        <input required
          type="password"
          className={`mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm ${errors.password ? 'border-red-500 dark:border-red-500' : ''
            }`}
          placeholder="••••••••"
          {...register('password')}
        />
        {errors.password && (
          <p className="mt-1 text-sm text-red-600 dark:text-red-400">
            {errors.password.message}
          </p>
        )}
      </div>
      <button
        type="submit"
        disabled={isSubmitting}
        className={`cursor-pointer w-full flex justify-center bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-500 transition ${isSubmitting ? 'opacity-70 cursor-not-allowed' : ''
          }`}
      >
        {isSubmitting ? 'Enviando...' : 'Entrar como Companhia'}
      </button>
    </form>
  );
};

export default LoginCompany;