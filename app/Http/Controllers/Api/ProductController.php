<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    //--index
    public function index()
    {
        // $products = Product::latest()->paginate(5);
        $products = Product::latest()
            ->where('created_at', '>=', Carbon::now()->addDays(2))
            ->paginate(5);
        return ProductResource::collection($products);
    }
    //--store
    public function store(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'description' => 'nullable|string',
            'size' => 'nullable|string',
            'weight' => 'nullable|string',
            'packageType' => 'nullable|string',
            'product_image' => 'required|image|mimes:jpeg,webp,png,jpg,gif,svg|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ]);
        } else {
            // Generate slug
            $slug = Str::slug($request->name);

            // Handle product image upload
            $path = null;
            if ($request->hasFile('product_image')) {
                $product_image = $request->file('product_image');
                $newImageName = uniqid() . '_' . $slug . '.' . $product_image->getClientOriginalExtension();
                $path = 'admin/product/' . $newImageName;
                $product_image->move(public_path('admin/product'), $newImageName);
            }

            // Create product
            $product = new Product();
            $product->name = $request->name;
            $product->slug = $slug;
            $product->category = $request->category;
            $product->price = $request->price;
            $product->quantity = $request->quantity;
            $product->stock_quantity = $request->quantity;
            $product->description = $request->description;
            $product->size = $request->size;
            $product->weight = $request->weight;
            $product->packageType = $request->packageType;
            $product->product_image = $path;
            $product->meta_title = $request->meta_title;
            $product->meta_description = $request->meta_description;
            $product->isFeatured = $request->isFeatured;

            // Save product
            if ($product->save()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Product Created Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Failed to Create Product'
                ]);
            }
        }
    }
}
