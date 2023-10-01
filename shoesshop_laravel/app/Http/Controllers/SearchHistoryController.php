<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\SearchHistory;
use App\Models\Product;
use Illuminate\Http\Response;

class SearchHistoryController extends Controller
{
    public function insertOrUpdateKeyword(Request $request)
    {
        try {
            $searchHistory = SearchHistory::where('userId', $request->userId)->first();

            if ($searchHistory) {
                $searchHistory->keyword = $request->keyword ?? $searchHistory->keyword;
                $searchHistory->save();
                return response()->json([
                    'success' => true,
                    'status' => 200,
                    'message' => 'Successfully',
                    'data' => $searchHistory,
                ], Response::HTTP_OK);
            } else {
                $searchHistory = SearchHistory::create([
                    'userId' => $request->userId,
                    'keyword' => $request->keyword,
                ]);
                return response()->json([
                    'success' => true,
                    'status' => 200,
                    'message' => 'Successfully',
                    'data' => $searchHistory,
                ], Response::HTTP_OK);
            }
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
            $searchHistory = SearchHistory::where('userId', $id)->first();
            $products = Product::all();
            $array = array();
            if ($searchHistory) {
                foreach ($products as $value) {
                    if (str_contains(strtoupper($value->name), strtoupper($searchHistory->keyword))) {
                        $array[] = $value;
                    }
                }
                return response()->json([
                    'success' => true,
                    'status' => 200,
                    'message' => 'Successfully',
                    'data' => $array,
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'success' => true,
                    'status' => 200,
                    'message' => 'Successfully',
                    'data' => $products,
                ], Response::HTTP_OK);
            }
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
