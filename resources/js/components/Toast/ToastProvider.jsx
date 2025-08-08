import { createContext, useContext, useState } from 'react';
import Toast, { ToastPositions } from './Toast';

const ToastContext = createContext(undefined);

export const useToast = () => {
    const context = useContext(ToastContext);
    if (!context) {
        throw new Error('useToast must be used within a ToastProvider');
    }
    return context;
};

export const ToastProvider = ({ children }) => {
    const [toasts, setToasts] = useState([]);

    const addToast = ({ title, message, type, variant, icon, onClose, position = 'bottomRight' }) => {
        const id = Date.now();
        setToasts(prevToasts => [
            ...prevToasts,
            { id, title, message, type, variant, icon, onClose, position }
        ]);
    };

    const removeToast = (id) => {
        setToasts(prevToasts => prevToasts.filter(toast => toast.id !== id));
    };

    const positions = Object.keys(ToastPositions);

    return (
        <ToastContext.Provider value={{ addToast }}>
            {children}
            {positions.map((pos) => (
                <div key={pos} className={`fixed z-50 ${ToastPositions[pos]}`}>
                    {toasts
                        .filter((toast) => toast.position === pos)
                        .map((toast) => (
                            <Toast
                                key={toast.id}
                                title={toast.title}
                                message={toast.message}
                                type={toast.type}
                                variant={toast.variant}
                                icon={toast.icon}
                                position={toast.position}
                                onClose={() => removeToast(toast.id)}
                            />
                        ))}
                </div>
            ))}
        </ToastContext.Provider>
    );
};
