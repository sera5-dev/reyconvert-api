<?php

namespace App\Http\Controllers;

use App\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RateController extends Controller
{
	public function index()
	{
		try {
			$providers = DB::table('rates')
				->join('providers', 'rates.provider_id', '=', 'providers.id')
				->select(
					'rates.provider_id',
					'providers.nama',
					'rates.rate',
					'rates.pulsa',
					'rates.uang',
					'providers.logo'
				)
				->get();

			return response()->json([
				'data' => $providers,
				'message' => 'data successfully retrieved',
			], 201);
		} catch (\Exception $e) {
			return response()->json([
				'message' => 'retrieve data failed',
				'error' => $e,
			], 409);
		}
	}

	public function store(Request $request)
	{
		try {
			$act = "";
			if ($request->filled('r_id')) {

				// @detail
				$act = "retrieve";
				$provider = DB::table('rates')
					->where('rates.id', $request->input('r_id'))
					->join('providers', 'rates.provider_id', '=', 'providers.id')
					->select(
						'rates.provider_id',
						'providers.nama',
						'rates.rate',
						'rates.pulsa',
						'rates.uang',
						'providers.logo'
					)
					->get();

				return response()->json([
					'data' => $provider,
					'message' => 'rate successfully retrieved',
				], 201);
			} else {
				if ($request->filled('id')) {

					// @update
					$act = 'update';
				} else {

					// @create
					$act = 'create';
					$rate = new Rate();

					if ($request->filled('rate'))
						$rate->rate = $request->input('rate');

					if ($request->filled('provider_id'))
						$rate->provider_id = $request->input('provider_id');

					if ($request->filled('pulsa'))
						$rate->pulsa = $request->input('pulsa');

					$rate->uang = $rate->pulsa * $rate->rate;

					$rate->save();
				}
				return response()->json([
					'message' => 'rate successfully ' . $act . 'd',
				], 201);
			}
		} catch (\Exception $e) {
			return response()->json([
				'message' => $act . ' rate failed',
				'error' => $e,
			], 409);
		}
	}

	public function destroy(Request $request)
	{
		try {
			if ($request->filled('id')) {

				// @delete
				DB::table('rates')->where('id', $request->input('id'))->delete();

				$act = "delete";
				$obj = "rate";
			} else {

				// @truncate
				Rate::truncate();

				$act = "truncate";
				$obj = "rates";
			}
			return response()->json([
				'message' => $obj . ' successfully ' . $act . "d",
			], 201);
		} catch (\Exception $e) {
			return response()->json([
				'message' => $act . ' ' . $obj . ' failed',
				'error' => $e,
			], 409);
		}
	}
}
