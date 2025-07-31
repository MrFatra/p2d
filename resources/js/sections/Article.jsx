import { ArticleCard } from "../components";
import { FiArrowRight } from "react-icons/fi";

const Article = () => {
    const articles = [
        {
            title: "Tips pencegahan “Stunting” pada anak Anda",
            description:
                "Stunting adalah kondisi kekurangan gizi kronis yang menyebabkan anak memiliki tinggi badan lebih...",
            image: "https://placehold.co/100",
            link: "#",
        },
        {
            title: "Tips pencegahan “Stunting” pada anak Anda",
            description:
                "Stunting adalah kondisi kekurangan gizi kronis yang menyebabkan anak memiliki tinggi badan lebih...",
            image: "https://placehold.co/100",
            link: "#",
        },
    ];

    return (
        <section className="px-4 py-10">
            <div className="container mx-auto flex flex-col lg:flex-row justify-between items-start gap-8">
                <div className="w-full lg:w-1/2 flex flex-col gap-4">
                    <h2 className="text-lg font-bold text-custom-emerald">
                        Baca Artikel Terkait Kesehatan
                    </h2>
                    <div className="relative rounded-2xl overflow-hidden aspect-[4/3]">
                        <img
                            src="https://placehold.co/100"
                            alt="Main Project"
                            className="w-full h-full object-cover"
                        />
                        <div className="absolute bottom-4 left-4 text-white z-10">
                            <h3 className="text-xl md:text-2xl font-bold leading-snug drop-shadow-lg">
                                Tips pencegahan{" "}
                                <span className="text-white font-extrabold">
                                    “Stunting”
                                </span>
                                <br />
                                pada anak Anda
                            </h3>
                            <a
                                href=""
                                className="text-sm text-custom-emerald mt-2"
                            >
                                Klik untuk lihat selengkapnya
                            </a>
                        </div>
                        <div className="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent z-0" />
                    </div>
                </div>
                <div className="w-full lg:w-1/2 flex flex-col gap-6">
                    <div className="flex items-center justify-center lg:justify-end">
                        <a
                            href="#"
                            className="flex items-center gap-2 bg-custom-emerald hover:bg-emerald-800 text-white font-medium px-4 py-2 rounded-full text-sm transition"
                        >
                            Lihat Artikel Lainnya
                            <FiArrowRight className="text-base" />
                        </a>
                    </div>

                    {articles.map((article, index) => (
                        <ArticleCard key={index} {...article} />
                    ))}
                </div>
            </div>
        </section>
    );
};

export default Article;
