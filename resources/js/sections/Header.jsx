import { FaArrowRight } from "react-icons/fa";
import { Link } from "@inertiajs/react";

const ArrowRightIcon = (props) => <FaArrowRight {...props} />;

const Header = () => {
    return (
        <section
            className="lg:mt-32 bg-cover bg-center bg-no-repeat"
            style={{
                backgroundSize: "cover",
                backgroundPosition: "center center",
                backgroundAttachment: "fixed",
            }}
        >
            <div className="container mx-auto lg:mt-24 mt-36 gap-14 justify-center flex flex-wrap items-center px-10 text-foreground">
                <div className="w-full self-center lg:w-1/3 text-center lg:text-start">
                    <h3 className="text-2xl font-bold text-custom-emerald">
                        Posyandu Peduli Desa
                    </h3>
                    <h2 className="font-bold text-xl lg:mb-4 mt-2 lg:text-2xl xl:text-4xl">
                        Merangkul Keluarga untuk Masa Depan Sehat Bersama.
                    </h2>
                    <Link
                        href="/"
                        className="lg:flex inline-flex items-center justify-center gap-3 lg:mt-10 mt-5 border-2 border-custom-emerald py-2.5 px-5 rounded-lg font-bold text-custom-emerald hover:shadow-lg hover:bg-custom-emerald hover:text-white transition-all duration-200"
                    >
                        Ayo Mulai <ArrowRightIcon />
                    </Link>
                </div>

                <div className="hidden lg:block lg:w-1/2 lg:pl-10">
                    <img
                        src="images/hero.png"
                        alt="Ilustrasi Posyandu"
                        className="w-full mx-auto lg:ml-auto"
                    />
                </div>
            </div>
        </section>
    );
};

export default Header;
