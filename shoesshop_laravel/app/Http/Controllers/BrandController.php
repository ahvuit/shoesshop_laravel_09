<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['index']]);
    // }

    public function index()
    {
        try {
            $brand = Brand::all();
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Successfully',
                'data' => $brand,
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
            $brand = Brand::find($id);
            if (!$brand) {
                return response()->json([
                    'success' => false,
                    'status' => 404,
                    'message' => 'Cannot find Brand',
                    'data' => null,
                ], Response::HTTP_NOT_FOUND);
            }
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Successfully',
                'data' => $brand,
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
            $findBrand = Brand::where('brandName', $request->brandName)->first();
            if ($findBrand) {
                return response()->json([
                    'success' => false,
                    'status' => 401,
                    'message' => 'Brand name is already',
                    'data' => null,
                ], Response::HTTP_NOT_IMPLEMENTED);
            }
            $brand = Brand::create([
                'brandName' => $request->brandName,
                'information' => $request->information,
                'logo' => $request->logo,
            ]);
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Successfully',
                'data' => $brand,
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
            $findBrand = Brand::find($id);
            if (!$findBrand) {
                return response()->json([
                    'success' => false,
                    'status' => 404,
                    'message' => 'cannot find brand to update',
                    'data' => null,
                ], Response::HTTP_NOT_FOUND);
            }

            $findBrand->brandName = $request->brandName ?? $findBrand->brandName;
            $findBrand->information = $request->information ?? $findBrand->information;
            $findBrand->logo = $request->logo ?? $findBrand->logo;
            $findBrand->save();

            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'brand updated successfully',
                'data' => $findBrand,
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
