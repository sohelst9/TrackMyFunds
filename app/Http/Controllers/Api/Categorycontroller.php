<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Categorycontroller extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
       $categories = Category::query();
       if($search){
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

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ]);
        }else{
            $slug = Str::slug($request->name);
            $path = null;
            if($request->hasFile('image')){
                $image = $request->file('image');
                $imageName = uniqid().'_'.$slug.'.'.$image->getClientOriginalExtension();
                $path = 'admin/category/'.$imageName;
                $image->move(public_path('admin/category'), $imageName);
            }
            $category  = new Category();
            $category->name = $request->name;
            $category->slug = $slug;
            $category->description = $request->description;
            $category->image = $path;
            $category->meta_title = $request->meta_title;
            $category->meta_description = $request->meta_description;
            if($category->save()){
                return response()->json([
                    'status' => 200,
                    'category' => $category,
                    'message' => "Category created Successfully"
                ]);
            }else{
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
         if($category){
            return new CategoryResource($category);
         }else{
            return response()->json([
                'status' => 404,
                'message' => "This category is not found in our records.",
            ]);
         }
    }

    

    public function update(Request $request, string $id)
    {
        // Update the specified resource in storage.
    }

    public function destroy(string $id)
    {
        // Remove the specified resource from storage.
    }
}
