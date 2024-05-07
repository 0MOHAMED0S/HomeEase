<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\categorie as ModelsCategorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Categorie extends Controller
{
    public function store(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:25',
                'path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return response()->json([
                    'status' => 422,
                    'message' => 'Validation error',
                    'errors' => $errors
                ], 422);
            }

             // Process profile image
            $path = $request->file('path')->store('CategoryImages');

            $categorie = new ModelsCategorie;
            $categorie->name = $request->name;
            $categorie->path = $path;
            $categorie->save();

            return response()->json([
                'status' => 200,
                'message' => 'Request successfully sent to the admin',
                'image_path' => $categorie
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function edit($id) {
        try {
            $categorie = ModelsCategorie::findOrFail($id);

            return response()->json([
                'status' => 200,
                'data' => $categorie,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 404,
                'message' => 'Category not found',
            ], 404);
        }
    }

    public function update(Request $request, $id) {
        try {
            $categorie = ModelsCategorie::findOrFail($id);
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:25',
                'path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();
                return response()->json([
                    'status' => 422,
                    'message' => 'Validation error',
                    'errors' => $errors
                ], 422);
            }

            $image = $request->file('path');
            $imageName = $image->getClientOriginalName();
            $path = $image->storeAs('CategoryImages', $imageName, 'public');

            $categorie->name = $request->name;
            $categorie->path = $path;
            $categorie->save();

            return response()->json([
                'status' => 200,
                'message' => 'Category successfully updated',
                'image_path' => $categorie
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 404,
                'message' => 'Category not found',
            ], 404);
        }
    }


    public function delete($id) {
        try {
            $categorie = ModelsCategorie::findOrFail($id);
            $categorie->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Category successfully deleted',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 404,
                'message' => 'Category not found',
            ], 404);
        }
    }

    public function AllCategories(){
        try {
            $categories = ModelsCategorie::all();

            return response()->json([
                'status' => 200,
                'message' => 'All categories retrieved successfully',
                'categories' => $categories
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
