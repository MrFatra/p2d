import HistoryCard from "../components/HistoryCard";

function CheckHistory() {
    return (
        <>
            {/* Gambar full bleed tanpa container padding */}
            <div className="relative -mx-4 sm:-mx-6 lg:-mx-8">
                <img
                    src="/images/herosection.png"
                    alt="Header Riwayat"
                    className="w-full h-64 sm:h-80 object-cover"
                />
                <div className="absolute inset-0 flex items-center justify-center">
                    <h1 className="text-white text-xl sm:text-3xl font-bold bg-black/50 px-4 py-2 rounded text-center">
                        Daftar Riwayat Pengecekan
                    </h1>
                </div>
            </div>

            {/* Container untuk konten lainnya agar rapi */}
            <div className="container mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
                {/* FILTER SECTION */}
                <div className="px-0 sm:px-4 md:px-8 py-2 mt-7">
                    <div className="flex flex-wrap justify-center items-center gap-2 md:gap-4">
                        <span className="text-sm font-medium text-gray-700 whitespace-nowrap">
                            Urutkan dari:
                        </span>

                        <select className="border rounded px-2 py-1 text-sm">
                            <option>Januari</option>
                            <option>Februari</option>
                            <option>Maret</option>
                            {/* ... */}
                        </select>

                        <span className="text-sm">-</span>

                        <select className="border rounded px-2 py-1 text-sm">
                            <option>September</option>
                            <option>Oktober</option>
                            <option>November</option>
                            {/* ... */}
                        </select>

                        <select className="border rounded px-2 py-1 text-sm">
                            <option>2025</option>
                            <option>2024</option>
                            <option>2023</option>
                        </select>

                        <button className="bg-custom-emerald text-white px-4 py-1 rounded text-sm font-medium whitespace-nowrap">
                            Terapkan
                        </button>
                    </div>
                </div>

                {/* Garis pemisah */}
                <div className="px-0 sm:px-4 md:px-8">
                    <hr className="border-2 border-custom-emerald" />
                </div>

                {/* Card Riwayat */}
                <div className="space-y-6 px-0 sm:px-4 md:px-8">
                    <HistoryCard
                        type="Bayi"
                        nik="320124234678910"
                        birthInfo="Laki-laki, 12 Januari 2011"
                        name="Dika Suganda"
                        examiner="Bidan Karomay"
                        age="7 Bulan"
                        weight="12 kg"
                        height="70 cm"
                        nutritionStatus="Normal"
                        bbu="Normal"
                        tbu="Pendek"
                        bbtb="Baik"
                        imt="Naik"
                        immunization="Naik"
                        examDate="22 Januari 2025"
                        badgeText="Baik"
                        badgeColor="bg-custom-emerald text-white"
                    />

                    <HistoryCard
                        type="Balita"
                        nik="320124234678910"
                        birthInfo="Laki-laki, 12 Januari 2011"
                        name="Dika Suganda"
                        examiner="Bidan Karomay"
                        age="20 Bulan"
                        weight="10 kg"
                        height="80 cm"
                        nutritionStatus="Normal"
                        bbu="Pendek"
                        tbu="Pendek"
                        bbtb="Cukup"
                        imt="Cukup"
                        immunization="Naik"
                        examDate="22 Januari 2025"
                        badgeText="Cukup"
                        badgeColor="bg-yellow-500 text-white"
                    />

                    <HistoryCard
                        type="Ibu Hamil"
                        nik="320124234678910"
                        birthInfo="Perempuan, 1 Januari 1989"
                        name="Davina Karomay"
                        examiner="Bidan Karomay"
                        age="7 Bulan"
                        weight="70 kg"
                        height="170 cm"
                        parity="1"
                        anc="3"
                        examDate="22 Januari 2025"
                        badgeText="Kurang"
                        badgeColor="bg-red-500 text-white"
                    />
                </div>
            </div>
        </>
    );
}

export default CheckHistory;
