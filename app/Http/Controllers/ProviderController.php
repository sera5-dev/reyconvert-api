<?php

namespace App\Http\Controllers;

use App\Provider;
use App\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProviderController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:api', ['except' => ['index']]);
  }

  public function index()
  {
    try {
      $providers = DB::table('providers')->select(
        'id',
        'nama',
        'logo',
      )->get();
      return response()->json([
        'data' => $providers,
        'message' => 'data successfully retrieved',
      ]);
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

      // @detail
      if ($request->filled('p_id')) {
        $act = "retrieve";

        $provider = Provider::findOrFail($request->input('p_id'));

        return response()->json([
          'data' => $provider,
          'message' => 'provider successfully ' . $act . 'd',
        ]);
      } else {

        // @update
        if ($request->filled('id')) {
          $act = "update";
          $provider = Provider::findOrFail($request->input('id'));

          if ($request->filled('nama'))
            $provider->nama = $request->input('nama');

          $provider->save();
        } else {

          // @create
          $act = "create";
          $provider = new Provider();

          if ($request->filled('nama'))
            $provider->nama = $request->input('nama');

          $provider->save();
        }

        return response()->json([
          'message' => 'provider successfully ' . $act . 'd',
        ]);
      }
    } catch (\Exception $e) {
      return response()->json([
        'message' => $act . ' provider failed',
        'error' => $e,
      ], 409);
    }
  }

  public function destroy(Request $request)
  {
    try {
      if ($request->filled('id')) {

        // @delete
        DB::table('providers')->where('id', $request->input('id'))->delete();

        $act = "delete";
        $obj = "provider";
      } else {

        // @truncate
        Provider::truncate();
        Rate::truncate();

        $act = "truncate";
        $obj = "providers";
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
