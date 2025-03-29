<?php

namespace App\Http\Controllers;

use App\Hotel;
use App\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Room::all());
    }

    public function show(int $id): JsonResponse
    {
        return response()->json(Room::findOrFail($id));
    }

    public function create(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'hotel_id' => 'required|integer',
            'room_number' => 'required|string|max:6|unique:rooms,room_number',
            'capacity' => 'required|integer|min:1|max:5',
            'price' => 'required|integer',
        ]);

        if (!$credentials) {
            return response()->json(['message' => 'Invalid credentials'], 422);
        }

        $room = Room::create($credentials);

        return response()->json($room, 201);
    }

    public function update(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'room_id' => 'required|integer',
            'room_number' => 'required|string|max:6|unique:rooms,room_number',
            'capacity' => 'required|integer|min:1|max:5',
            'price' => 'required|integer',
        ]);

        if (!$credentials) {
            return response()->json(['message' => 'Invalid credentials'], 422);
        }

        $room = Room::findOrFail($credentials['room_id']);

        if (!$room) {
            return response()->json(['message' => 'Room not found'], 404);
        }

        if (self::checkOwner($room)) {
            return response()->json(['message' => 'You are not allowed to delete this hotel'], 403);
        }

        $room->update($credentials);

        return response()->json($room, 201);
    }

    public function delete(Request $request): JsonResponse
    {
        $room = Room::findOrFail($request['room_id']);

        if (self::checkOwner($room)) {
            return response()->json(['message' => 'You are not allowed to delete this hotel'], 403);
        }

        return response()->json($room->delete());
    }

    static function checkOwner(Room $room): bool
    {
        return auth()->guard('sanctum')->id() != $room->hotel->owner->id;
    }
}
