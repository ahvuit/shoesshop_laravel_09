<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Comment;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['index']]);
    // }

    public function index($id)
    {
        try {
            $comment = Comment::where('productId', $id)->first();
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Successfully',
                'data' => $comment,
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
            $comment = Comment::create([
                'productId' => $request->productId,
                'userId' => $request->userId,
                'content' => $request->content,
                'image' => $request->image,
                'createDate' => now()->format('Y-m-d H:i:s'),
            ]);
            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Successfully',
                'data' => $comment,
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
