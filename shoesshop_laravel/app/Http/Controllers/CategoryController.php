<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $category = Category::all();
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Successfully',
                'data' => $category,
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'status' => 400,
                'message' => $exception->getMessage(),
                'data' => null,
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function detail($id)
    {
        try {
            $category = Category::find($id);
            if (!$category) {
                return response()->json([
                    'success' => false,
                    'status' => 401,
                    'message' => 'Cannot find category',
                    'data' => null,
                ], Response::HTTP_NOT_FOUND);
            }
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Successfully',
                'data' => $category,
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'status' => 400,
                'message' => $exception->getMessage(),
                'data' => null,
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function create(Request $request)
    {
        try {
            $findCategory = Category::where('categoryName', $request->categoryName)->first();

            if ($findCategory) {
                return response()->json([
                    'success' => false,
                    'status' => 404,
                    'message' => 'Category name is already',
                    'data' => null,
                ], Response::HTTP_NOT_IMPLEMENTED);
            }

            $category = Category::create(['categoryName' => $request->categoryName]);

            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Successfully',
                'data' => $category,
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'status' => 400,
                'message' => $exception->getMessage(),
                'data' => null,
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $category = Category::find($id);
            if (!$category) {
                return response()->json([
                    'success' => false,
                    'status' => 401,
                    'message' => 'cannot find category to update',
                    'data' => null,
                ], Response::HTTP_NOT_FOUND);
            }
            $category->categoryName = $request->categoryName ?? $category->categoryName;
            $category->save();
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'category updated successfully',
                'data' => $category,
            ], Response::HTTP_OK);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'status' => 400,
                'message' => $exception->getMessage(),
                'data' => null,
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
