import { cn } from 'clsx-for-tailwind';
import { useEffect, useState } from 'react';

export const ToastVariants = {
  outline: 'border border-current',
  solid: ''
};

export const ToastPositions = {
  topLeft: 'top-5 left-5',
  bottomLeft: 'bottom-5 left-5',
  topRight: 'top-5 right-5',
  bottomRight: 'bottom-5 right-5'
};

export const ToastTypes = {
  success: 'bg-success-30 border-success-700 text-success-700',
  info: 'bg-info-30 border-info-700 text-info-700',
  warning: 'bg-warning-30 border-warning-700 text-warning-700',
  error: 'bg-error-30 border-error-700 text-error-700',
};

const enterAnimationByPosition = {
  topRight: 'translate-x-0',
  bottomRight: 'translate-x-0',
  topLeft: '-translate-x-0',
  bottomLeft: '-translate-x-0',
};

const exitAnimationByPosition = {
  topRight: 'translate-x-40',
  bottomRight: 'translate-x-40',
  topLeft: '-translate-x-40',
  bottomLeft: '-translate-x-40',
};

const initialAnimationByPosition = {
  topRight: 'translate-x-10',
  bottomRight: 'translate-x-10',
  topLeft: '-translate-x-10',
  bottomLeft: '-translate-x-10',
};

const Toast = ({
  title,
  message,
  type,
  icon,
  position = 'bottomRight',
  variant = 'solid',
  onClose
}) => {
  const [isVisible, setIsVisible] = useState(false);
  const [isFadingOut, setIsFadingOut] = useState(false);

  useEffect(() => {
    setTimeout(() => setIsVisible(true), 50);

    const timer = setTimeout(() => {
      handleClose();
    }, 5000);

    return () => clearTimeout(timer);
  }, []);

  const handleClose = () => {
    setIsFadingOut(true);
    setTimeout(() => {
      if (onClose) onClose();
    }, 500);
  };

  return (
    <div
      className={cn(
        'flex max-w-sm items-start gap-3 p-4 mb-3 rounded-lg shadow-lg transition-all duration-500 transform',
        ToastTypes[type],
        ToastVariants[variant],
        isFadingOut
          ? `opacity-0 ${exitAnimationByPosition[position]}`
          : isVisible
          ? `opacity-100 ${enterAnimationByPosition[position]}`
          : `opacity-0 ${initialAnimationByPosition[position]}`
      )}
    >
      {icon && <div className="text-2xl mt-1">{icon}</div>}

      <div className="flex-1">
        {title && <p className="font-semibold text-base mb-1">{title}</p>}
        <p className="text-sm leading-snug">{message}</p>
      </div>

      <button
        onClick={handleClose}
        className="ml-2 text-lg leading-none hover:text-red-500 focus:outline-none"
        aria-label="Close"
      >
        &times;
      </button>
    </div>
  );
};

export default Toast;
