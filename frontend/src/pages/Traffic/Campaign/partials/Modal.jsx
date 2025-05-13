// src/components/campaign/Modals/Modal.js
import React, { useEffect } from 'react';
import { FiX } from 'react-icons/fi';

const Modal = ({
  isOpen,
  onClose,
  children,
  width = 'max-w-md',
  closeOnOverlayClick = true
}) => {
  useEffect(() => {
    if (isOpen) {
      document.body.style.overflow = 'hidden';
    } else {
      document.body.style.overflow = 'auto';
    }

    return () => {
      document.body.style.overflow = 'auto';
    };
  }, [isOpen]);

  useEffect(() => {
    const handleKeyDown = (e) => {
      if (e.key === 'Escape') {
        onClose();
      }
    };

    if (isOpen) {
      document.addEventListener('keydown', handleKeyDown);
    }

    return () => {
      document.removeEventListener('keydown', handleKeyDown);
    };
  }, [isOpen, onClose]);

  if (!isOpen) return null;

  return (
    <div className="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center">
      <div
        className="absolute inset-0 bg-black bg-opacity-50"
        onClick={closeOnOverlayClick ? onClose : null}
      />

      <div 
        className={`relative z-10 bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full ${width}`}
        role="dialog"
        aria-modal="true"
        aria-labelledby="modal-headline"
      >
        <button
          onClick={onClose}
          className="absolute top-4 right-4 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none"
          aria-label="Fechar modal"
        >
          <FiX className="h-6 w-6" />
        </button>

        {children}
      </div>
    </div>
  );
};

export default Modal;