const ArticleCard = ({ title, description, link, image }) => {
    return (
        <div className="flex border border-custom-emerald rounded-xl overflow-hidden shadow-sm hover:shadow-md transition">
            <div className="w-2/3 p-4 flex flex-col justify-between">
                <div>
                    <h3 className="font-semibold text-md text-gray-900">
                        {title}
                    </h3>
                    <p className="text-sm text-gray-600 mt-2 line-clamp-2">
                        {description}
                    </p>
                </div>
                <div className="mt-4">
                    <a
                        href={link}
                        className="text-custom-emerald text-sm font-medium"
                    >
                        Klik untuk lihat selengkapnya
                    </a>
                </div>
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
