<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SizeTable;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;


class SizeTableController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['getSizeTableDetails']]);
    // }

    public function index()
    {
        try {
            $sizeTable = SizeTable::all();
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Successfully',
                'data' => $sizeTable,
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
            $sizeTable = SizeTable::where('productId', $id)->first();
            if (!$sizeTable) {
                return response()->json([
                    'success' => false,
                    'status' => 404,
                    'message' => 'Cannot find sizeTable',
                    'data' => null,
                ], Response::HTTP_NOT_FOUND);
            }
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Successfully',
                'data' => $sizeTable,
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
            $sizeTable = SizeTable::find($id);
            if (!$sizeTable) {
                return response()->json([
                    'success' => false,
                    'status' => 404,
                    'message' => 'Cannot find sizeTable',
                    'data' => null,
                ], Response::HTTP_NOT_FOUND);
            }
            $sizeTable->s38 = $request->s38 ?? $sizeTable->s38;
            $sizeTable->s39 = $request->s39 ?? $sizeTable->s39;
            $sizeTable->s40 = $request->s40 ?? $sizeTable->s40;
            $sizeTable->s41 = $request->s41 ?? $sizeTable->s41;
            $sizeTable->s42 = $request->s42 ?? $sizeTable->s42;
            $sizeTable->s43 = $request->s43 ?? $sizeTable->s43;
            $sizeTable->s44 = $request->s44 ?? $sizeTable->s44;
            $sizeTable->s45 = $request->s45 ?? $sizeTable->s45;
            $sizeTable->s46 = $request->s46 ?? $sizeTable->s46;
            $sizeTable->s47 = $request->s47 ?? $sizeTable->s47;
            $sizeTable->s48 = $request->s48 ?? $sizeTable->s48;
            $sizeTable->save();

            $total = $sizeTable->s38 + $sizeTable->s39  + $sizeTable->s40  + $sizeTable->s41 + $sizeTable->s42 + $sizeTable->s43 + $sizeTable->s44 + $sizeTable->s45 + $sizeTable->s46 + $sizeTable->s47 + $sizeTable->s48;

            $product = Product::find($sizeTable->productId);
            $product->stock = $total;
            $product->save();

            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Successfully',
                'data' => $sizeTable,
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
