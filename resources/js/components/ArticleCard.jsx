import { FiArrowRight } from "react-icons/fi";

const ArticleCard = ({ title, description, link, image }) => {
    return (
        <div className="flex border border-custom-emerald rounded-xl overflow-hidden shadow-sm hover:shadow-md transition">
            <div className="w-2/3 p-4">
                <h3 className="font-semibold text-md text-gray-900">{title}</h3>
                <p className="text-sm text-gray-600 mt-2 line-clamp-2">
                    {description}
                </p>
                <p className="text-custom-emerald text-sm mt-2 font-medium">
                    <a href={link}>Klik untuk lihat selengkapnya</a>
                </p>
            </div>
            <div className="w-1/3">
                <img
                    src={image}
                    alt={title}
                    className="w-full h-full object-cover"
                />
            </div>
        </div>
    );
};

export default ArticleCard;
