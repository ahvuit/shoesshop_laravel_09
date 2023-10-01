<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SalesController extends Controller
{
    public function index()
    {
        try {
            $sales = Sales::all();
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Successfully',
                'data' => $sales,
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
            $sales = Sales::find($id);
            if (!$sales) {
                return response()->json([
                    'success' => false,
                    'status' => 404,
                    'message' => 'Cannot find sales',
                    'data' => null,
                ], Response::HTTP_NOT_FOUND);
            }
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Successfully',
                'data' => $sales,
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
            $findSales = Sales::where('salesName', $request->salesName)->first();
            if ($findSales) {
                return response()->json([
                    'success' => false,
                    'status' => 401,
                    'message' => 'sales name is already',
                    'data' => null,
                ], Response::HTTP_NOT_IMPLEMENTED);
            }
            $sales = Sales::create([
                'salesName' => $request->salesName,
                'content' => $request->content,
                'percent' => $request->percent,
                'startDay' => $request->startDay,
                'endDay' => $request->endDay,
                'banner' => $request->banner,
                'createDate' =>  now()->format('m/d/Y'),
            ]);
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Successfully',
                'data' => $sales,
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
            $sales = Sales::find($id);
            if (!$sales) {
                return response()->json([
                    'success' => false,
                    'status' => 404,
                    'message' => 'cannot find sales to update',
                    'data' => null,
                ], Response::HTTP_NOT_FOUND);
            }

            $sales->salesName = $request->salesName ?? $sales->salesName;
            $sales->content = $request->content ?? $sales->content;
            $sales->percent = $request->percent ?? $sales->percent;
            $sales->salesName = $request->salesName ?? $sales->salesName;
            $sales->startDay = $request->startDay ?? $sales->startDay;
            $sales->endDay = $request->endDay ?? $sales->endDay;
            $sales->banner = $request->banner ?? $sales->banner;
            $sales->save();

            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'sales updated successfully',
                'data' => $sales,
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
