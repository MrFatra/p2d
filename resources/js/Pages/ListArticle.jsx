import { usePage, Link } from "@inertiajs/react";
import AppLayout from "../layouts/AppLayouts";
import { FiArrowRight } from "react-icons/fi";
import { ArticleCard } from "../components";

const ArticleList = () => {
    const { articles, featured } = usePage().props;

    return (
        <section className="container mx-auto px-4 sm:px-5 lg:px-20 py-8">
            {/* Header dan Artikel Unggulan */}
            <div className="mb-8">
                <div className="rounded-xl overflow-hidden shadow-md relative h-60 sm:h-72 md:h-96">
                    <img
                        src={'storage/' + featured.cover_image}
                        alt="Featured"
                        className="w-full h-full object-cover"
                    />
                    <div className="absolute inset-0 bg-black bg-opacity-50 text-white p-4 sm:p-6 flex flex-col justify-end">
                        <p className="text-base sm:text-lg text-custom-link font-semibold">
                            {featured.category.name}
                        </p>
                        <h2 className="text-lg sm:text-2xl md:text-3xl font-bold mt-1">
                            {featured.title}
                        </h2>
                        <p className="text-sm sm:text-base mt-2 line-clamp-2">
                            {featured.excerpt}
                        </p>
                        <Link
                            href={`/articles/${featured.slug}`}
                            className="inline-flex items-center gap-2 mt-4 text-sm font-medium text-custom-link hover:underline"
                        >
                            Klik untuk lihat selengkapnya <FiArrowRight />
                        </Link>
                    </div>
                </div>
            </div>

            <div className="mb-6 border-2 border-custom-emerald" />

            {/* List Artikel */}
            <div className="space-y-6">
                {articles.data.map((article, index) => (
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

            <div className="mb-6 mt-16 border-2 border-custom-emerald" />

            {/* Pagination */}
            <div className="flex justify-center mt-8">
                <div className="flex items-center gap-2">
                    {articles.links.map((link, index) => (
                        <Link
                            key={index}
                            href={link.url || "#"}
                            dangerouslySetInnerHTML={{ __html: link.label }}
                            className={`px-3 py-1 border rounded ${link.active
                                ? "bg-custom-emerald text-white"
                                : "text-gray-700 hover:bg-gray-100"
                                } ${!link.url ? "opacity-50 pointer-events-none" : ""}`}
                        />
                    ))}
                </div>
            </div>
        </section>
    );
};

ArticleList.layout = (page) => <AppLayout>{page}</AppLayout>;

export default ArticleList;
