<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function register(Request $request)
    {
        $validator = $this->validations($request, [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4'
        ]);

        if ($validator) {
            return $validator;
        }

        User::create([
            'name' => $request->name,
            'username' => str_replace(" ", "", $request->username),
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return $this->respone200('Successfully register');
    }

    public function login(Request $request)
    {
        $validator = $this->validations($request, [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:4'
        ]);

        if ($validator) {
            return $validator;
        }

        $user = User::where('email', $request['email'])->first();
        if (!$user) {
            return $this->respone401('We can`t find a user with that email address');
        }

        if (!Hash::check($request['password'], $user->password)) {
            return $this->respone401('The password is incorrect');
        }
        $payload = [
            'iat' => intval(microtime(true)),
            'exp' => intval(microtime(true)) + 1800,
            'id' => $user->id,
        ];

        $data = [
            'hello' => 'Hi ' . $user->name . ', welcome to home',
            'access_token' => JWT::encode($payload, env('JWT_KEY'), 'HS256'),
            'token_type' => 'Bearer',
        ];

        return $this->respone200('Successfully login', $data);
    }

    public function reset_password(Request $request)
    {
        // Validation
        $validator = $this->validations($request, [
            'old_password' => 'required|string|min:4',
            'new_password' => 'required|string|min:4',
        ]);

        if ($validator) {
            return $validator;
        }

        // Check Old Password Match User Auth
        if (!Hash::check($request->old_password, Auth::user()->password)) {
            return $this->respone401('Old password do not match our records.');
        }

        // Check New Password Match Confirm Password
        if ($request->confirm_password != $request->new_password) {
            return $this->respone401('Confirm Password Not Match');
        }

        // Update Password
        $data = [
            'password' => Hash::make($request->new_password),
        ];

        $this->model->find(Auth::user()->id)->update($data);

        return $this->respone200('Your password has been reset!');
    }
}
