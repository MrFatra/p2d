import { useState } from "react";
import { Link } from "@inertiajs/react";
import { FiLogIn, FiMenu, FiX } from "react-icons/fi";

const Navbar = () => {
    const [isOpen, setIsOpen] = useState(false);
    const toggleMenu = () => setIsOpen(!isOpen);

    return (
        <section>
            <div
                id="nav"
                className="w-full bg-gradient-to-l from-emerald-300 via-custom-emerald to-custom-emerald fixed top-0 z-50 py-4 backdrop-blur-lg"
            >
                <div className="container mx-auto px-4 sm:px-6 lg:px-10 flex items-center justify-between">
                    <div className="flex items-center gap-3">
                        <img
                            src="/images/logo.png"
                            alt="Logo"
                            className="w-8 rounded-full lg:w-8"
                        />
                        <h1 className="font-bold whitespace-nowrap text-white lg:text-2xl text-2xl">
                            SIPOSYANDU
                        </h1>
                    </div>
                    <div className="items-center hidden lg:flex gap-10 text-white font-medium text-sm">
                        <Link
                            href="/"
                            className="relative pb-1 after:content-[''] after:absolute after:bottom-0 after:left-0 after:h-[3px] after:rounded-full after:bg-white after:w-0 hover:after:w-full transition-all duration-500"
                        >
                            Jadwal
                        </Link>
                        <Link
                            href="/konseling"
                            className="relative pb-1 after:content-[''] after:absolute after:bottom-0 after:left-0 after:h-[3px] after:rounded-full after:bg-white after:w-0 hover:after:w-full transition-all duration-500"
                        >
                            Konseling
                        </Link>
                        <Link
                            href="/pertumbuhan"
                            className="relative pb-1 after:content-[''] after:absolute after:bottom-0 after:left-0 after:h-[3px] after:rounded-full after:bg-white after:w-0 hover:after:w-full transition-all duration-500"
                        >
                            Cek Pertumbuhan
                        </Link>
                        <Link
                            href="/login"
                            className="lg:flex hidden bg-shades py-2.5 px-5 rounded-lg font-semibold text-white whitespace-nowrap items-center gap-2 text-sm"
                        >
                            Masuk <FiLogIn />
                        </Link>
                    </div>
                    <div className="relative lg:hidden">
                        <button
                            onClick={toggleMenu}
                            className="text-white transition-transform duration-300"
                        >
                            <div className={isOpen ? "rotate-180" : "rotate-0"}>
                                {isOpen ? (
                                    <FiX size={24} />
                                ) : (
                                    <FiMenu size={24} />
                                )}
                            </div>
                        </button>

                        <div
                            className={`absolute right-0 top-10 bg-white z-20 rounded-lg shadow-lg w-48 transition-all duration-500 overflow-hidden ${
                                isOpen
                                    ? "max-h-[200px] opacity-100"
                                    : "max-h-0 opacity-0"
                            }`}
                        >
                            <div className="flex flex-col justify-center items-center gap-3 py-3 px-5">
                                <Link
                                    href="/"
                                    className="text-shades text-sm hover:underline"
                                >
                                    Jadwal
                                </Link>
                                <Link
                                    href="/konseling"
                                    className="text-shades text-sm hover:underline"
                                >
                                    Konseling
                                </Link>
                                <Link
                                    href="/pertumbuhan"
                                    className="text-shades text-sm hover:underline"
                                >
                                    Cek Pertumbuhan
                                </Link>
                                <Link
                                    href="/login"
                                    className="bg-shades py-2 px-5 rounded-lg font-medium text-white flex items-center gap-2 text-sm"
                                >
                                    Masuk <FiLogIn />
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
};

export default Navbar;
