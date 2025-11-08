import Wardrobe from "./Wardrobe";
import { useAuth } from "@/hooks/useAuth";

const Index = () => {
  const { logout, loading } = useAuth();

  if (loading) {
    return (
      <div className="min-h-screen flex items-center justify-center bg-background">
        <div className="text-center">
          <h1 className="text-4xl font-bold mb-4">Armoire</h1>
          <p className="text-muted-foreground">Loading...</p>
        </div>
      </div>
    );
  }

  return <Wardrobe onLogout={logout} isDemoMode={false} />;
};

export default Index;
