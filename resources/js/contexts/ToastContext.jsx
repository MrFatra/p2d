import { createContext, useContext, useState, useCallback } from "react";

const ToastContext = createContext();

export const ToastProvider = ({ children }) => {
    const [toasts, setToasts] = useState([]);

    const addToast = useCallback((message, type = "info") => {
        const id = Date.now();
        setToasts((prev) => [...prev, { id, message, type }]);

        // Hapus otomatis setelah beberapa detik
        setTimeout(() => {
            setToasts((prev) => prev.filter((toast) => toast.id !== id));
        }, 3000);
    }, []);

    return (
        <ToastContext.Provider value={{ addToast }}>
            {children}
            {/* Render toasts */}
            <div className="fixed top-5 right-5 space-y-2 z-50">
                {toasts.map(({ id, message, type }) => (
                    <div
                        key={id}
                        className={`px-4 py-2 rounded shadow text-white ${type === "error"
                                ? "bg-red-500"
                                : type === "success"
                                    ? "bg-green-500"
                                    : "bg-gray-700"
                            }`}
                    >
                        {message}
                    </div>
                ))}
            </div>
        </ToastContext.Provider>
    );
};

export const useToast = () => {
    const context = useContext(ToastContext);
    if (!context) {
        throw new Error("useToast must be used within a ToastProvider");
    }
    return context.addToast;
};
