import { useState } from "react";
import { FaChevronDown } from "react-icons/fa";

const FAQ = () => {
    const [openFaq, setOpenFaq] = useState(null);

    const toggleFaq = (id) => {
        setOpenFaq(openFaq === id ? null : id);
    };

    const faqs = [
        {
            id: "faq1",
            question: "Apa itu Siposyandu?",
            answer: "Siposyandu adalah singkatan dari Pusat Pengembangan Diri yang merupakan tempat untuk mengembangkan diri melalui berbagai kegiatan positif.",
        },
        {
            id: "faq2",
            question: "Bagaimana cara bergabung dengan Siposyandu?",
            answer: "Anda bisa mendaftar melalui website resmi Siposyandu atau datang langsung ke kantor kami untuk informasi lebih lanjut.",
        },
        {
            id: "faq3",
            question: "Apa saja layanan yang tersedia di Siposyandu?",
            answer: "Siposyandu menyediakan berbagai layanan seperti pelatihan, konsultasi, dan workshop untuk pengembangan diri.",
        },
        {
            id: "faq4",
            question: "Apakah ada biaya untuk bergabung?",
            answer: "Tidak ada biaya untuk bergabung dengan layanan Siposyandu, beberapa kegiatan di Siposyandu juga bersifat gratis. Silakan cek informasi lengkapnya di website kami.",
        },
    ];

    return (
        <section className="py-20 bg-white text-foreground">
            <div className="max-w-7xl mx-auto px-4">
                <div className="flex flex-col lg:flex-row gap-12 items-center">
                    {/* Left Side */}
                    <div className="lg:w-1/2 space-y-4 text-center lg:text-left">
                        <h2 className="text-shades text-2xl font-bold">FAQ</h2>
                        <h3 className="text-3xl font-bold">
                            Punya Pertanyaan Seputar SIPOSYANDU?
                        </h3>
                        <p className="text-base font-light">
                            Temukan jawaban dari pertanyaan yang sering diajukan
                            langsung di sini untuk informasi tentang layanan, jadwal, dan fasilitas SIPOSYANDU.
                        </p>
                    </div>

                    {/* Right Side - FAQ List */}
                    <div className="lg:w-1/2 w-full">
                        <div className="space-y-4">
                            {faqs.map((faq) => (
                                <div
                                    key={faq.id}
                                    className="border border-gray-300 rounded-md transition-all duration-100"
                                >
                                    <button
                                        onClick={() => toggleFaq(faq.id)}
                                        className="w-full flex justify-between items-center p-4 text-left transition-all duration-300"
                                    >
                                        <span className="font-semibold text-shades">{faq.question}</span>
                                        <FaChevronDown
                                            className={`transition-all duration-300 text-shades ${openFaq === faq.id ? "rotate-180" : ""}`}
                                        />
                                    </button>

                                    {/* Animated answer container */}
                                    <div className={`overflow-hidden transition-all duration-500 ease-in-out ${openFaq === faq.id ? "max-h-96 opacity-100" : "max-h-0 opacity-0"
                                        }`}>
                                        <div className="px-4 pb-4 text-sm text-gray-600 transform transition-transform duration-300">
                                            {faq.answer}
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
};

export default FAQ;