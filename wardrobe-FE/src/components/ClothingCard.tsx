import { Card } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { Button } from "@/components/ui/button";
import { Edit, Trash2, Tag } from "lucide-react";
import type { ClothingItem, Category } from "@/lib/api";

interface ClothingCardProps {
  item: ClothingItem;
  category?: Category;
  onEdit?: (item: ClothingItem) => void;
  onDelete?: (id: number) => void;
}

export const ClothingCard = ({ item, category, onEdit, onDelete }: ClothingCardProps) => {
  return (
    <Card className="overflow-hidden group hover:shadow-lg transition-elegant bg-card">
      <div className="aspect-[3/4] overflow-hidden bg-muted relative">
        {item.image ? (
          <img
            src={item.image}
            alt={item.name}
            className="w-full h-full object-cover group-hover:scale-105 transition-elegant"
          />
        ) : (
          <div className="w-full h-full flex items-center justify-center text-muted-foreground">
            <Tag className="h-16 w-16" />
          </div>
        )}
        <div className="absolute top-3 right-3 opacity-0 group-hover:opacity-100 transition-elegant flex gap-2">
          {onEdit && (
            <Button
              size="icon"
              variant="secondary"
              className="h-8 w-8 elegant-shadow"
              onClick={() => onEdit(item)}
            >
              <Edit className="h-4 w-4" />
            </Button>
          )}
          {onDelete && (
            <Button
              size="icon"
              variant="destructive"
              className="h-8 w-8 elegant-shadow"
              onClick={() => onDelete(item.id)}
            >
              <Trash2 className="h-4 w-4" />
            </Button>
          )}
        </div>
      </div>
      <div className="p-4">
        <div className="flex items-start justify-between gap-2 mb-2">
          <h3 className="font-semibold text-lg leading-tight">{item.name}</h3>
          {category && (
            <Badge variant="secondary" className="shrink-0">
              {category.title}
            </Badge>
          )}
        </div>
        {item.brand && (
          <p className="text-sm text-muted-foreground mb-1">{item.brand}</p>
        )}
        {item.color && (
          <div className="flex items-center gap-2 mt-2">
            <div
              className="h-4 w-4 rounded-full border border-border"
              style={{ backgroundColor: item.color }}
            />
            <span className="text-xs text-muted-foreground capitalize">{item.color}</span>
          </div>
        )}
      </div>
    </Card>
  );
};
