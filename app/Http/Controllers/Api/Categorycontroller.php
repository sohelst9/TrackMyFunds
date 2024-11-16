<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Categorycontroller extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categories = Category::query();
        if ($search) {
            $categories = $categories->where('name', 'like', "%$search%");
        }
        $categories = $categories->latest()->paginate(12);
        return CategoryResource::collection($categories);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg,webp',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ]);
        } else {
            $slug = Str::slug($request->name);
            $path = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = uniqid() . '_' . $slug . '.' . 'webp';

                //-- iamge resize and webp format convert
                list($width, $height) = getimagesize($image);
                $new_width = 350;
                $new_height = 350;
                $image_p = imagecreatetruecolor($new_width, $new_height);
                $imageformat = imagecreatefromstring(file_get_contents($image));
                if ($imageformat === false) {
                    return response()->json(['error' => 'Invalid image file'], 400);
                }
                imagecopyresampled($image_p, $imageformat, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                $path = 'admin/category/' . $imageName;
                $destinationPath = storage_path('app/public/' . $path);
                if (!is_dir(dirname($destinationPath))) {
                    mkdir(dirname($destinationPath), 0755, true);
                }
                imagewebp($image_p, $destinationPath);
                imagedestroy($imageformat);
                imagedestroy($image_p);
            }
            $category  = new Category();
            $category->name = $request->name;
            $category->slug = $slug;
            $category->description = $request->description;
            $category->image = $path;
            $category->meta_title = $request->meta_title;
            $category->meta_description = $request->meta_description;
            if ($category->save()) {
                return response()->json([
                    'status' => 200,
                    'category' => $category,
                    'message' => "Category created Successfully"
                ]);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Failed to Create Category'
                ]);
            }
        }
    }

    public function show(string $slug)
    {
        $category = Category::where('slug', $slug)->first();
        if ($category) {
            return new CategoryResource($category);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "This category is not found in our records.",
            ]);
        }
    }



    public function update(Request $request, string $slug)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'product_image' => 'nullable|image|mimes:jpeg,webp,png,jpg,gif,svg|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ]);
        } else {
            $category = Category::where('slug', $slug)->first();
            if ($category) {
                $category->name = $request->name ?? $category->name;
                if ($request->has('name')) {
                    $category->slug = Str::slug($request->name);
                }
                $category->description = $request->description ?? $category->description;
                $category->meta_title = $request->meta_title ?? $category->meta_title;
                $category->meta_description = $request->meta_description ?? $category->meta_description;

                $path = null;
                if ($request->hasFile('image')) {
                    //--old image delete
                    $oldImage = $category->image;
                    if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                        Storage::disk('public')->delete($oldImage);
                    }
                    $cate_image = $request->file('image');
                    $newImageName = uniqid() . 'update_' . $slug . '.' . 'webp';
                    //-- iamge resize and webp format convert
                    list($width, $height) = getimagesize($cate_image);
                    $new_width = 350;
                    $new_height = 350;
                    $image_p = imagecreatetruecolor($new_width, $new_height);
                    $imageformat = imagecreatefromstring(file_get_contents($cate_image));
                    if ($imageformat === false) {
                        return response()->json(['error' => 'Invalid image file'], 400);
                    }
                    imagecopyresampled($image_p, $imageformat, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                    $path = 'admin/category/' . $newImageName;
                    $destinationPath = storage_path('app/public/' . $path);
                    if (!is_dir(dirname($destinationPath))) {
                        mkdir(dirname($destinationPath), 0755, true);
                    }
                    imagewebp($image_p, $destinationPath);
                    imagedestroy($imageformat);
                    imagedestroy($image_p);
                    $category->image = $path;
                }

                if ($category->save()) {
                    return response()->json([
                        'status' => 200,
                        'category' => $category,
                        'message' => 'Category Updated Successfully',
                    ]);
                } else {
                    return response()->json([
                        'status' => 500,
                        'message' => 'Failed to Updated Category'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => "This Category is not found in our records.",
                ]);
            }
        }
    }

    public function destroy(string $slug)
    {
        $category = Category::where('slug', $slug)->first();
        if ($category) {
            $old_image = $category->image;
            if ($old_image && Storage::disk('public')->exists($old_image)) {
                Storage::disk('public')->delete($old_image);
            }
            $category->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Category Deleted Successfully'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "This Category is not found in our records.",
            ]);
        }
    }
}
