<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Login endpoint
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $pesan = $validator->errors();
            return $this->failedResponse($pesan, 422);
        }

        $credentials = $request->only(['username', 'password']);
        if (!$token = auth('api')->attempt($credentials)) {
            return $this->failedResponse('Username atau password salah!', 401);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Logged in.',
            'token'   => $token
        ]);
    }

    /**
     * Logout endpoint
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json([
            'status'  => true,
            'message' => 'Successfully logged out.'
        ]);
    }

    /**
     * Get authenticated user
     *
     * @return \Illuminate\Http\Response
     */
    public function me()
    {
        return $this->success(auth('api')->user(), 200);
    }

    /**
     * Refresh token
     *
     * @return \Illuminate\Http\Response
     */
    public function refresh()
    {
        $token = auth('api')->refresh();

        return response()->json([
            'status'  => true,
            'message' => 'Token refreshed.',
            'token'   => $token
        ]);
    }

    /**
     * Success response
     *
     * @param mixed $data
     * @param int $statusCode
     * @param string $message
     * @return \Illuminate\Http\Response
     */
    private function success($data, $statusCode, $message = 'success')
    {
        return response()->json([
            'status'      => true,
            'message'     => $message,
            'data'        => $data,
            'status_code' => $statusCode
        ], $statusCode);
    }

    /**
     * Failed response
     *
     * @param string $message
     * @param int $statusCode
     * @return \Illuminate\Http\Response
     */
    private function failedResponse($message, $statusCode)
    {
        return response()->json([
            'status'      => false,
            'message'     => $message,
            'data'        => null,
            'status_code' => $statusCode
        ], $statusCode);
    }
}
