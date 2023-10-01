<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Summary of ProfileController
 */
class ProfileController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['detail']]);
    // }
    public function detail($id)
    {
        try {
            $profile = Profile::where('userId', $id)->first();
            if (!$profile) {
                return response()->json([
                    'success' => false,
                    'status' => 404,
                    'message' => 'Cannot find profile',
                    'data' => null,
                ], Response::HTTP_NOT_FOUND);
            }
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Successfully',
                'data' => $profile,
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
            $profile = Profile::find($id);
            if (!$profile) {
                return response()->json([
                    'success' => false,
                    'status' => 404,
                    'message' => 'cannot find user to update',
                    'data' => null,
                ], Response::HTTP_NOT_FOUND);
            }
            $profile->firstName = $request->firstName ?? $profile->firstName;
            $profile->lastName = $request->lastName ?? $profile->lastName;
            $profile->address = $request->address ?? $profile->address;
            $profile->phone = $request->phone ?? $profile->phone;
            $profile->imageUrl = $request->imageUrl ?? $profile->imageUrl;
            $profile->save();
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Profile updated successfully',
                'data' => $profile,
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
