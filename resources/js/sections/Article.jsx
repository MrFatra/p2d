import { usePage } from "@inertiajs/react";
import { ArticleCard } from "../components";
import { FiArrowRight } from "react-icons/fi";

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
            cover_image: "" // coba biarkan kosong untuk tes fallback image
        }
    ];


    // Tampilkan pesan jika tidak ada artikel
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

    const mainArticle = articles[0];
    const otherArticles = articles.slice(1);

    return (
        <section className="px-4 py-10">
            <div className="container mx-auto flex flex-col lg:flex-row justify-between items-start max-w-7xl gap-8">
                {/* Artikel Utama */}
                <div className="w-full lg:w-1/2 flex flex-col gap-4">
                    <h2 className="font-bold text-xl mt-2 lg:text-2xl xl:text-4xl text-custom-emerald">
                        Baca Artikel Terkait Kesehatan
                    </h2>

                    <div className="relative rounded-2xl overflow-hidden h-full bg-slate-200">
                        <img
                            src={mainArticle.cover_image ? `/storage/${mainArticle.cover_image}` : "https://placehold.co/600x400"}
                            alt={mainArticle.title || "NO TITLE"}
                            className="w-full h-full object-cover"
                        />
                        <div className="absolute bottom-4 left-4 z-10 text-white p-5">
                            <h3 className="text-xl md:text-2xl font-bold leading-snug drop-shadow-lg">
                                {mainArticle.title || "Tanpa Judul"}
                            </h3>
                            <a
                                href={mainArticle.slug ? `/articles/${mainArticle.slug}` : "#"}
                                className="text-sm text-custom-link mt-1 block inline-flex"
                            >
                                Klik untuk lihat selengkapnya
                            </a>
                        </div>
                        <div className="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent z-0" />
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
        </section>
    );
};

export default Article;
