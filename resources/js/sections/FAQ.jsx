import { FaChevronCircleDown } from "react-icons/fa";

const ChevronDownIcon = (props) => <FaChevronCircleDown {...props} />;

const FAQ = () => {
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
        <div className="my-28 lg:py-28">
            <div className="container mx-auto px-4 lg:flex gap-10 text-foreground">
                <div className="flex flex-col self-center flex-1 lg:mb-0 mb-5 lg:text-left text-center">
                    <p className="text-shades font-bold md:text-2xl text-xl">
                        FAQ
                    </p>
                    <p className="text-xl md:text-3xl font-bold">
                        Punya Pertanyaan Seputar SIPOSYANDU?
                    </p>
                    <p className="font-light mt-2 text-sm md:text-base">
                        Temukan jawaban dari pertanyaan yang sering diajukan
                        langsung di sini untuk informasi tentang layanan,
                        jadwal, dan fasilitas SIPOSYANDU.
                    </p>
                </div>

                <div className="border-2 rounded-lg p-5 border-shades flex-1">
                    <div className="flex flex-col gap-5 w-full">
                        {faqs.map((faq) => (
                            <div key={faq.id} className="group">
                                <label
                                    htmlFor={faq.id}
                                    className="flex justify-between items-center cursor-pointer"
                                >
                                    <div className="text-shades font-bold text-sm md:text-lg flex-1">
                                        {faq.question}
                                    </div>
                                    <ChevronDownIcon className="text-shades transform transition-transform duration-200 group-hover:rotate-180" />
                                </label>
                                <input
                                    type="checkbox"
                                    id={faq.id}
                                    className="hidden peer"
                                />
                                <div className="max-h-0 overflow-hidden transition-all duration-300 peer-checked:max-h-40">
                                    <p className="font-light pt-2 text-sm md:text-base">
                                        {faq.answer}
                                    </p>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </div>
    );
};

export default FAQ;
