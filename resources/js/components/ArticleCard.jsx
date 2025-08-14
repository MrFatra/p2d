import { Link } from "@inertiajs/react";
import { FiArrowRight } from "react-icons/fi";

const ArticleCard = ({
    title,
    description,
    link,
    image,
    imageLeft = true,
}) => {
    const flexDirectionClass =
        imageLeft ? "flex-row" : "flex-row-reverse";

    return (
        <article
            className={`flex ${flexDirectionClass} min-h-[180px] border border-custom-emerald rounded-xl overflow-hidden shadow-sm hover:shadow-md transition duration-300 ease-in-out`}
        >
            <div className="w-1/3 min-w-[120px] h-auto overflow-hidden">
                <img
                    src={image}
                    alt={title}
                    loading="lazy"
                    className="w-full h-full object-cover"
                    draggable={false}
                />
            </div>

            <div className="w-2/3 p-6 flex flex-col justify-between">
                <div>
                    <h3 className="font-semibold text-lg text-gray-900">{title}</h3>
                    <p className="text-gray-600 mt-2 text-sm line-clamp-3">{description}</p>
                </div>

                <div className="mt-6">
                    <Link
                        href={link}
                        className="inline-flex items-center gap-2 text-custom-emerald font-medium text-sm hover:underline focus:outline-none focus:ring-2 focus:ring-custom-emerald rounded"
                    >
                        Klik untuk lihat selengkapnya <FiArrowRight aria-hidden="true" />
                    </Link>
                </div>
            </div>
        </article>

    );
};

export default ArticleCard;
