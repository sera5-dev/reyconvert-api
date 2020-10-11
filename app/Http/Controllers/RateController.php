<?php

namespace App\Http\Controllers;

use App\Provider;
use App\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RateController extends Controller
{
	public function index()
	{
		try {
			$data = $this->getData();

			return response()->json([
				'data' => $data,
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
				$data = $this->getData($request->input('r_id'));

				return response()->json([
					'data' => $data,
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

	static function getData($id = null)
	{
		$data = [];
		if ($id)
			$providers = Provider::where('id', $id)->get();
		else
			$providers = Provider::all();

		foreach ($providers as $p => $provider) {
			$data[$p]['id'] 				= $provider->id;
			$data[$p]['provider'] 	= $provider->nama;
			$data[$p]['logo'] 			= $provider->logo;
			$rates = Rate::where('provider_id', $provider->id)->get();
			foreach ($rates as $r => $rate) {
				$data[$p]['rate'][$r]['id']			= $rate->id;
				$data[$p]['rate'][$r]['rate']		= $rate->rate;
				$data[$p]['rate'][$r]['pulsa']	= $rate->pulsa;
				$data[$p]['rate'][$r]['uang']		= $rate->uang;
			}
		}
		return $data;
	}
}
