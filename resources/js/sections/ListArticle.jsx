// src/pages/ArticleListPage.tsx

import React from "react";

const articles = [
    {
        id: 1,
        category: "DBD",
        title: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod",
        date: "Kamis, 31 Juli 2025",
        image: "https://placehold.co/600x400/png",
        excerpt:
            "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...",
    },
    {
        id: 2,
        category: "DBD",
        title: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod",
        date: "Kamis, 31 Juli 2025",
        image: "https://placehold.co/600x400/png",
        excerpt:
            "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...",
    },
    {
        id: 3,
        category: "DBD",
        title: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod",
        date: "Kamis, 31 Juli 2025",
        image: "https://placehold.co/600x400/png",
        excerpt:
            "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...",
    },
];

const ArticleListPage = () => {
    return (
        <section className="container mx-auto px-4 sm:px-5 lg:px-20 py-8">
            <div className="mb-8">
                <div className="rounded-xl overflow-hidden shadow-md relative h-60 sm:h-72 md:h-96">
                    {/* Gambar */}
                    <img
                        src="https://placehold.co/1200x400/png"
                        alt="Featured"
                        className="w-full h-full object-cover"
                    />

                    {/* Overlay teks di dalam gambar */}
                    <div className="absolute inset-0 bg-black bg-opacity-50 text-white p-4 sm:p-6 flex flex-col justify-end">
                        <p className="text-base sm:text-lg text-custom-emerald font-semibold">
                            DBD
                        </p>
                        <h2 className="text-lg sm:text-2xl md:text-3xl font-bold mt-1">
                            Lorem ipsum dolor sit amet, consectetur adipiscing
                            elit. Sed do eiusmod
                        </h2>
                        <p className="text-sm sm:text-base mt-2">
                            Lorem ipsum dolor sit amet, consectetur adipiscing
                            elit. Sed do eiusmod tempor incididunt ut labore et
                            dolore magna aliqua...
                        </p>
                    </div>
                </div>
            </div>

            <div className="mb-6 border-2 border-custom-emerald" />

            {/* List Artikel */}
            <div className="space-y-6">
                {articles.map((article) => (
                    <div
                        key={article.id}
                        className="flex flex-col sm:flex-row gap-4"
                    >
                        <img
                            src={article.image}
                            alt={article.title}
                            className="w-full sm:w-36 h-36 sm:h-24 rounded-md object-cover"
                        />
                        <div>
                            <p className="text-sm text-custom-emerald font-semibold">
                                {article.category}
                            </p>
                            <h3 className="font-bold text-md sm:text-lg">
                                {article.title}
                            </h3>
                            <p className="text-sm text-gray-600">
                                {article.excerpt}
                            </p>
                            <p className="text-sm text-gray-400 mt-1">
                                {article.date}
                            </p>
                        </div>
                    </div>
                ))}
            </div>

            <div className="mb-6 mt-16 border-2 border-custom-emerald" />

            {/* Pagination */}
            <div className="flex justify-center mt-8">
                <div className="flex items-center gap-2">
                    <button
                        className="px-3 py-1 border rounded disabled:opacity-50"
                        disabled
                    >
                        &lt;&lt;
                    </button>
                    <button className="px-3 py-1 border bg-teal-500 text-white rounded">
                        1
                    </button>
                    <button className="px-3 py-1 border rounded" disabled>
                        &gt;&gt;
                    </button>
                </div>
            </div>
        </section>
    );
};

export default ArticleListPage;
