<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store($postId, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "content" => "required|string"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Bad request",
                "errors" => $validator->errors(),
            ], 400);
        }

        $post = Post::find($postId);
        if (!$post) {
            return response()->json([
                "message" => "Post not found"
            ], 404);
        }

        $comment = $post->comments()
            ->create(['content' => $request->content, 'user_id' => auth()->id()]);
        return response()->json($comment, 201);
    }

    public function like($id)
    {

        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json([
                "message" => "Comment not found"
            ], 404);
        }

        $existingLike = Like::where("likeable_id", $id)
            ->where("likeable_type", Comment::class)
            ->where("user_id", auth()->id())->first();

        if ($existingLike) {
            return response()->json([
                "message" => "You have already liked this comment"
            ], 400);
        }

        $comment->likes()->create(['user_id' => auth()->id()]);

        return response()->json(['message' => 'Comement liked'], 201);
    }
}
