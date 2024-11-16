<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    //--dashboard_overview
    public function dashboard_overview()
    {
        $totalProducts = Product::count();
        $totalcategories = Category::count();
        $products = Product::latest()->take(10)->with('category')->get();
        return response()->json([
            'products' => $products,
            'totalProducts' => $totalProducts,
            'totalcategories' => $totalcategories,
            'usersTotal' => User::count()
        ]);
    }

    //--getProducts
    public function getProducts()
    {
        $products = Product::select('id', 'name', 'slug', 'stock_quantity', 'price')->latest()->get();
        return response()->json($products);
    }

    //--index
    public function index(Request $request)
    {
        $search = $request->search;
        $products = Product::query();
        if ($search) {
            $products = $products->where('name', 'like', "%{$search}%");
        }
        $products = $products->latest()->paginate(10);
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
            'description' => 'required|string',
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
                $newImageName = uniqid() . '_' . $slug . '.' . 'webp';

                //-- iamge resize and webp format convert
                list($width, $height) = getimagesize($product_image);
                $new_width = 600;
                $new_height = 600;
                $image_p = imagecreatetruecolor($new_width, $new_height);
                $imageformat = imagecreatefromstring(file_get_contents($product_image));
                if ($imageformat === false) {
                    return response()->json(['error' => 'Invalid image file'], 400);
                }
                imagecopyresampled($image_p, $imageformat, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                $path = 'admin/product/' . $newImageName;
                $destinationPath = storage_path('app/public/' . $path);
                if (!is_dir(dirname($destinationPath))) {
                    mkdir(dirname($destinationPath), 0755, true);
                }
                imagewebp($image_p, $destinationPath);
                imagedestroy($imageformat);
                imagedestroy($image_p);
            }

            // Create product
            $product = new Product();
            $product->name = $request->name;
            $product->slug = $slug;
            $product->category_id = $request->category;
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

    //--edit
    public function edit($slug)
    {
        $product = Product::where('slug', $slug)->first();
        if ($product) {
            return new ProductResource($product);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "This product is not found in our records.",
            ]);
        }
    }

    //--update
    public function update(Request $request, $slug)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'description' => 'required|string',
            'size' => 'nullable|string',
            'weight' => 'nullable|string',
            'packageType' => 'nullable|string',
            'product_image' => 'nullable|image|mimes:jpeg,webp,png,jpg,gif,svg|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ]);
        } else {
            $product = Product::where('slug', $slug)->first();

            if ($product) {
                $product->name = $request->name ?? $product->name;
                if ($request->has('name')) {
                    $product->slug = Str::slug($request->name);
                }
                $product->category_id = $request->category ?? $product->category_id;
                $product->price = $request->price ?? $product->price;
                $product->stock_quantity = $request->quantity ?? $product->stock_quantity;
                $product->description = $request->description ?? $product->description;
                $product->size = $request->size ?? $product->size;
                $product->weight = $request->weight ?? $product->weight;
                $product->packageType = $request->packageType ?? $product->packageType;
                $product->meta_title = $request->meta_title ?? $product->meta_title;
                $product->meta_description = $request->meta_description ?? $product->meta_description;
                $product->isFeatured = $request->isFeatured ?? $product->isFeatured;

                $path = null;
                if ($request->hasFile('product_image')) {
                    //--old image delete
                    $old_image = $product->product_image;
                    if ($old_image && Storage::disk('public')->exists($old_image)) {
                        Storage::disk('public')->delete($old_image);
                    }
                    $product_image = $request->file('product_image');
                    $newImageName = uniqid() . 'update_' . $slug . '.' . 'webp';


                    //-- iamge resize and webp format convert
                    list($width, $height) = getimagesize($product_image);
                    $new_width = 350;
                    $new_height = 350;
                    $image_p = imagecreatetruecolor($new_width, $new_height);
                    $imageformat = imagecreatefromstring(file_get_contents($product_image));
                    if ($imageformat === false) {
                        return response()->json(['error' => 'Invalid image file'], 400);
                    }
                    imagecopyresampled($image_p, $imageformat, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                    $path = 'admin/product/' . $newImageName;
                    $destinationPath = storage_path('app/public/' . $path);
                    if (!is_dir(dirname($destinationPath))) {
                        mkdir(dirname($destinationPath), 0755, true);
                    }
                    imagewebp($image_p, $destinationPath);
                    imagedestroy($imageformat);
                    imagedestroy($image_p);
                    $product->product_image = $path;
                }

                if ($product->save()) {
                    return response()->json([
                        'status' => 200,
                        'product' => $product,
                        'message' => 'Product Updated Successfully',
                    ]);
                } else {
                    return response()->json([
                        'status' => 500,
                        'message' => 'Failed to Updated Product'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => "This product is not found in our records.",
                ]);
            }
        }
    }

    //--delete---
    public function delete($slug)
    {
        $product = Product::where('slug', $slug)->first();
        if ($product) {
            $old_image = $product->product_image;
            if ($old_image && Storage::disk('public')->exists($old_image)) {
                Storage::disk('public')->delete($old_image);
            }
            $product->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Product Deleted Successfully'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "This product is not found in our records.",
            ]);
        }
    }
}
