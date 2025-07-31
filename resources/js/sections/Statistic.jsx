const Statistic = () => {
    return (
        <div>
            <div className="my-20 lg:my-28 px-5 py-28 bg-gradient-to-br from-custom-emerald to-emerald-300 text-white">
                <div className="container mx-auto flex flex-col gap-5 justify-center items-center">
                    <p className="text-sm md:text-lg font-bold">
                        STATISTIK TAHUN {new Date().getFullYear()}
                    </p>
                    <p className="text-xl md:text-3xl font-bold text-center">
                        "Data Posyandu Peduli Desa Muncangela"
                    </p>
                    <div className="flex gap-x-6 md:gap-x-20 mt-5 md:mt-10 overflow-x-auto no-scrollbar">
                        <div className="flex flex-col items-center min-w-[80px]">
                            <img src="images/baby_face.png" alt="Baby Face" className="w-8 h-8 md:w-12 md:h-12 lg:w-16 lg:h-16" />
                            <p className="text-sm md:text-xl lg:text-2xl font-bold mt-2">154</p>
                            <p className="text-xs md:text-sm font-semibold text-center">Bayi</p>
                        </div>

                        <div className="flex flex-col items-center min-w-[80px]">
                            <img src="images/babies_room.png" alt="Balita" className="w-8 h-8 md:w-12 md:h-12 lg:w-16 lg:h-16" />
                            <p className="text-sm md:text-xl lg:text-2xl font-bold mt-2">54</p>
                            <p className="text-xs md:text-sm font-semibold text-center">Balita</p>
                        </div>

                        <div className="flex flex-col items-center min-w-[80px]">
                            <img src="images/embryo.png" alt="Ibu Hamil" className="w-8 h-8 md:w-12 md:h-12 lg:w-16 lg:h-16" />
                            <p className="text-sm md:text-xl lg:text-2xl font-bold mt-2">75</p>
                            <p className="text-xs md:text-sm font-semibold text-center">Ibu Hamil</p>
                        </div>

                        <div className="flex flex-col items-center min-w-[80px]">
                            <img src="images/grandparents.png" alt="Lansia" className="w-8 h-8 md:w-12 md:h-12 lg:w-16 lg:h-16 object-cover" />
                            <p className="text-sm md:text-xl lg:text-2xl font-bold mt-2">100</p>
                            <p className="text-xs md:text-sm font-semibold text-center">Lansia</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Statistic;
