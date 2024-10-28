<?php
namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function list()
    {
        $posts = auth()->user()->posts;

        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title" => "required|string",
            "content" => "required|string"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Bad request",
                "errors" => $validator->errors(),
            ], 400);
        }

        $post = auth()->user()->posts()->create($request->all());

        return response()->json($post, 201);
    }
    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title" => "required|string",
            "content" => "required|string"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Bad request",
                "errors" => $validator->errors(),
            ], 400);
        }

        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                "message" => "Post not found"
            ], 404);
        }

        if ($post->user_id != auth()->id()) {
            return response()->json([
                "message" => "You can only update the post that you have created"
            ], 403);
        }

        $post->update($request->all());

        return response()->json($post, 200);
    }

    public function delete($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                "message" => "Post not found"
            ], 404);
        }
         
        if ($post->user_id != auth()->id()) {
            return response()->json([
                "message" => "You can only delete the post that you have created"
            ], 403);
        }

        $post->delete();

        return response()->json(['message' => 'Post deleted'], 200);
    }

    public function like($id)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json([
                "message" => "Post not found"
            ], 404);
        }


        $existingLike = Like::where("likeable_id", $id)
            ->where("likeable_type", Post::class)
            ->where("user_id", auth()->id())->first();

        if ($existingLike) {
            return response()->json([
                "message" => "You have already liked this post"
            ], 400);
        }


        $post->likes()->create(['user_id' => auth()->id()]);

        return response()->json(['message' => 'Post liked'], 201);
    }

    public function commentedPosts()
    {
        $posts = Post::whereHas('comments', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();

        return response()->json($posts, 200);
    }
    public function likedPosts()
    {
        $posts = Post::whereHas('likes', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();

        return response()->json($posts, 200);
    }
}