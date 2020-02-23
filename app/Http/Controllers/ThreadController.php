<?php

namespace App\Http\Controllers;

use App\Http\Resources\SingleThreadResource;
use App\Http\Resources\ThreadResource;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['getAllThreads', 'getSingleThread']]);
    }



    public function getAllThreads($category)
    {
        try {
            $threads = Thread::with(['User', 'Category', 'Replies', 'Likes'])
                ->orWhere('cat_id', $category)
                ->where('isDraft', 0)
                ->latest()
                ->paginate(15);

            return ThreadResource::collection($threads);

        } catch (\Exception $e) {
            return response()->json(['msg' => 'No Threads.'], Response::HTTP_NOT_FOUND);
        }
    }


    public function getSingleThread($username, $slug)
    {
        try {
            $thread = Thread::with(['User', 'Category', 'Replies'])
                ->where('username', $username)
                ->where('slug', $slug)
                ->where('isDraft', 0)
                ->get();

            return SingleThreadResource::collection($thread);

        } catch (\Exception $e) {
            return response()->json(['msg' => 'Thread not found.'], Response::HTTP_NOT_FOUND);
        }
    }
}
