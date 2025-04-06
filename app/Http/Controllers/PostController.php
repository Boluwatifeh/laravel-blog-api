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

    // Get all posts
    public function getPosts()
    {
        $posts = Post::all();
        return response()->json($posts);
    } 

    // Edit post
    public function editPost(Request $request, $id)
    {
        // Validate the request data
        $validatedData = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
    
        if ($validatedData->fails()) {
            return response()->json($validatedData->errors(), 422);
        }
    
        // Find the post by ID
        $post = Post::find($id);
    
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }
    
        // Update the post
        $post->update($validatedData->validated());
    
        return response()->json([
            'message' => 'Post updated successfully',
            'post' => $post,
        ]);
    }

    // Delete post
    public function deletePost($id)
    {
        $post = Post::find($id);
    
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }
    
        $post->delete();
    
        return response()->json(['message' => 'Post deleted successfully']);
    }
    
}
