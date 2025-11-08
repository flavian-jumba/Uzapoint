import { Button } from "@/components/ui/button";
import { LogOut, Menu, Search, Plus } from "lucide-react";

interface HeaderProps {
  onLogout?: () => void;
  onAddItem?: () => void;
  onSearch?: (query: string) => void;
}

export const Header = ({ onLogout, onAddItem, onSearch }: HeaderProps) => {
  return (
    <header className="border-b border-border bg-card sticky top-0 z-50 elegant-shadow">
      <div className="container mx-auto px-6 py-4">
        <div className="flex items-center justify-between">
          <div className="flex items-center gap-8">
            <h1 className="text-3xl font-bold tracking-tight">Armoire</h1>
            <nav className="hidden md:flex items-center gap-6">
              <a href="#wardrobe" className="text-sm font-medium hover:text-accent transition-elegant">
                Wardrobe
              </a>
              <a href="#outfits" className="text-sm font-medium hover:text-accent transition-elegant">
                Outfits
              </a>
              <a href="#categories" className="text-sm font-medium hover:text-accent transition-elegant">
                Categories
              </a>
            </nav>
          </div>
          
          <div className="flex items-center gap-3">
            <Button variant="ghost" size="icon" className="hidden md:inline-flex">
              <Search className="h-5 w-5" />
            </Button>
            {onAddItem && (
              <Button variant="elegant" size="sm" onClick={onAddItem} className="hidden md:inline-flex">
                <Plus className="h-4 w-4" />
                Add Item
              </Button>
            )}
            {onLogout && (
              <Button variant="ghost" size="icon" onClick={onLogout}>
                <LogOut className="h-5 w-5" />
              </Button>
            )}
            <Button variant="ghost" size="icon" className="md:hidden">
              <Menu className="h-5 w-5" />
            </Button>
          </div>
        </div>
      </div>
    </header>
  );
};
