<?php

namespace App\Http\Controllers\API\Auth;

use App\Exceptions\VerifyEmailException;
use App\Http\Requests\Auth\PasswordSendRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Sender;
use App\Models\User;
use App\Services\MailService;
use App\Services\User\UserService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private $userService;

    public function __construct( UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware('guest')->except('logout');
    }

    public function me(Request $request)
    {
        $user = Auth::guard('api')->user();
        $roles = DB::table('role_user')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->select('role_user.*', 'roles.*'
            )->where('role_user.user_id', $user->id)
            ->first();
        return response()->json([
            'user' => $user,
            'role' => $roles->slug,
        ]);
    }





    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json(['errors' => [
                "description" => array(__('auth.failed'))
            ]
            ], 422);

        }
        $user = $request->user();
        if ($user instanceof MustVerifyEmail && !$user->hasVerifiedEmail()) {
            throw VerifyEmailException::forUser($user);
        }
        $roles = DB::table('role_user')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->select('role_user.*', 'roles.*'
            )->where('role_user.user_id', $user->id)
            ->first();
        $tokenResult = $user->createToken(config('app.name'));
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'token' => $tokenResult->accessToken,
            'user' => $user,
            'role' => $roles->slug,
            'success' => true,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }


    public function logout(Request $request)
    {
        if (Auth::guard('api')->check()) {
            Auth()->logout();
            return response()->json([
                'message' => 'Successfully logged out',
                'status' => 200
            ]);
        }
        return response()->json([
            'success' => false
        ]);
    }


}
