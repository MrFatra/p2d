import { FiPhone } from "react-icons/fi";

const Footer = () => {
    return (
        <footer className="mt-28 bg-gradient-to-br from-custom-emerald to-emerald-300 text-white py-20">
            <div className="container mx-auto px-5 md:px-10 lg:px-20 xl:px-28">
                <div className="flex flex-col md:flex-row gap-10 md:gap-20">
                    <div className="flex flex-col gap-5 flex-1">
                        <div className="flex items-center gap-3">
                            <img
                                src="/images/logo.png"
                                alt="Logo P2D"
                                className="w-8 h-8 rounded-full"
                            />
                            <p className="text-xl md:text-2xl font-bold">
                                SIPOSYANDU
                            </p>
                        </div>
                        <p className="text-xs md:text-sm font-light max-w-md">
                            "Posyandu Peduli Desa berkomitmen memberikan layanan
                            kesehatan terbaik untuk ibu hamil, balita, dan
                            masyarakat. Bersama, kita bangun masa depan yang
                            lebih sehat, cerdas, dan berkualitas demi
                            kesejahteraan generasi mendatang."
                        </p>
                    </div>

                    <div className="flex flex-col flex-1 items-center">
                        <div className="flex flex-col items-center md:items-start">
                            <p className="text-2xl font-bold mb-5">Menu</p>
                            <ul className="flex flex-col gap-2 md:items-start items-center">
                                <li className="font-medium underline hover:text-gray-200 transition-colors">
                                    <a href="#schedule">Jadwal</a>
                                </li>
                                <li className="font-medium underline hover:text-gray-200 transition-colors">
                                    <a href="#article">Artikel</a>
                                </li>
                                <li className="font-medium underline hover:text-gray-200 transition-colors">
                                    <a href="#">
                                        Riwayat
                                    </a>
                                </li>
                                <li className="font-medium underline hover:text-gray-200 transition-colors">
                                    <a href="#faq">FAQ</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div className="flex flex-col flex-1 items-center md:items-start">
                        <p className="text-2xl font-bold mb-5">Konseling</p>
                        <p className="text-xs md:text-sm font-light text-center md:text-left max-w-md">
                            "Berbagi cerita dan konsultasi dengan bidan kami
                            untuk solusi terbaik. Kami siap mendampingi
                            kesehatan Anda dan buah hati."
                        </p>
                        <a href="mailto:contact@siposyandu.com" className="flex gap-3 rounded-lg border py-2 px-3 mt-5 hover:bg-white/10 transition-colors cursor-pointer lg:text-base text-sm">
                            <FiPhone size={20} />
                            <p>Hubungi Kami</p>
                        </a>
                    </div>
                </div>

                <div className="mt-20 text-center text-xs md:text-sm font-light">
                    &copy; {new Date().getFullYear()} Siposyandu. All rights
                    reserved.
                </div>

                <div className="mt-5 flex justify-center gap-6">
                    <img
                        src="/images/logo/berdampak.png"
                        alt="Logo 1"
                        className="w-8 h-8"
                    />
                    <img
                        src="/images/logo/tutwurihandayani.png"
                        alt="Logo 2"
                        className="w-8 h-8"
                    />
                    <img
                        src="/images/logo/uniku.png"
                        alt="Logo 3"
                        className="w-8 h-8"
                    />
                </div>
            </div>
        </footer>
    );
};

export default Footer;
