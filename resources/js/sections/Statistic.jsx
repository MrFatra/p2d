const Statistic = () => {
    return (
        <div>
            <div className="my-20 lg:my-28 px-5 py-28 flex flex-col gap-5 justify-center items-center bg-gradient-to-br from-custom-emerald to-emerald-300 text-white">

                <p className="text-sm md:text-lg font-bold">STATISTIK TAHUN {new Date().getFullYear()}</p>
                <p className="text-xl md:text-3xl font-bold text-center">"Data Posyandu Peduli Desa Muncangela"</p>
                <div className="flex gap-5 md:gap-20 md:mt-10 mt-5">

                    <div className="flex flex-col items-center">
                        <img src="images/baby_face.png" alt="Baby Face" className="md:w-16 md:h-16 w-10 h-10" />
                        <p className="text-2xl md:text-3xl font-bold mt-2">154</p>
                        <p className="text-sm font-medium">Bayi</p>
                    </div>

                    <div className="flex flex-col items-center">
                        <img src="images/babies_room.png" alt="Baby Face" className="md:w-16 md:h-16 w-10 h-10" />
                        <p className="text-2xl md:text-3xl font-bold mt-2">54</p>
                        <p className="text-sm font-medium">Balita</p>
                    </div>

                    <div className="flex flex-col items-center">
                        <img src="images/embryo.png" alt="" className="md:w-16 md:h-16 w-10 h-10" />
                        <p className="text-2xl md:text-3xl font-bold mt-2">75</p>
                        <p className="text-sm font-medium">Ibu Hamil</p>
                    </div>

                    <div className="flex flex-col items-center">
                        <img src="images/grandparents.png" alt="" className="md:w-16 md:h-16 w-10 h-10 object-cover" />
                        <p className="text-2xl md:text-3xl font-bold mt-2">100</p>
                        <p className="text-sm font-medium">Lansia</p>
                    </div>

                </div>
            </div>
        </div>
    )
}

export default Statistic