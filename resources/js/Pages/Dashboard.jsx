import AppLayout from "../layouts/AppLayouts";

const Dashboard = () => {
  return (
    <div className="container mx-auto py-8">
      <h1 className="text-3xl font-bold">Dashboard</h1>
      <p>Welcome to your dashboard!</p>
    </div>
  );
};

Dashboard.layout = (page) => <AppLayout>{page}</AppLayout>;

export default Dashboard;
