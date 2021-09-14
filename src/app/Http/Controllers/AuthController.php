<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpRequest;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Log;
use DB;
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.auth', ['except' => ['login', 'signup','users']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        // $validator = Validator::make($credentials, [
        //     'email' => 'required|email',
        //     'password' => 'required',
        // ]);

        // if($validator->fails()){
        //     return response()->json([
        //         'code' => 422,
        //         'error'  => $validator->messages()
        //     ],422);
        // }

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Email or password does\'t exist'], 401);
        }

        Log::debug('User Logged'. $this->respondWithToken($token));


        return $this->respondWithToken($token);
    }

    public function signup(Request $request)
    {

        // $validatedData = $request->validate([
        //     'name' => 'required|max:55',
        //     'email' => 'email|required|unique:users',
        //     'password' => 'required|confirmed'
        // ]);

        $credentials = request(['email', 'password','name']);
        User::create($credentials);
        return $this->login($request);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userInfo()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()->name
        ]);
    }


    public function users(){
    //    $users = User::all();
    //    return response()->json($users,200);

       $sql = "SELECT * FROM users";
       //    $query = User::create([
       //        'name' => 'Ahmad',
       //        'email' => 'ahmad@ymail.com',
       //        'password' => '****'
       //    ]);
       $users = DB::raw(DB::select($sql));
       Log::info('Viewed Users');

       return response()->json($users,200);

    }
}
