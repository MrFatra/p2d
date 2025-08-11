import { FiArrowRight } from "react-icons/fi";
import { ArticleCard } from "../components";

const Article = () => {
    const articles = [
        {
            id: 1,
            title: "Manfaat Konseling Bagi Kesehatan Mental Remaja",
            slug: "manfaat-konseling-kesehatan-mental-remaja",
            excerpt: "Konseling adalah salah satu cara penting untuk menjaga kesehatan mental remaja. Yuk pelajari lebih lanjut manfaatnya.",
            // cover_image: "images/articles/article1.jpg"
        },
        {
            id: 2,
            title: "5 Tips Menjaga Pola Tidur yang Sehat",
            slug: "tips-menjaga-pola-tidur",
            excerpt: "Pola tidur yang baik sangat penting untuk kesehatan fisik dan mental. Berikut 5 tips sederhana untuk tidur lebih nyenyak.",
            cover_image: "images/articles/article2.jpg"
        },
        {
            id: 3,
            title: "Kenali Tanda-Tanda Burnout Sejak Dini",
            slug: "tanda-tanda-burnout",
            excerpt: "Burnout adalah kondisi serius yang bisa memengaruhi produktivitas dan kesehatan. Yuk kenali gejalanya!",
            cover_image: "images/articles/article3.jpg"
        },
        {
            id: 4,
            title: "Pentingnya Nutrisi untuk Kesehatan Otak Anak",
            slug: "nutrisi-untuk-otak-anak",
            excerpt: "Nutrisi berperan besar dalam perkembangan otak anak. Cari tahu makanan apa saja yang menunjangnya di artikel ini.",
            cover_image: "" // empty image
        }
    ];

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
                            <img
                                src={mainArticle.cover_image ? `/storage/${mainArticle.cover_image}` : "https://placehold.co/600x400/000000/FFF?text=No+Image"}
                                alt={mainArticle.title}
                                className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                            />
                            <div className="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent z-10" />
                            <div className="absolute bottom-0 p-8 z-20 text-white">
                                <h3 className="text-2xl font-bold mb-2 drop-shadow-lg">{mainArticle.title}</h3>
                                <p className="text-sm mb-3 drop-shadow">{mainArticle.excerpt}</p>
                                <a
                                    href={`/articles/${mainArticle.slug}`}
                                    className="inline-flex items-center gap-2 text-sm font-medium text-custom-link hover:underline"
                                >
                                    Klik untuk lihat selengkapnya <FiArrowRight />
                                </a>
                            </div>
                        </div>

                        <div className="w-full flex flex-col gap-6">
                            <div className="flex items-center justify-center lg:justify-end">
                                <a
                                    href="/articles"
                                    className="flex items-center gap-2 bg-custom-emerald hover:bg-emerald-800 text-white font-medium px-4 py-2 rounded-full text-sm transition"
                                >
                                    Lihat Artikel Lainnya
                                    <FiArrowRight className="text-base" />
                                </a>
                            </div>

                            {otherArticles.map((article, index) => (
                                <ArticleCard
                                    key={index}
                                    title={article.title}
                                    description={article.excerpt}
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
        </section>
    );
};

export default Article;
