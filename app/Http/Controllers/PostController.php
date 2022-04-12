<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Website;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->json()->all(), [
            'title'       => 'required',
            'description' => 'required',
            'website_id'  => 'required',
        ]);
        $post = Post::create($request->all());
        if ($post) {
            return response()->json([
                'message' => 'success'
            ]);
        } else {
            return response()->json([
                'error' => 'could not create post',
            ], 400);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function userSubscribe(Request $request): JsonResponse
    {
        $validator = Validator::make($request->json()->all(), [
            'email'      => 'required',
            'website_id' => 'required',
        ]);
        // get user or create one
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $user = User::create([
                'email' => $request->email
            ]);
        }
        $website = Website::findOrFail($request->website_id);
        $user->subscriptions()->associate($website);
        if ($user->save()) {
            return response()->json([
                'message' => 'success'
            ]);
        } else {
            return response()->json([
                'error' => 'could not create subscription',
            ], 400);
        }
    }
}
