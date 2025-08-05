import { usePage } from "@inertiajs/react";
import { ArticleCard } from "../components";
import { FiArrowRight } from "react-icons/fi";

const Article = () => {
    const { articles } = usePage().props;

    // Jika tidak ada artikel sama sekali
    if (!articles || articles.length === 0) {
        return (
            <section className="px-4 py-10">
                <div className="container mx-auto max-w-7xl text-center py-12">
                    <h2 className="text-lg font-bold text-custom-emerald mb-2">
                        Baca Artikel Terkait Kesehatan
                    </h2>
                    <p className="text-gray-500 text-sm">
                        Belum ada artikel yang tersedia saat ini. Silakan cek kembali nanti.
                    </p>
                </div>
            </section>
        );
    }

    return (
        <section className="px-4 py-10">
            <div className="container mx-auto flex flex-col lg:flex-row justify-between items-start max-w-7xl gap-8">

                {/* Artikel Utama (Artikel Pertama) */}
                <div className="w-full lg:w-1/2 flex flex-col gap-4">
                    <h2 className="text-lg font-bold text-custom-emerald">
                        Baca Artikel Terkait Kesehatan
                    </h2>

                    <div className="relative rounded-2xl overflow-hidden aspect-[4/3]">
                        <img
                             src={`/storage/${articles[0].cover_image}`}
                            alt={articles[0].title}
                            className="w-full h-full object-cover"
                        />
                        <div className="absolute bottom-4 left-4 text-white z-10">
                            <h3 className="text-xl md:text-2xl font-bold leading-snug drop-shadow-lg">
                                {articles[0].title}
                            </h3>
                            <a
                                href={`/articles/${articles[0].slug}`}
                                className="text-sm text-custom-emerald mt-2"
                            >
                                Klik untuk lihat selengkapnya
                            </a>
                        </div>
                        <div className="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent z-0" />
                    </div>
                </div>

                {/* Artikel Lainnya */}
                <div className="w-full lg:w-1/2 flex flex-col gap-6">
                    <div className="flex items-center justify-center lg:justify-end">
                        <a
                            href="/articles"
                            className="flex items-center gap-2 bg-custom-emerald hover:bg-emerald-800 text-white font-medium px-4 py-2 rounded-full text-sm transition"
                        >
                            Lihat Artikel Lainnya
                            <FiArrowRight className="text-base" />
                        </a>
                    </div>

                    {articles.slice(1).map((article, index) => (
                        <ArticleCard
                            key={index}
                            title={article.title}
                            description={article.excerpt}
                            image={article.cover_image || "https://placehold.co/100"}
                            link={`/articles/${article.slug}`}
                        />
                    ))}
                </div>
            </div>
        </section>
    );
};

export default Article;
