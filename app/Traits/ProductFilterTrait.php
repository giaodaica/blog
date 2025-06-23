<?php

namespace App\Traits;

use App\Models\Categories;
use App\Models\Color;
use App\Models\Size;

trait ProductFilterTrait
{
    protected function getFilteredData($searchQuery = null, $selectedCategories = [], $selectedColors = [], $selectedSizes = [])
    {
        // Base query for colors
        $colorQuery = Color::whereHas('productVariants', function ($query) {
            $query->where('stock', '>', 0)
                  ->where('is_show', 1)
                  ->whereNull('deleted_at');
        });

        // Base query for sizes
        $sizeQuery = Size::whereHas('productVariants', function ($query) {
            $query->where('stock', '>', 0)
                  ->where('is_show', 1)
                  ->whereNull('deleted_at');
        });

        // Base query for categories - Chỉ lọc sản phẩm chưa bị xóa
        $categoryQuery = Categories::whereHas('products', function ($query) {
            $query->whereNull('deleted_at');
        });

        // If search query exists, filter by product name
        if ($searchQuery) {
            $colorQuery->whereHas('productVariants.product', function ($query) use ($searchQuery) {
                $query->where('name', 'LIKE', "%{$searchQuery}%")
                      ->whereNull('deleted_at');
            });

            $sizeQuery->whereHas('productVariants.product', function ($query) use ($searchQuery) {
                $query->where('name', 'LIKE', "%{$searchQuery}%")
                      ->whereNull('deleted_at');
            });
        }

        // Filter colors by selected categories and sizes
        if (!empty($selectedCategories)) {
            $colorQuery->whereHas('productVariants.product', function ($query) use ($selectedCategories) {
                $query->whereIn('category_id', $selectedCategories);
            });
        }
        if (!empty($selectedSizes)) {
            $colorQuery->whereHas('productVariants', function ($query) use ($selectedSizes) {
                $query->whereIn('size_id', $selectedSizes);
            });
        }

        // Filter sizes by selected categories and colors
        if (!empty($selectedCategories)) {
            $sizeQuery->whereHas('productVariants.product', function ($query) use ($selectedCategories) {
                $query->whereIn('category_id', $selectedCategories);
            });
        }
        if (!empty($selectedColors)) {
            $sizeQuery->whereHas('productVariants', function ($query) use ($selectedColors) {
                $query->whereIn('color_id', $selectedColors);
            });
        }

        // Filter categories by selected colors and sizes
        if (!empty($selectedColors)) {
            $categoryQuery->whereHas('products.variants', function ($query) use ($selectedColors) {
                $query->whereIn('color_id', $selectedColors);
            });
        }
        if (!empty($selectedSizes)) {
            $categoryQuery->whereHas('products.variants', function ($query) use ($selectedSizes) {
                $query->whereIn('size_id', $selectedSizes);
            });
        }

        // Get colors with their counts
        $colors = $colorQuery->withCount(['productVariants' => function ($query) use ($searchQuery, $selectedCategories, $selectedSizes) {
            $query->where('stock', '>', 0)
                  ->where('is_show', 1)
                  ->whereNull('deleted_at')
                  ->when($searchQuery, function ($q) use ($searchQuery) {
                      $q->whereHas('product', function ($q) use ($searchQuery) {
                          $q->where('name', 'LIKE', "%{$searchQuery}%")
                            ->whereNull('deleted_at');
                      });
                  })
                  ->when(!empty($selectedCategories), function ($q) use ($selectedCategories) {
                      $q->whereHas('product', function ($q) use ($selectedCategories) {
                          $q->whereIn('category_id', $selectedCategories);
                      });
                  })
                  ->when(!empty($selectedSizes), function ($q) use ($selectedSizes) {
                      $q->whereIn('size_id', $selectedSizes);
                  });
        }])->get();

        // Get sizes with their counts
        $sizes = $sizeQuery->withCount(['productVariants' => function ($query) use ($searchQuery, $selectedCategories, $selectedColors) {
            $query->where('stock', '>', 0)
                  ->where('is_show', 1)
                  ->whereNull('deleted_at')
                  ->when($searchQuery, function ($q) use ($searchQuery) {
                      $q->whereHas('product', function ($q) use ($searchQuery) {
                          $q->where('name', 'LIKE', "%{$searchQuery}%")
                            ->whereNull('deleted_at');
                      });
                  })
                  ->when(!empty($selectedCategories), function ($q) use ($selectedCategories) {
                      $q->whereHas('product', function ($q) use ($selectedCategories) {
                          $q->whereIn('category_id', $selectedCategories);
                      });
                  })
                  ->when(!empty($selectedColors), function ($q) use ($selectedColors) {
                      $q->whereIn('color_id', $selectedColors);
                  });
        }])->get();

        // Get categories with their counts
        $categories = $categoryQuery->withCount(['products' => function ($query) use ($searchQuery, $selectedColors, $selectedSizes) {
            $query->whereNull('deleted_at')
                  ->when($searchQuery, function ($q) use ($searchQuery) {
                      $q->where('name', 'LIKE', "%{$searchQuery}%");
                  })
                  ->when(!empty($selectedColors), function ($q) use ($selectedColors) {
                      $q->whereHas('variants', function ($q) use ($selectedColors) {
                          $q->whereIn('color_id', $selectedColors);
                      });
                  })
                  ->when(!empty($selectedSizes), function ($q) use ($selectedSizes) {
                      $q->whereHas('variants', function ($q) use ($selectedSizes) {
                          $q->whereIn('size_id', $selectedSizes);
                      });
                  });
        }])->get();

        return [
            'categories' => $categories,
            'colors' => $colors,
            'sizes' => $sizes
        ];
    }
} 