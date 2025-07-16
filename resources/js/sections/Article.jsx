import { ArticleCard } from '../components';

const Article = () => {
    const articles = [
        {
            title: "Tips pencegahan “Stunting” pada anak Anda",
            description:
                "Stunting adalah kondisi kekurangan gizi kronis yang menyebabkan anak memiliki tinggi badan lebih rendah dibandingkan standar usianya. Kondisi ini tidak hanya memengaruhi pertumbuhan fisik, tetapi juga perkembangan otak anak, yang dapat berdampak pada kemampuan belajar dan produktivitas di masa depan.",
            link: "https://example.com",
            image: "https://placehold.co/600x400"
        }
    ];

    return (
        <div className="lg:m-28 m-10">
            {articles.map((article, index) => (
                <div key={index}>
                    <ArticleCard {...article} />
                </div>
            ))}
        </div>
    );
};

export default Article;
