import { useState, useEffect, useCallback } from "react";
import { Header } from "@/components/Header";
import { ClothingCard } from "@/components/ClothingCard";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Badge } from "@/components/ui/badge";
import { clothingItemService, categoryService } from "@/lib/api";
import type { ClothingItem, Category } from "@/lib/api/types";
import { useToast } from "@/hooks/use-toast";
import { Loader2, Search, Filter } from "lucide-react";

interface WardrobeProps {
  onLogout: () => void;
  isDemoMode?: boolean;
}

export const Wardrobe = ({ onLogout }: WardrobeProps) => {
  const [items, setItems] = useState<ClothingItem[]>([]);
  const [categories, setCategories] = useState<Category[]>([]);
  const [isLoading, setIsLoading] = useState(true);
  const [searchQuery, setSearchQuery] = useState("");
  const [selectedCategory, setSelectedCategory] = useState<number | null>(null);
  const { toast } = useToast();

  const fetchData = useCallback(async () => {
    try {
      const [itemsData, categoriesData] = await Promise.all([
        clothingItemService.getAll(),
        categoryService.getAll(),
      ]);
      console.log('✅ Fetched items:', itemsData);
      console.log('✅ Fetched categories:', categoriesData);
      setItems(itemsData);
      setCategories(categoriesData);
    } catch (error) {
      console.error('❌ Error fetching data:', error);
      toast({
        title: "Error loading wardrobe",
        description: error instanceof Error ? error.message : "Please try again",
        variant: "destructive",
      });
    } finally {
      setIsLoading(false);
    }
  }, [toast]);

  useEffect(() => {
    fetchData();
  }, [fetchData]);

  const handleDelete = async (id: number) => {
    try {
      await clothingItemService.delete(id);
      setItems(items.filter((item) => item.id !== id));
      toast({
        title: "Item deleted",
        description: "The item has been removed from your wardrobe.",
      });
    } catch (error) {
      toast({
        title: "Error deleting item",
        description: error instanceof Error ? error.message : "Please try again",
        variant: "destructive",
      });
    }
  };

  const filteredItems = items.filter((item) => {
    const matchesSearch = item.name.toLowerCase().includes(searchQuery.toLowerCase()) ||
      item.brand?.toLowerCase().includes(searchQuery.toLowerCase());
    const matchesCategory = !selectedCategory || item.category_id === selectedCategory;
    return matchesSearch && matchesCategory;
  });

  if (isLoading) {
    return (
      <div className="min-h-screen flex items-center justify-center">
        <Loader2 className="h-8 w-8 animate-spin text-accent" />
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-background">
      <Header onLogout={onLogout} />
      
      <main className="container mx-auto px-6 py-8">
        {/* Search and Filter Bar */}
        <div className="mb-8 space-y-4">
          <div className="flex flex-col md:flex-row gap-4">
            <div className="relative flex-1">
              <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 h-4 w-4 text-muted-foreground" />
              <Input
                type="search"
                placeholder="Search your wardrobe..."
                className="pl-10"
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
              />
            </div>
            <Button variant="outline" size="default">
              <Filter className="mr-2 h-4 w-4" />
              Filters
            </Button>
          </div>

          {/* Category Filter */}
          <div className="flex flex-wrap gap-2">
            <Badge
              variant={selectedCategory === null ? "default" : "outline"}
              className="cursor-pointer"
              onClick={() => setSelectedCategory(null)}
            >
              All Items
            </Badge>
            {categories.map((category) => (
              <Badge
                key={category.id}
                variant={selectedCategory === category.id ? "default" : "outline"}
                className="cursor-pointer"
                onClick={() => setSelectedCategory(category.id)}
              >
                {category.title}
              </Badge>
            ))}
          </div>
        </div>

        {/* Items Grid */}
        {filteredItems.length === 0 ? (
          <div className="text-center py-20">
            <h3 className="text-2xl font-semibold mb-2">No items found</h3>
            <p className="text-muted-foreground mb-6">
              {searchQuery || selectedCategory
                ? "Try adjusting your filters"
                : "Start building your wardrobe"}
            </p>
            <Button variant="elegant">Add Your First Item</Button>
          </div>
        ) : (
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            {filteredItems.map((item) => (
              <ClothingCard
                key={item.id}
                item={item}
                category={categories.find((c) => c.id === item.category_id)}
                onDelete={handleDelete}
              />
            ))}
          </div>
        )}
      </main>
    </div>
  );
};

export default Wardrobe;
