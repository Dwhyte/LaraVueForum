<?php

namespace App\Http\Controllers;

use App\Http\Resources\SingleThreadResource;
use App\Http\Resources\ThreadResource;
use App\Models\SaveThread;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use JD\Cloudder\Facades\Cloudder;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['getAllThreads', 'getSingleThread']]);
    }


    /**
     * Get all threads (by category)
     * @param $category
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getAllThreads($category)
    {
        try {

            if($category === 'all') {
                $threads = Thread::with(['User', 'Category', 'Replies', 'Likes'])
                    ->where('isDraft', 0)
                    ->latest()
                    ->paginate(15);

            } else {
                $threads = Thread::with(['User', 'Category', 'Replies', 'Likes'])
                        ->where('cat_id', $category)
                        ->where('isDraft', 0)
                        ->latest()
                        ->paginate(15);
            }
            return ThreadResource::collection($threads);

        } catch (\Exception $e) {
            return response()->json(['msg' => 'No Threads.'], Response::HTTP_NOT_FOUND);
//            return response()->json(['msg' => $e], Response::HTTP_NOT_FOUND);
        }
    }


    /**
     * Get A single thread by slug
     * @param $username
     * @param $slug
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getSingleThread($username, $slug)
    {
        try {
            $thread = Thread::with(['User', 'Category', 'Replies', 'Replies.Comments'])
                ->where('username', $username)
                ->where('slug', $slug)
                ->where('isDraft', 0)
                ->get();

            return SingleThreadResource::collection($thread);

        } catch (\Exception $e) {
            return response()->json(['msg' => 'Thread not found.'], Response::HTTP_NOT_FOUND);
        }
    }


    /**
     * Create a new Thread
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createThread(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category' => 'required',
            'title' => 'required',
            'thread_content' => 'required',
        ], [
            'category.required' => 'A category selection is required',
            'title.required' => 'Thread title field is required',
            'thread_content.required' => 'Content is required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                ['errors' => $validator->errors()],
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            // assign slug from request title
            $slug = Str::slug($request->title, '-');

            // check if user already created a thread with the same title/slug
            if($this->similarUserThread(auth()->id(), $slug)) {
                return response()->json(
                    ['threadExists' => 'You already have a thread with the same title.'],
                    Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            // try {
            //     // upload new featured image
            //         $featured_image_upload = $request->featured_image;
            //         Cloudder::upload($featured_image_upload, null, [
            //             'folder' => env('CLOUDINARY_THREAD_FEATURED_IMAGE_PATH')
            //         ]);
    
            //         // get new featured image url from cloudinary api
            //         $featured_image_url = Cloudder::getPublicId();
              

            // } catch(\Exception $e) {
            //     return response()->json(
            //         ['error' => 'Could not upload featured image. Contact Admin/Support.'],
            //         Response::HTTP_INTERNAL_SERVER_ERROR);
            // }

            // create new thread
            $thread = new Thread;
            $thread->user_id = $request->user()->id;
            $thread->cat_id = $request->category;
            $thread->username = $request->user()->username;
            $thread->slug = $slug;
            $thread->title = Str::title($request->title);
            $thread->content = $request->thread_content;
            $thread->isDraft = $request->isDraft;
            // $thread->featured_image = $featured_image_url;
            $thread->save();

            return response()->json(['success' => true, "data" => $thread], Response::HTTP_OK);

        } catch(\Exception $e) {
            return response()->json(
                ['error' => $e],
                Response::HTTP_INTERNAL_SERVER_ERROR);
//            return response()->json(['error' => $e], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }


    /**
     * Checks if auth user has a similar slug thread title.
     * @param $userID
     * @param $slug
     * @return bool
     */
    private function similarUserThread($userID, $slug)
    {
        $similarThreadCount = Thread::where('slug', $slug)
            ->where('user_id', $userID)
            ->count();

        return $similarThreadCount > 0 ? true : false;

    }


    /**
     * Save a thread or remove
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveThread(Request $request)
    {
        $user = auth()->user();
        $threadID = $request->thread_id;

        // check if user has already saved this thread
        $check = SaveThread::where('user_id', $user->id)
            ->where('thread_id', $threadID)
            ->get();

        if($check->isEmpty()) {
            $newSave = new SaveThread;
            $newSave->user_id = $user->id;
            $newSave->thread_id = $threadID;
            $newSave->save();

            return response()->json(['success' => true, 'data' => $newSave], Response::HTTP_OK);
        } else {
            return response()->json(['success' => true, "msg" => "this was already saved."], Response::HTTP_OK);
        }

    }


    /**
     * Remove Saved Thread
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeThread(Request $request)
    {
        $user = auth()->user();
        $threadID = $request->thread_id;

        $thread = SaveThread::where('user_id', $user->id)
            ->where('thread_id', $threadID)
            ->get();

        $thread->each->delete();
        return response()->json('Successfully removed.');
    }





}
