// src/pages/ArticleDetailPage.tsx

import React from "react";

const relatedArticles = [
    {
        id: 1,
        category: "DBD",
        title: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod",
    },
    {
        id: 2,
        category: "DBD",
        title: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod",
    },
    {
        id: 3,
        category: "DBD",
        title: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod",
    },
];

const ArticleDetail = () => {
    return (
        <section className="container mx-auto px-4 sm:px-5 lg:px-20 py-10">
            {/* Kategori dan Judul */}
            <p className="text-custom-emerald font-semibold text-base">DBD</p>
            <h1 className="text-2xl lg:text-3xl font-bold mt-1 mb-2">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do
                eiusmod
            </h1>
            <p className="text-gray-500 text-sm mb-6">
                Dipublikasi pada:{" "}
                <span className="font-medium text-black">
                    Kamis, 31 April 2025
                </span>
            </p>

            {/* Gambar Artikel */}
            <img
                src="https://placehold.co/800x400/png"
                alt="Article"
                className="rounded-xl w-full mb-10 object-cover"
            />

            {/* Konten dan Artikel Terkait */}
            <div className="flex flex-col lg:flex-row gap-12">
                {/* Konten Artikel */}
                <div className="flex-1 space-y-8 text-justify text-base leading-relaxed">
                    {[1, 2].map((section, index) => (
                        <div key={index} className="space-y-3">
                            {/* Judul dengan nomor rapi */}
                            <h2 className="font-semibold text-xl text-gray-800 flex items-start gap-2">
                                <span>{section}.</span>
                                <span className="flex-1">
                                    Lorem ipsum dolor sit amet, consectetur
                                    adipiscing elit.
                                </span>
                            </h2>

                            {/* Deskripsi masuk ke kanan */}
                            <div className="ml-6 space-y-4 text-gray-700 leading-relaxed">
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur
                                    adipiscing elit. Sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua.
                                    Ut enim ad minim veniam, quis nostrud
                                    exercitation ullamco laboris nisi ut aliquip
                                    ex ea commodo consequat.
                                </p>
                                <p>
                                    Duis aute irure dolor in reprehenderit in
                                    voluptate velit esse cillum dolore eu fugiat
                                    nulla pariatur. Excepteur sint occaecat
                                    cupidatat non proident, sunt in culpa qui
                                    officia deserunt mollit anim id est laborum.
                                </p>
                            </div>
                        </div>
                    ))}
                </div>

                {/* Artikel Terkait */}
                <aside className="w-full lg:w-72 shrink-0 px-4">
                    <h3 className="text-custom-emerald font-bold text-lg mb-6">
                        Artikel Terkait:
                    </h3>
                    <div className="space-y-6 text-sm">
                        {relatedArticles.map((article) => (
                            <div
                                key={article.id}
                                className="pb-5 border-b-2 border-custom-emerald last:border-none"
                            >
                                <p className="text-custom-emerald font-semibold mb-2">
                                    {article.category}
                                </p>
                                <p className="font-bold leading-relaxed">
                                    {article.title}
                                </p>
                            </div>
                        ))}
                    </div>
                </aside>
            </div>
        </section>
    );
};

export default ArticleDetail;
