import AppLayout from "../layouts/AppLayouts";
import { About, Article, FAQ, Header, Schedule, Statistic} from "../sections";

const Home = () => {

  return (
    <div className="mt-20">
      <Header />
      <About />
      <Schedule />
      <Article />
      <Statistic />
      <FAQ />
    </div>
  );
};

Home.layout = (page) => <AppLayout>{page}</AppLayout>;

export default Home;
