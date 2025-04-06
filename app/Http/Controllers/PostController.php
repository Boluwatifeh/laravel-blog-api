<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
        // Create new post
        public function createPost(Request $request)
        {   
            // Validate the request data
            $validatedData = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'content' => 'required|string',
            ]);
    
            if ($validatedData->fails()) {
                return response()->json($validatedData->errors(), 422);
            }
    
            // Create a new post
            $data = $validatedData->validated();
            $data['user_id'] = $request->user()->id; // Assuming the user is authenticated
            $data['title'] = $request->input('title');
            $data['content'] = $request->input('content');
    
            $post = Post::create($data);
            return response()->json([
                'message' => 'Post created successfully',
                'post' => $post,
            ], 201);
        
    }
    
}
