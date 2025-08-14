import { Link, usePage } from "@inertiajs/react";
import AppLayout from "../layouts/AppLayouts";
import { dateFormat } from "../utils/dateFormatter";

const ViewArticle = () => {
    const { article, suggestedArticles } = usePage().props

    return (
        <section className="container mx-auto px-4 sm:px-5 lg:px-20 py-10">
            {/* Kategori dan Judul */}
            <p className="text-custom-emerald font-semibold text-base">{article.category.name}</p>
            <h1 className="text-2xl lg:text-3xl font-bold mt-1 mb-2">
                {article.title}
            </h1>
            <div className="flex space-x-5 mb-5">
                <p className="text-gray-500 text-sm">
                    Dipublikasi pada:{" "}
                    <span className="font-medium text-black">
                        {dateFormat(article.published_at)}
                    </span>
                </p>
                <p className="text-gray-500 text-sm">
                    Dipublikasikan oleh:{" "}
                    <span className="font-medium text-black">
                        {article.user.name}
                    </span>
                </p>
            </div>

            {/* Gambar Artikel */}
            <div className="w-full max-w-4xl aspect-video mx-auto mb-10">
                <img
                    src={article.cover_image_url || "https://placehold.co/600x400"}
                    alt="Article"
                    className="rounded-xl w-full h-full object-cover"
                />
            </div>

            {/* Konten dan Artikel Terkait */}
            <div className="flex flex-col lg:flex-row gap-12">
                {/* Konten Artikel */}
                <div className="flex-1 space-y-8 text-justify text-base leading-relaxed">
                    <div
                        className="prose prose-lg max-w-none"
                        dangerouslySetInnerHTML={{ __html: article.content }}
                    />
                </div>

                {/* Artikel Terkait */}
                <aside className="w-full lg:w-72 shrink-0 px-4">
                    <h3 className="text-custom-emerald font-bold text-lg mb-6">
                        Artikel Terkait:
                    </h3>

                    <div className="flex flex-col gap-6">
                        {suggestedArticles.map((article, index) => (
                            <Link
                                href={route('articles.show', article.slug)}
                                key={index}
                                className="bg-white shadow-md rounded-xl overflow-hidden hover:shadow-lg transition-shadow hover:cursor-pointer"
                            >
                                <img
                                    src={article.cover_image_url || "https://placehold.co/300x180"}
                                    alt={article.title}
                                    className="w-full h-40 object-cover"
                                />

                                <div className="p-4 space-y-2">
                                    <p className="text-custom-emerald font-semibold text-xs">
                                        {article.category.name}
                                    </p>
                                    <h4 className="font-bold text-sm leading-snug line-clamp-2">
                                        {article.title}
                                    </h4>
                                    <p className="line-clamp-2 text-xs text-gray-500">{article.excerpt}</p>
                                </div>
                            </Link>
                        ))}
                    </div>
                </aside>

            </div>
        </section>
    );
};

ViewArticle.layout = (page) => <AppLayout>{page}</AppLayout>;

export default ViewArticle;
