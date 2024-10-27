<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function show()
    {
        $user = auth()->user();

        return response()->json($user->profile());
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:255",
            "email" => "required|string|email|max:255"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Bad request",
                "errors" => $validator->errors(),
            ], 400);
        }

        $authUser = auth()->user();
        if ($request->email != $authUser->getEmail() && User::where("email", $request->email)->first()) {
            return response()->json([
                "message" => "Bad request",
                "errors" => "Email is already taken",
            ], 400);

        }
        $authUser->update($request->all());
        return response()->json($authUser->profile(), 200);
    }

    public function delete()
    {
        $authUser = auth()->user();
        $authUser->tokens()->delete();

        $authUser->update([
            "deleted_at" => new \DateTime()
        ]);

        return response()->json(['message' => 'Profile deleted'], 200);
    }
}