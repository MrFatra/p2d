import { FiArrowRight } from "react-icons/fi";
import { ArticleCard } from "../components";
import { Link, usePage } from "@inertiajs/react";

const Article = () => {
    const { articles } = usePage().props;

    if (!articles || articles.length === 0) {
        return (
            <section className="px-4 py-20">
                <div className="container mx-auto max-w-7xl text-center">
                    <h2 className="text-2xl font-bold text-custom-emerald mb-4">
                        Baca Artikel Terkait Kesehatan
                    </h2>
                    <p className="text-gray-500 text-md">
                        Belum ada artikel yang tersedia saat ini. Silakan cek kembali nanti.
                    </p>
                </div>
            </section>
        );
    }

    const mainArticle = articles[0];
    const otherArticles = articles.slice(1);

    return (
        <section id="article" className="px-16 py-20">
            <div className="container mx-auto max-w-7xl">
                <div className="flex flex-col gap-16">
                    {/* Header */}
                    <div className="text-center">
                        <h2 className="text-3xl font-bold text-custom-emerald mb-2">
                            Baca Artikel Terkait Kesehatan
                        </h2>
                        <p className="text-gray-500 max-w-xl mx-auto">
                            Temukan informasi penting tentang kesehatan mental dan fisik melalui artikel pilihan kami.
                        </p>
                    </div>

                    {/* Grid Layout */}
                    <div className="grid grid-cols-1 lg:grid-cols-2 gap-12">
                        {/* Artikel Utama */}
                        <div className="relative rounded-2xl overflow-hidden shadow-lg group transition-all duration-300 bg-white">
                            <div className="aspect-square w-full h-full overflow-hidden">
                                <img
                                    src={mainArticle.cover_image ? `/storage/${mainArticle.cover_image}` : "https://placehold.co/600x400/000000/FFF?text=No+Image"}
                                    alt={mainArticle.title}
                                    className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                />
                            </div>
                            <div className="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent z-10" />
                            <div className="absolute bottom-0 p-8 z-20 text-white">
                                <h3 className="text-2xl font-bold mb-2 drop-shadow-lg">{mainArticle.title}</h3>
                                <div className="w-full"> {/* atau w-full, max-w-sm, dsb */}
                                    <p className="text-sm mb-3 drop-shadow line-clamp-2">
                                        {mainArticle.excerpt}
                                    </p>
                                </div>
                                <Link
                                    href={`/articles/${mainArticle.slug}`}
                                    className="inline-flex items-center gap-2 text-sm font-medium text-custom-link hover:underline"
                                >
                                    Klik untuk lihat selengkapnya <FiArrowRight />
                                </Link>
                            </div>
                        </div>

                        <div className="w-full flex flex-col gap-6">
                            <div className="order-2 lg:order-1 flex items-center justify-center lg:justify-end">
                                <Link
                                    href="/articles"
                                    className="flex items-center gap-2 bg-custom-emerald hover:bg-emerald-800 text-white font-medium px-4 py-2 rounded-full text-sm transition hover:underline"
                                >
                                    Lihat Artikel Lainnya
                                    <FiArrowRight className="text-base" />
                                </Link>
                            </div>

                            <div className="order-1 lg:order-2 flex flex-col gap-6">
                                {otherArticles.map((article, index) => (
                                    <ArticleCard
                                        key={index}
                                        title={article.title}
                                        description={article.excerpt}
                                        imageLeft={false}
                                        image={
                                            article.cover_image
                                                ? `/storage/${article.cover_image}`
                                                : "https://placehold.co/400x300"
                                        }
                                        link={`/articles/${article.slug}`}
                                    />
                                ))}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    );
};

export default Article;
