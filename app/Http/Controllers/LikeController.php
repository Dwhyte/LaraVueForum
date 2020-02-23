<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Thread;
use Illuminate\Http\Request;
use App\Models\Replies;
use Symfony\Component\HttpFoundation\Response;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT');
    }

    /**
     * Like or dislike a thread
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function likeIt(Request $request)
    {
        // check if user has already saved this thread
        $check = Like::where('user_id', $request->user()->id)
            ->orWhere('thread_id', $request->thread_id)
            ->orWhere('reply_id', $request->reply_id)
            ->get();

        if($check->isEmpty()) {
            $newLike = new Like();
            $newLike->user_id = $request->user()->id;
            $newLike->thread_id = $request->thread_id;
            $newLike->reply_id = $request->reply_id;
            $newLike->save();
            return response()->json(['success' => true, 'data' => $newLike], Response::HTTP_OK);
        }

        $check->each->delete();
        return response()->json(['success' => true, 'msg' => "like removed."], Response::HTTP_OK);

    }
}
