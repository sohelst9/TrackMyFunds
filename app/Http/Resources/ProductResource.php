<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'category_id' => $this->category_id,
            'category_name' => $this->category ? $this->category->name : null,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'stock_quantity' => $this->stock_quantity,
            'description' => $this->description,
            'size' => $this->size,
            'weight' => $this->weight,
            'packageType' => $this->packageType,
            'product_image' => $this->product_image,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'isFeatured' => $this->isFeatured,
            'created_at' => $this->created_at->format('Y-m-d'),
            'updated_at' => $this->updated_at->format('Y-m-d'),
        ];
    }
}
