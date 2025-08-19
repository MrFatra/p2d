import { useEffect, useState } from "react";
import { Link, usePage } from "@inertiajs/react";
import { FiLogIn, FiMenu, FiX } from "react-icons/fi";

const Navbar = () => {
    const { auth } = usePage().props;
    const [isOpen, setIsOpen] = useState(false);
    const [showNavbar, setShowNavbar] = useState(true);
    let lastScrollY = window.scrollY;

    const toggleMenu = () => setIsOpen(!isOpen);

    useEffect(() => {
        const handleScroll = () => {
            const currentScrollY = window.scrollY;

            if (currentScrollY > lastScrollY) {
                setShowNavbar(false); // scroll down
            } else {
                setShowNavbar(true); // scroll up
            }

            lastScrollY = currentScrollY;
        };

        window.addEventListener("scroll", handleScroll);
        return () => window.removeEventListener("scroll", handleScroll);
    }, []);

    return (
        <header
            className={`fixed top-0 left-0 w-full z-50 bg-gradient-to-l from-emerald-300 via-custom-emerald to-custom-emerald backdrop-blur-md shadow-md transition-all duration-500 ease-in-out ${
                showNavbar
                    ? "opacity-100 translate-y-0"
                    : "opacity-0 -translate-y-5"
            }`}
        >
            <nav className="container mx-auto px-4 sm:px-6 lg:px-10 py-4 flex items-center justify-between">
                {/* Logo */}
                <Link href={route('landing.page')} className="flex items-center gap-3">
                    <img
                        src="/images/logo.png"
                        alt="Logo"
                        className="w-8 lg:w-8"
                    />
                    <h1 className="font-bold text-white text-xl sm:text-2xl">
                        {import.meta.env.VITE_APP_NAME?.toUpperCase()}
                    </h1>
                </Link>

                {/* Desktop Navigation */}
                <ul className="hidden lg:flex items-center gap-10 text-white font-medium text-sm">
                    {[
                        { name: "Jadwal", href: "#schedule" },
                        { name: "Artikel", href: "#article" },
                        { name: "Riwayat", href: route("check-history") },
                        { name: "FAQ", href: "#faq" },
                    ].map((item) => (
                        <li key={item.name}>
                            <Link
                                href={item.href}
                                className="relative pb-1 after:content-[''] after:absolute after:bottom-0 after:left-0 after:h-[2px] after:bg-white after:w-0 hover:after:w-full after:transition-all after:duration-300"
                            >
                                {item.name}
                            </Link>
                        </li>
                    ))}

                    {auth.user ? (
                        <li className="flex items-center gap-4">
                            <span className="text-white">{auth.user.name}</span>
                            <Link
                                href="/logout"
                                method="post"
                                as="button"
                                className="bg-shades py-2.5 px-5 rounded-lg font-semibold text-white flex items-center gap-2 text-sm transition hover:opacity-90"
                            >
                                Logout
                            </Link>
                        </li>
                    ) : (
                        <li>
                            <Link
                                href={route("login.index")}
                                className="bg-shades py-2.5 px-5 rounded-lg font-semibold text-white flex items-center gap-2 text-sm transition hover:opacity-90"
                            >
                                Masuk <FiLogIn />
                            </Link>
                        </li>
                    )}
                </ul>

                {/* Mobile Menu Button */}
                <button
                    onClick={toggleMenu}
                    className="lg:hidden text-white focus:outline-none transition-transform duration-300"
                    aria-label="Toggle Menu"
                >
                    {isOpen ? <FiX size={24} /> : <FiMenu size={24} />}
                </button>

                {/* Mobile Dropdown Menu */}
                <div
                    className={`absolute top-full right-4 mt-2 w-48 bg-white shadow-lg rounded-lg overflow-hidden transition-all duration-300 ease-in-out ${
                        isOpen
                            ? "max-h-[300px] opacity-100"
                            : "max-h-0 opacity-0"
                    }`}
                >
                    <div className="flex flex-col items-start py-3 px-5 gap-3 text-shades text-sm">
                        <Link
                            href="#schedule"
                            className="hover:underline w-full"
                        >
                            Jadwal
                        </Link>
                        <Link
                            href="#article"
                            className="hover:underline w-full"
                        >
                            Artikel
                        </Link>
                        <Link href="#" className="hover:underline w-full">
                            Riwayat
                        </Link>
                        <Link href="#faq" className="hover:underline w-full">
                            FAQ
                        </Link>
                        {auth.user ? (
                            <Link
                                href="/logout"
                                method="post"
                                as="button"
                                className="bg-shades w-full text-center py-2 px-4 rounded-md text-white font-medium hover:opacity-90 transition"
                            >
                                Logout
                            </Link>
                        ) : (
                            <Link
                                href={route("login.index")}
                                className="bg-shades w-full text-center py-2 px-4 rounded-md text-white font-medium flex justify-center items-center gap-2 hover:opacity-90 transition"
                            >
                                Masuk <FiLogIn />
                            </Link>
                        )}
                    </div>
                </div>
            </nav>
        </header>
    );
};

export default Navbar;
