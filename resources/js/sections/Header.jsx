import { FaArrowRight } from "react-icons/fa";
import { Link } from "@inertiajs/react";

const ArrowRightIcon = (props) => <FaArrowRight {...props} />;

const Header = () => {
    return (
        <section
            className="bg-[url('/images/header-bg.jpg')] bg-cover bg-center bg-fixed bg-no-repeat text-foreground"
        >
            <div className="max-w-7xl mx-auto px-6 py-32 flex flex-col-reverse lg:flex-row items-center gap-12">
                {/* Text Section */}
                <div className="w-full lg:w-1/2 text-center lg:text-left">
                    <h3 className="text-2xl font-bold text-custom-emerald underline tracking-wide">
                        {import.meta.env.VITE_APP_NAME.toUpperCase()}
                    </h3>
                    <h2 className="text-3xl md:text-4xl xl:text-5xl font-bold mt-4 leading-tight">
                        Posyandu Muncangela: <br />
                        <span className="text-shades">
                            Sehat Warganya, Maju Desanya
                        </span>
                    </h2>
                    <Link
                        href={route("login.index")}
                        className="inline-flex items-center gap-3 mt-8 border-2 border-custom-emerald text-custom-emerald px-6 py-3 rounded-lg font-bold hover:bg-custom-emerald hover:text-white transition-all duration-300"
                    >
                        Ayo Mulai <ArrowRightIcon />
                    </Link>
                </div>

                {/* Image Section */}
                <div className="w-full lg:w-1/2">
                    <img
                        src="/images/hero.png"
                        alt="Ilustrasi Posyandu"
                        className="w-full h-auto mx-auto"
                    />
                </div>
            </div>
        </section>
    );
};

export default Header;
