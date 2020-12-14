<?php

namespace App\Http\Controllers;

use App\Http\Resources\GinResource;
use App\Models\Gin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GinController extends Controller
{
    public function index()
    {
        return GinResource::collection(Gin::all());
    }

    public function show(int $id)
    {
        $gin = Gin::find($id);
        if ($gin == null)
            return response()->json(['error' => 404, 'message' => 'Not found'], 404);
        return GinResource::make($gin);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => "required",
            'description' => "required"
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $user = Auth::user();
        if ($user->is_admin || $user->tokenCan('create') != 1)
            return response()->json(['error' => 403, 'message' => 'Insufficient permissions'], 403);

        $gin = new Gin();
        $gin->name = $request->get("name");
        $gin->description = $request->get("description");
        $user->gins()->save($gin);
        return response('Created', 201)->header('Location', "/api/gins/" . $gin->id);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->tokenCan('update') != 1)
            return response()->json(['error' => 403, 'message' => 'Insufficient permissions'], 403);
        $gin = Gin::find($id);
        if ($gin == null)
            return response()->json(['error' => 404, 'message' => 'Not found'], 404);
        if (!$user->is_admin && !$gin->user_id == $user->id)
            return response()->json(['error' => 403, 'message' => 'Insufficient permissions'], 403);

        $validator = Validator::make($request->all(), [
            'name' => "required",
            'description' => "required"
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 204);
        }
        $gin->update($request->all());
        return response("Updated", 200);

    }

    public function destroy($id)
    {
        $user = Auth::user();
        if ($user->tokenCan('update') != 1)
            return response()->json(['error' => 403, 'message' => 'Insufficient permissions'], 403);

        if (!$user->is_admin && $user->tokenCan('delete') != 1)
            return response()->json(['error' => 403, 'message' => 'Insufficient permissions'], 403);

        $gin = Gin::find($id);
        if ($gin == null)
            return response()->json(['error' => 404, 'message' => 'Not found'], 404);
        if (!$user->is_admin && $gin->user_id != $user->id)
            return response()->json(['error' => 403, 'message' => 'Insufficient permissions'], 403);
        $gin->delete();
        return response("Deleted", 200);

    }
}
