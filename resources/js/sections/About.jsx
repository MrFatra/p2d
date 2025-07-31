import { FaCheckCircle } from "react-icons/fa";

const CheckIcon = (props) => <FaCheckCircle {...props} />;

const About = () => {
    return (
        <section className="my-28 lg:py-28 py-20 bg-emerald-50">
            <div className="container mx-auto px-5 md:px-10 xl:px-28 flex flex-col md:flex-row items-center gap-5">
                {/* Gambar */}
                <div className="hidden lg:flex justify-center w-full">
                    <div className="w-lg lg:pl-10">
                        <img
                            src="/images/nurses_about.png"
                            className="w-[550px] h-[550px]"
                            alt="Tentang Kami"
                        />
                    </div>
                </div>

                {/* Konten */}
                <div className="flex flex-col w-full gap-5 text-foreground lg:text-start text-center items-center lg:items-start">
                    <div>
                        <h2 className="text-custom-emerald text-2xl md:text-3xl font-bold mb-2">
                            Tentang Kami
                        </h2>
                        <p className="font-light text-sm md:text-base max-w-lg">
                            Posyandu Peduli Desa Muncangela menyediakan layanan
                            kesehatan (timbangan, balita, imunisasi, konsultasi
                            gizi, dan pemeriksaan tumbuh kembang). Kami
                            berkomitmen menciptakan generasi sehat dan
                            berkualitas.
                        </p>
                    </div>

                    <h3 className="text-custom-emerald font-semibold mt-4 mb-2 text-center lg:text-start text-sm md:text-base">
                        Layanan, Fasilitas, dan Kelebihan Posyandu Peduli Desa
                        Muncangela:
                    </h3>

                    <div className="space-y-5 font-medium text-sm md:text-base text-foreground w-full flex flex-col items-center lg:items-start">
                        <div className="flex items-center gap-2">
                            <CheckIcon className="text-green-400" />
                            <p>Fasilitas yang lengkap dan terawat.</p>
                        </div>
                        <div className="flex items-center gap-2">
                            <CheckIcon className="text-green-400" />
                            <p>
                                Tenaga kesehatan yang profesional dan responsif.
                            </p>
                        </div>
                        <div className="flex items-center gap-2">
                            <CheckIcon className="text-green-400" />
                            <p>Pelayanan yang cepat dan bersahabat.</p>
                        </div>
                        <div className="flex items-center gap-2">
                            <CheckIcon className="text-green-400" />
                            <p>Akses mudah dan terjangkau untuk semua.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
};

export default About;
