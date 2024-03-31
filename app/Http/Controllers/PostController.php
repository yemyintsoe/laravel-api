<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return response()->json([
            'data' => $posts,
            'message' => 'Successfully retrive data',
            'status' => Response::HTTP_OK,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        $post = Post::create($validator->validated());
        return response()->json([
            'data' => $post,
            'message' => 'Successfully created',
            'status' => Response::HTTP_CREATED,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = Post::find($id);
        return response()->json([
            'data' => $post,
            'message' => 'Successfully retrive data',
            'status' => Response::HTTP_OK,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages());
        }

        $post = Post::find($id);
        $post->update($validator->validated());
        return response()->json([
            'message' => 'Successfully update',
            'status' => Response::HTTP_OK,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Post::find($id)->delete();
        return response()->json([
            'message' => 'Successfully deleted',
            'status' => Response::HTTP_OK,
        ], 200);
    }
}
