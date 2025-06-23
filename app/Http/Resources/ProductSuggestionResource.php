<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductSuggestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $price = number_format($this->price) . 'đ';
        $oldPrice = $this->old_price ? number_format($this->old_price) . 'đ' : null;

        $discount = null;
        if ($this->old_price && $this->old_price > $this->price) {
            $discount = '-' . round(($this->old_price - $this->price) / $this->old_price * 100) . '%';
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => asset($this->image),
            'price' => $price,
            'old_price' => $oldPrice,
            'discount' => $discount,
        ];
    }
}
