<?php

namespace App\Http\Controllers;

use App\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestimoniController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:api');
	}

	public function index()
	{
		try {
			$data = Testimoni::all();
			return response()->json([
				'data' => $data,
				'message' => 'testimoni successfully received',
			], 201);
		} catch (\Exception $e) {
			return response()->json(['error' => $e], 409);
		}
	}
	public function store(Request $request)
	{
		$this->validate($request, [
			'nama' 			=> 'required|string',
			'kontak' 		=> 'required|string',
			'komentar' 	=> 'required|string',
		]);
		try {
			$request->filled('id') ?
				$testimoni = Testimoni::findOrFail($request->input('id')) :
				$testimoni = new Testimoni();

			$testimoni->nama 			= $request->input('nama');
			$testimoni->kontak 		= $request->input('kontak');
			$testimoni->komentar 	= $request->input('komentar');

			$testimoni->save();

			return response()->json([
				'message' => 'testimoni successfully stored'
			], 201);
		} catch (\Exception $e) {
			return response()->json(['error' => $e], 409);
		}
	}
	public function destroy(Request $request)
	{
		try {
			$request->filled('id') ?
				Testimoni::findOrFail($request->input('id'))->delete() :
				DB::table('testimonis')->truncate();

			return response()->json([
				'message' => 'testimoni successfully destroyed'
			], 201);
		} catch (\Exception $e) {
			return response()->json([
				'message' => 'destroy testimoni failed',
				'error' => $e
			], 409);
		}
	}
}
		//try {
			//return response()->json([], 201);
		//} catch (\Exception $e) {
			//return response()->json(['error' => $e], 409);
		//}
