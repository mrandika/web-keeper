<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /**
     * @param $data
     * @param int $code
     * @param null $message
     * @param null $error
     * @return mixed
     */
    public function response($data, int $code = 200, $message = null, $error = null)
    {
        $body = [
            'code' => $code,
            'message' => $message == null ? ($code == 200 ? 'Success' : 'Failed') : $message,
            'error' => $error,
            'data' => $data
        ];

        return response()->json($body, $code);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'min:10'],
            'password' => ['required', Password::min(8)->letters()->numbers()->symbols()->mixedCase()]
        ]);

        if ($validator->fails()) {
            return $this->response(null, 400, 'Validation failed', $validator->errors());
        }

        $email = $request->post('email');
        $password = $request->post('password');

        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $token = '';

            try {
                $token = $request->user()->createToken('access_token')->plainTextToken;
            } catch (\Exception $e) {
                Auth::logout();
                return $this->response(null, 500, 'Server failed to response the request', $e);
            }

            return $this->response([
                'token_type' => 'Bearer',
                'token' => $token
            ], 200, 'Login success');
        } else {
            return $this->response(null, 404, 'Login failed, account not found or not exist');
        }
    }

    /**
     * @return mixed
     */
    public function profile(Request $request)
    {
        try {
            $user_id = Auth::user()->id;
            $user = User::with(['data', 'employees.warehouse'])->find($user_id);

            return $this->response($user);
        } catch (\Exception $e) {
            return $this->response(null, 500, 'Server failed to response the request', $e);
        }
    }

    /**
     * @return void
     */
    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return $this->response(['user' => null]);
        } catch (\Exception $e) {
            return $this->response(null, 500, 'Server failed to response the request', $e);
        }
    }
}
