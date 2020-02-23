<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JD\Cloudder\Facades\Cloudder;
use Spatie\Permission\Models\Role;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('JWT', ['except' => ['login', 'signup']]);
    }


    /**
     * Get a JWT via given credentials.
     * Login User
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['username', 'password']);
        try {
            $token = JWTAuth::attempt($credentials);
            if(!$token) {
                return response()->json(['msg' => 'Invalid Credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['msg' => 'System Error - please contact admin/help support.'], 500);
        }

        return response()->json(compact('token'), 200);
    }

    /**
     * Register New User
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signup(Request $request)
    {
            $credentials = $request->only('username','email', 'password', 'avatar');

            $validator = Validator::make($credentials, [
                'username' => 'required|min:4|max:10|unique:users',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            // upload new avatar image
            $avatar_upload = $request->avatar;
            Cloudder::upload($avatar_upload, null, [
                'folder' => env('CLOUDINARY_AVATAR_PATH')
            ]);

            // get new avatar url from cloudinary api
            $avatar_url = Cloudder::getPublicId();

            // assign a random color
            $randomColor = ['#9EB3C2', '#F39B6D', '#96C5F7', '#34113F', '#7371FC', '#7CDF64', '#A846A0', '#EF5B5B', '#52489C', '#E0DFD5'];
            $selectedColor = $randomColor[array_rand($randomColor)];

            $user = User::create([
                'username' => $request->username,
                'rand_color' => $selectedColor,
                'avatar' => $avatar_url,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            // assign user role.
            $memberRoleToAssign = Role::findByName('Member', 'api');
            $user->assignRole($memberRoleToAssign);

            $token = JWTAuth::fromUser($user);
            return response()->json(compact('token'));
    }



    /**
     * Get the authenticated User.
     * @return \Illuminate\Http\JsonResponse
     */
    public function authUser(Request $request)
    {
        $user = $request->user();
        $avatar = $user->avatar ? ''.env('CLOUDINARY_FULL_AVATAR_PATH').''.$user->avatar .'' : null;

        return response()->json([
            'id' => $user->id,
            'role' => $user->getRoleNames()[0],
            'username' => $user->username,
            'email' => $user->email,
            'avatar' => $avatar,
            'description' => $user->description,
            'color' => $user->rand_color,
            'savedThreads' => $user->SavedThreads
        ], 200);
    }




    /**
     * Log the user out (Invalidate the token).
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['msg' => 'Successfully logged out']);
    }
}
