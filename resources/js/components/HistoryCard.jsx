import { FaUser } from "react-icons/fa";

const HistoryCard = ({
    name,
    nik,
    birthDate,
    age,
    weight,
    height,
    badgeText,
    badgeColor,
    nutritionStatus,
    stuntingStatus,
    vitaminA,
}) => {
    return (
        <div className="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div
                className="
                    bg-white shadow rounded-lg p-4
                    flex flex-col space-y-6
                    lg:flex-row lg:space-y-0 lg:space-x-6
                    items-center lg:items-start
                    border border-custom-emerald
                "
            >
                {/* KIRI */}
                <div className="w-full lg:w-2/5 flex flex-col items-center lg:items-start space-y-4 lg:space-y-0 lg:flex-row lg:gap-6">
                    <div className="flex flex-col items-center min-w-[100px]">
                        <span className="text-xs font-semibold text-custom-emerald mb-1 text-center">
                            Kategori Pemeriksaan: Bayi
                        </span>
                        <div className="bg-gray-100 p-4 rounded-full">
                            <FaUser className="text-gray-600 text-4xl" />
                        </div>
                        <div className="mt-2 text-center w-full">
                            <p className="font-semibold">{name}</p>
                            <div className="flex items-center gap-2 text-xs text-gray-500 mt-1 justify-center lg:justify-start">
                                <span>Tanggal Periksa:</span>
                                <span className="font-medium text-gray-700 whitespace-nowrap">
                                    22 Januari 2025
                                </span>
                            </div>
                        </div>
                    </div>
                    <div className="flex flex-col justify-center gap-2 flex-grow text-sm items-center lg:items-start lg:pt-8">
                        <div className="flex items-center gap-1">
                            <span className="text-gray-500">NIK:</span>
                            <span className="font-medium break-words">
                                {nik}
                            </span>
                        </div>
                        <div className="flex items-center gap-1">
                            <span className="text-gray-500">
                                Tanggal Lahir:
                            </span>
                            <span className="font-medium whitespace-nowrap">
                                {birthDate}
                            </span>
                        </div>
                    </div>
                </div>

                <div className="w-full lg:w-1/3 flex flex-col items-center lg:items-start justify-between text-sm lg:pt-6 h-full">
                    <div className="space-y-1 w-full">
                        <div className="flex items-center gap-1 justify-center lg:justify-start w-full">
                            <p className="text-gray-500">Usia:</p>
                            <p className="font-medium">{age}</p>
                        </div>
                        <div className="flex items-center gap-1 justify-center lg:justify-start w-full">
                            <p className="text-gray-500">Berat Badan:</p>
                            <p className="font-medium">{weight}</p>
                        </div>
                        <div className="flex items-center gap-1 justify-center lg:justify-start w-full">
                            <p className="text-gray-500">Tinggi Badan:</p>
                            <p className="font-medium">{height}</p>
                        </div>
                    </div>

                    <span
                        className={`inline-block px-3 py-1 mt-2 text-xs font-semibold rounded-full max-w-max ${badgeColor}`}
                    >
                        {badgeText}
                    </span>
                </div>

                {/* KANAN */}
                <div className="w-full lg:w-1/3 flex flex-col justify-center space-y-1.5 text-sm items-center lg:items-start lg:pt-8">
                    <div className="flex items-center gap-1">
                        <span className="text-gray-500">Status Gizi:</span>
                        <span className="font-medium">{nutritionStatus}</span>
                    </div>
                    <div className="flex items-center gap-1">
                        <span className="text-gray-500">Stunting Status:</span>
                        <span className="font-medium">{stuntingStatus}</span>
                    </div>
                    <div className="flex items-center gap-1">
                        <span className="text-gray-500">Vitamin A:</span>
                        <span className="font-medium">{vitaminA}</span>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default HistoryCard;
