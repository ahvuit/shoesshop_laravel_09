<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['login', 'register']]);
    // }

    public function index()
    {
        try {
            $users = User::all();
            foreach ($users as $element) {
                $profile = Profile::where('userId', $element->id)->first();
                $element->profile = $profile;
            }
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Successfully',
                'data' => $users,
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
            $user = User::find($id);
            $profile = Profile::where('userId', $user->id)->first();
            $user->profile = $profile;
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'status' => 401,
                    'message' => 'Cannot find user',
                    'data' => null,
                ], Response::HTTP_NOT_FOUND);
            }
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Successfully',
                'data' => $user,
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

    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $user = User::where('email', $request->email)->first();
                $profile = Profile::where('userId', $user->id)->first();
                $user->profile = $profile;
                //$token = $user->createToken('authToken')->plainTextToken;
                //$user->token = $token;
                return response()->json([
                    'success' => true,
                    'status' => 200,
                    'message' => 'Successfully',
                    'data' => $user,
                ], Response::HTTP_OK);
            } else {
                return response()->json([
                    'success' => false,
                    'status' => 404,
                    'message' => 'Invalid login credentials',
                    'data' => null,
                ], Response::HTTP_NOT_FOUND);
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

    public function register(Request $request)
    {
        try {

            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'utype' => 'USR',
                'active' => true,
            ]);

            $profile = Profile::create([
                'userId' => $user->id,
                'imageUrl' => 'https://cdn-icons-png.flaticon.com/512/6386/6386976.png',
            ]);

            $user->profile = $profile;

            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'User created successfully',
                'data' => $user,
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
            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'status' => 404,
                    'message' => 'cannot find user to update',
                    'data' => null,
                ], Response::HTTP_NOT_FOUND);
            }
            $user->password = Hash::make($request->password) ?? $user->password;
            $user->utype = $request->utype ?? $user->utype;
            $user->active = $request->active ?? $user->active;
            $user->save();
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'User created successfully',
                'data' => $user,
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

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'success' => true,
            'status' => 200,
            'message' => 'Successfully logged out',
            'data' => null,
        ], Response::HTTP_OK);
    }
}
