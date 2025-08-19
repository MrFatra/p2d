import { useState } from "react";
import { FaUser } from "react-icons/fa";
import { IoClose } from "react-icons/io5"; // icon X

const HistoryCard = ({
    type,
    name,
    nik,
    birthDate,
    examDate,
    badgeText,
    badgeColor,
    weight,
    height,
    headCircumference,
    birthWeight,
    birthHeight,
    checkupDate,
    nutritionStatus,
    completeImmunization,
    vitaminA,
    stuntingStatus,
    exclusiveBreastfeeding,
    complementaryFeeding,
    motorDevelopment,
    bloodPressure,
    bloodGlucose,
    cholesterol,
    bmi,
    age,
    gender,
    upperArmCircumference,
    immunizationFollowup,
    foodSupplement,
    parentingEducation,
    category,
    functionalAbility,
    chronicDiseaseHistory,
}) => {
    const [isOpen, setIsOpen] = useState(false);

    return (
        <>
            <div className="bg-white shadow-lg rounded-3xl flex flex-col border border-gray-200 w-full overflow-hidden">
                {/* Konten utama card */}
                <div className="flex-1 flex flex-col items-center space-y-4 p-6">
                    <div className="bg-gray-100 p-4 rounded-full">
                        <FaUser className="text-gray-600 text-4xl" />
                    </div>

                    <p className="font-semibold text-lg text-center">{name}</p>

                    <div className="text-center text-gray-500 text-sm space-y-1">
                        <p>{nik}</p>
                        <p>{gender ?? "-"}</p>
                        <p>{birthDate}</p>
                    </div>

                    <span
                        className={`inline-block px-6 py-2 text-sm font-semibold rounded-full ${badgeColor}`}
                    >
                        {badgeText}
                    </span>

                    <div className="text-center font-bold text-sm space-y-1">
                        <p>
                            Kategori Pemeriksaan:{" "}
                            <span className="text-custom-emerald">{type}</span>
                        </p>
                        <p>
                            Tanggal Pemeriksaan:{" "}
                            <span className="text-custom-emerald">
                                {examDate}
                            </span>
                        </p>
                    </div>
                </div>

                {/* Tombol full width dan bottom rounded */}
                <button
                    onClick={() => setIsOpen(true)}
                    className="bg-custom-emerald text-white w-full py-3 font-medium hover:bg-green-900 rounded-b-xl"
                >
                    Lihat Selengkapnya
                </button>
            </div>

            {/* Modal */}
            {isOpen && (
                <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
                    <div className="bg-white rounded-xl p-6 w-full max-w-lg relative">
                        {/* Tombol tutup */}
                        <button
                            onClick={() => setIsOpen(false)}
                            className="absolute top-4 right-4 text-gray-600 hover:text-gray-800"
                        >
                            <IoClose size={24} />
                        </button>

                        <h2 className="text-xl font-bold mb-4">{name}</h2>

                        {/* Section Data Pribadi */}
                        <section className="mb-4">
                            <h3 className="font-semibold mb-2">Data Pribadi</h3>
                            <p>NIK: {nik}</p>
                            <p>Umur: {age ?? "-"}</p>
                            <p>Tanggal Lahir: {birthDate}</p>
                        </section>

                        <hr className="border-t-2 border-emerald-500 my-4" />

                        {/* Section Pemeriksaan */}
                        <section className="mb-4">
                            <h3 className="font-semibold mb-2">Pemeriksaan</h3>
                            <p>Kategori Pemeriksaan: {type}</p>
                            <p>Tanggal Pemeriksaan: {examDate}</p>
                            <p>Status: {badgeText}</p>
                            <p>Berat: {weight}</p>
                            <p>Tinggi: {height}</p>
                        </section>

                        <hr className="border-t-2 border-emerald-500 my-4" />

                        {/* Section Hasil Pemeriksaan / Status Gizi */}
                        <section className="mb-4">
                            {category === "Infant" && (
                                <>
                                    <h3 className="font-semibold mb-2">
                                        Hasil Pemeriksaan
                                    </h3>
                                    <p>
                                        Lingkar Kepala:{" "}
                                        {headCircumference ?? "-"}
                                    </p>
                                    <p>Berat Lahir: {birthWeight ?? "-"}</p>
                                    <p>Tinggi Lahir: {birthHeight ?? "-"}</p>
                                    <p>Status Gizi: {nutritionStatus ?? "-"}</p>
                                    <p>
                                        Status Stunting: {stuntingStatus ?? "-"}
                                    </p>
                                    <p>
                                        Imunisasi Lengkap:{" "}
                                        {completeImmunization ?? "-"}
                                    </p>
                                    <p>Vitamin A: {vitaminA ?? "-"}</p>
                                    <p>
                                        ASI Eksklusif:{" "}
                                        {exclusiveBreastfeeding ?? "-"}
                                    </p>
                                    <p>
                                        Makanan Pendamping ASI:{" "}
                                        {complementaryFeeding ?? "-"}
                                    </p>
                                    <p>
                                        Perkembangan Motorik:{" "}
                                        {motorDevelopment ?? "-"}
                                    </p>
                                </>
                            )}

                            {category === "Adult" && (
                                <>
                                    <h3 className="font-semibold mb-2">
                                        Hasil Pemeriksaan
                                    </h3>
                                    <p>Tekanan Darah: {bloodPressure ?? "-"}</p>
                                    <p>Gula Darah: {bloodGlucose ?? "-"}</p>
                                    <p>Kolesterol: {cholesterol ?? "-"}</p>
                                    <p>BMI: {bmi ?? "-"}</p>
                                </>
                            )}

                            {category === "Toddler" && (
                                <>
                                    <h3 className="font-semibold mb-2">
                                        Hasil Pemeriksaan
                                    </h3>
                                    <p>
                                        Lingkar Lengan Atas:{" "}
                                        {upperArmCircumference ?? "-"}
                                    </p>
                                    <p>Status Gizi: {nutritionStatus ?? "-"}</p>
                                    <p>
                                        Status Stunting: {stuntingStatus ?? "-"}
                                    </p>
                                    <p>
                                        Vitamin A: {vitaminA ? "Ya" : "Tidak"}
                                    </p>
                                    <p>
                                        Follow-up Imunisasi:{" "}
                                        {immunizationFollowup ? "Ya" : "Tidak"}
                                    </p>
                                    <p>
                                        Suplementasi Makanan:{" "}
                                        {foodSupplement ? "Ya" : "Tidak"}
                                    </p>
                                    <p>
                                        Pendidikan Parenting:{" "}
                                        {parentingEducation ? "Ya" : "Tidak"}
                                    </p>
                                    <p>
                                        Perkembangan Motorik:{" "}
                                        {motorDevelopment ?? "-"}
                                    </p>
                                    <p>
                                        Tanggal Pemeriksaan:{" "}
                                        {checkupDate ?? "-"}
                                    </p>
                                </>
                            )}

                            {category === "Elderly" && (
                                <>
                                    <h3 className="font-semibold mb-2">
                                        Hasil Pemeriksaan
                                    </h3>
                                    <p>Tekanan Darah: {bloodPressure}</p>
                                    <p>Gula Darah: {bloodGlucose}</p>
                                    <p>Kolesterol: {cholesterol}</p>
                                    <p>Status Gizi: {nutritionStatus}</p>
                                    <p>
                                        Kemampuan Fungsional:{" "}
                                        {functionalAbility}
                                    </p>
                                    <p>
                                        Riwayat Penyakit Kronis:{" "}
                                        {chronicDiseaseHistory}
                                    </p>
                                </>
                            )}
                        </section>
                    </div>
                </div>
            )}
        </>
    );
};

export default HistoryCard;
