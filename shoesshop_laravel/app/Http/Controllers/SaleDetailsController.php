<?php

namespace App\Http\Controllers;

use App\Models\SaleDetails;
use App\Models\Sales;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SaleDetailsController extends Controller
{
    public function detail($id)
    {
        try {
            $saledetails = SaleDetails::where('salesId', $id)->get();
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Successfully',
                'data' => $saledetails,
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
            $findSaleDetails = SaleDetails::where('productId', $request->productId)->first();
            $sales = Sales::find($request->salesId);
            $productId = Product::find($request->productId);
            if ($findSaleDetails) {
                return response()->json([
                    'success' => false,
                    'status' => 401,
                    'message' => 'The product already exists in another promotion',
                    'data' => null,
                ], Response::HTTP_NOT_IMPLEMENTED);
            }
            $saleDetails = SaleDetails::create([
                'salesId' => $request->salesId,
                'productId' => $request->productId,
                'salePrice' => $request->salePrice,
                'updateBy' => $request->updateBy,
            ]);
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Successfully',
                'data' => $saleDetails,
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

    public function delete($id)
    {
        try {
            $findSaleDetails = SaleDetails::where('productId', $id)->first();
            if($findSaleDetails){
                $findSaleDetails->delete();
                return response()->json([
                    'success' => true,
                    'status' => 200,
                    'message' => 'Successfully',
                    'data' => null,
                ], Response::HTTP_OK);
            }
            else{
                return response()->json([
                    'success' => false,
                    'status' => 404,
                    'message' => 'cannot find sales details to delete',
                    'data' => null,
                ], Response::HTTP_NOT_FOUND);
            }

        }catch(ModelNotFoundException $exception){
            return response()->json([
                'success' => false,
                'status' => 400,
                'message' => $exception->getMessage(),
                'data' => null,
            ], Response::HTTP_BAD_REQUEST);
        }


    }
}
