import { FiArrowRight } from "react-icons/fi";

const ArticleCard = ({ title, description, link, image }) => {
  return (
    <div className="flex flex-col md:flex-row gap-6 rounded-2xl bg-white border-2 border-shades overflow-hidden text-foreground">
      <div className="flex-1 p-6 md:p-10 flex flex-col order-2 md:order-1">
        <div className="flex flex-col flex-1 justify-center">
          <p className="font-bold text-xl md:text-2xl mb-4">{title}</p>
          <p className="text-gray-600 mb-6 line-clamp-3 text-sm md:text-base">
            {description}
          </p>
        </div>
        <div className="gap-2 p-3 border rounded-lg border-shades text-shades hover:bg-gray-50 transition-colors w-fit">
          <a href={link} className="flex items-center gap-2 text-sm md:text-base">
            Lihat Selengkapnya
            <FiArrowRight size={18} />
          </a>
        </div>
      </div>

      <div className="flex-1 max-w-full md:max-w-none order-1 md:order-2">
        <img
          src={image}
          alt={title}
          className="w-full h-48 md:h-96 object-cover"
        />
      </div>
    </div>
  );
};

export default ArticleCard;
