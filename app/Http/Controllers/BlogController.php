<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Blog as Obj;
use Illuminate\Support\Str;

class BlogController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:api', ['except' => ['index']]);

    $obj = new Obj();
    $this->attr = $obj->getFillable();

    $this->required = [
      'title'       => 'required|string',
      'content'     => 'required|string',
    ];

    $this->message = [
      'succeed' => 'action succeed',
      'failed' => 'action failed',
    ];
  }

  public function index()
  {
    try {
      return response()->json([
        'data' => Obj::all(),
        'message' => $this->message['succeed'],
      ], 201);
    } catch (\Exception $e) {
      return response()->json([
        'error' => $e,
        'message' => $this->message['failed']
      ], 409);
    }
  }

  public function store(Request $request)
  {
    $this->validate($request, $this->required);

    try {
      $request->filled('id') ?
        $obj = Obj::findOrFail($request->input('id')) :
        $obj = new Obj();

      $obj->title = $request->title;
      $obj->content = $request->content;
      $obj->slug = Str::slug($obj->title);

      $obj->save();

      return response()->json([
        'message' => $this->message['succeed'],
      ], 201);
    } catch (\Exception $e) {
      return response()->json([
        'error' => $e,
        'message' => $this->message['failed']
      ], 409);
    }
  }

  public function destroy(Request $request)
  {
    try {
      $obj = Obj::findOrFail($request->id);
      $obj->delete();
      return response()->json([
        'message' => $this->message['succeed'],
      ], 201);
    } catch (\Exception $e) {
      return response()->json([
        'error' => $e,
        'message' => $this->message['failed']
      ], 409);
    }
  }
}
