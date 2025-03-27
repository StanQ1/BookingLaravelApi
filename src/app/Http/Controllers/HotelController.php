<?php

namespace App\Http\Controllers;

use App\Hotel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Hotel::all());
    }

    public function create(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'name' => 'required|string|max:25|min:3',
            'location' => 'required|string|max:40|min:3',
        ]);

        if (!$credentials) {
            return response()->json(['message' => 'Invalid credentials'], 422);
        }

        $hotel = Hotel::create([
            ...$credentials,
            'owner_id' => auth()->guard('sanctum')->id(),
        ]);

        return response()->json($hotel, 201);
    }

    public function show(string $id): JsonResponse
    {;

        $hotel = Hotel::findOrFail($id);

        if (!$hotel) {
            return response()->json(['error' => 'Hotel not found'], 404);
        }

        return response()->json([
            'hotel' => $hotel,
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $hotel = Hotel::with('owner')->findOrFail($request['hotel_id']);

        $credentials = $request->validate([
            'name' => 'string|max:25|min:3',
            'location' => 'string|max:40|min:3',
        ]);

        if (!$credentials) {
            return response()->json(['message' => 'Invalid credentials'], 422);
        }

        if (auth()->guard('sanctum')->id() != $hotel->owner->id) {
            return response()->json(['message' => 'You are not allowed to edit this hotel'], 403);
        }

        $hotel->update($credentials);

        return response()->json($hotel);
    }

    public function delete(Request $request): JsonResponse
    {
        $hotel = Hotel::findOrFail($request['hotel_id']);

        if (auth()->guard('sanctum')->id() != $hotel->owner->id) {
            return response()->json(['message' => 'You are not allowed to delete this hotel'], 403);
        }

        return response()->json($hotel->delete());
    }
}
