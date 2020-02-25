<?php

namespace App\Http\Controllers;

use App\Models\Replies;
use App\Notifications\NewReplyNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT');
    }


    public function createReply(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'body' => 'required'
        ],[
           'body.required' => 'Comment field cannot be empty',
        ]);

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // new reply
        $newReply = new Replies;
        $newReply->user_id = $user->id;
        $newReply->body = $request->body;
        $newReply->thread_id = $request->thread_id;
        $newReply->parent_id = $request->parent_id;
        $newReply->save();

//        $input = $request->all();
////        $input['user_id'] = $request->user()->id;
//        $input['thread_id'] = $request->thread_id;
//        $input['user_parent_id'] = $request->user_parent_id;
//        Replies::create($input);

        // push new reply notification
        $user->notify(new NewReplyNotification($newReply));

        return response()->json(['success' => true, 'msg' => 'Comment successfully added', 'data' => $newReply], Response::HTTP_OK);
    }
}
