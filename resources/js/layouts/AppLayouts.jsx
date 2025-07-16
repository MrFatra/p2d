import { Navbar, Footer } from "../components";

const AppLayout = ({ children }) => {
  return (
    <>
      <Navbar />
      <main className="mt-20">{children}</main>
      <Footer />
    </>
  );
};

export default AppLayout;
