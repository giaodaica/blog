<?php

namespace App\Traits;

use App\Models\Products;
use Illuminate\Database\Eloquent\Builder;

trait ProductFilterTrait
{
    /**
     * Apply filters and sorting to product query
     */
    protected function applyProductFilters(Builder $query, array $filters = []): Builder
    {
        // Base query with relationships
        $query->with(['category', 'variants.color', 'variants.size'])
            ->whereHas('category', function ($query) {
                $query->where('status', '1')
                      ->whereNull('categories.deleted_at');
            })
            ->whereHas('variants', function ($query) {
                $query->where('is_show', 1)
                      ->where('stock', '>', 0)
                      ->whereNull('product_variants.deleted_at');
            })
            ->whereNull('products.deleted_at');

        // Apply search filter
        if (!empty($filters['search'])) {
            $query->where('name', 'LIKE', "%{$filters['search']}%");
        }

        // Apply category filter
        if (!empty($filters['categories'])) {
            $query->whereIn('category_id', $filters['categories']);
        }

        // Apply color filter
        if (!empty($filters['colors'])) {
            $query->whereHas('variants', function ($q) use ($filters) {
                $q->whereIn('color_id', $filters['colors']);
            });
        }

        // Apply size filter
        if (!empty($filters['sizes'])) {
            $query->whereHas('variants', function ($q) use ($filters) {
                $q->whereIn('size_id', $filters['sizes']);
            });
        }

        // Apply price range filter
        if (!empty($filters['price_range']) && str_contains($filters['price_range'], '-')) {
            [$min, $max] = explode('-', $filters['price_range']);
            $query->whereHas('variants', function ($q) use ($min, $max) {
                $q->whereBetween('sale_price', [(int)$min, (int)$max]);
            });
        }

        // Apply sorting
        $sort = $filters['sort'] ?? 'default';
        switch ($sort) {
            case 'price_asc':
                $query->join('product_variants', 'products.id', '=', 'product_variants.product_id')
                      ->where('product_variants.is_show', 1)
                      ->where('product_variants.stock', '>', 0)
                      ->whereNull('product_variants.deleted_at')
                      ->select('products.*', 'product_variants.sale_price')
                      ->orderBy('product_variants.sale_price', 'asc')
                      ->distinct();
                break;
            case 'price_desc':
                $query->join('product_variants', 'products.id', '=', 'product_variants.product_id')
                      ->where('product_variants.is_show', 1)
                      ->where('product_variants.stock', '>', 0)
                      ->whereNull('product_variants.deleted_at')
                      ->select('products.*', 'product_variants.sale_price')
                      ->orderBy('product_variants.sale_price', 'desc')
                      ->distinct();
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        return $query;
    }

    /**
     * Get filtered products with pagination
     */
    protected function getFilteredProducts(array $filters = [], int $perPage = 5)
    {
        $query = Products::query();
        $this->applyProductFilters($query, $filters);
        return $query->paginate($perPage);
    }
}