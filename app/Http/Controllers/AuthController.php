<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:api', ['except' => ['login']]);
	}

	public function register(Request $request)
	{
		$this->validate($request, [
			'username' 	=> 'required|string|unique:users',
			'email' 		=> 'required|string|unique:users',
			'nama' 			=> 'required|string',
			'password' 	=> 'required|confirmed',
		]);

		try {
			$user = new User;
			$user->nama 		= $request->input('nama');
			$user->email 		= $request->input('email');
			$user->username = $request->input('username');
			$user->password = app('hash')->make($request->input('password'));
			$user->save();

			return response()->json([
				'message' => 'users successfully created',
			], 201);
		} catch (\Exception $e) {
			return response()->json([
				'message' => 'create users failed',
			], 409);
		}
	}
	public function login(Request $request)
	{
		$this->validate($request, [
			'username' => 'required|string',
			'password' => 'required|string',
		]);

		$credentials = $request->only(['username', 'password']);

		if (!$token = Auth::attempt($credentials)) {
			return response()->json([
				'message' => 'login failed'
			], 401);
		}
		return response()->json([
			'token' => $token,
		]);
	}
	public function logout()
	{
		try {
			Auth::logout();
			return response()->json([
				'data' => null,
				'message' => 'user successfully logged out'
			], 201);
		} catch (\Exception $e) {
			return response()->json([
				'message' => 'user logout failed',
				'error' => $e,
			], 409);
		}
	}

	public function user()
	{
		try {
			$data = User::all();

			return response()->json([
				'data' => $data,
				'message' => 'user successfully retrieved',
			]);
		} catch (\Exception $e) {
			return response()->json([
				'message' => 'retrieve user failed',
				'error' => $e
			]);
		}
	}
}
