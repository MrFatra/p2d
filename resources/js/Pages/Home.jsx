import AppLayout from "../layouts/AppLayouts";
import { About, Article, FAQ, Header, Schedule, Statistic, ListArticle } from "../sections";

const Home = () => {
  return (
    <div className="mt-20">
      <Header />
      <About />
      <Schedule />
      <Article />
      <Statistic />
      <FAQ />
      <ListArticle />
    </div>
  );
};

Home.layout = (page) => <AppLayout>{page}</AppLayout>;

export default Home;
