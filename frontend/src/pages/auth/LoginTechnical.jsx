import React from 'react';

const LoginTechnical = () => {
  return (
    <form className="space-y-4">
      <div>
        <label className="block text-sm font-medium text-gray-700 dark:text-white">Email</label>
        <input
          type="email"
          required
          className="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          placeholder="tecnico@exemplo.com"
        />
      </div>
      <div>
        <label className="block text-sm font-medium text-gray-700 dark:text-white">Senha</label>
        <input
          type="password"
          required
          className="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          placeholder="••••••••"
        />
      </div>
      <div>
        <label className="block text-sm font-medium text-gray-700 dark:text-white">Código do Técnico</label>
        <input
          type="text"
          required
          className="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          placeholder="ABC123"
        />
      </div>
      <button
        type="submit"
        className="cursor-pointer w-full flex justify-center bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-500 transition"
      >
        Entrar como Técnico
      </button>
    </form>
  );
};

export default LoginTechnical;


