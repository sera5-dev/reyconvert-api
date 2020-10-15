<?php

namespace App\Http\Controllers;

use App\User;

class UserController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:api');
	}
	public function index()
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
