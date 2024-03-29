<?php

namespace App\Http\Controllers;

use App\Models\BookingObject;
use Illuminate\Http\Request;

class BookingObjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookingObjects = BookingObject::all();
        return response()->json($bookingObjects, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $newObject = new BookingObject();
        $newObject->name = $request->input('name');
        $newObject->description = $request->input('description');
        $newObject->price = $request->input('price');
        $newObject->photos = $request->input('photos');
        $newObject->preview_photo = $request->input('preview_photo');
        $newObject->save();

        return response()->json(['message' => 'Object created successfully', 'object' => $newObject], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $bookingObject = BookingObject::find($id);

        if (!$bookingObject) {
            return response()->json(['error' => 'Object not found'], 404);
        }

        return response()->json($bookingObject, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $bookingObject = BookingObject::find($id);

        if (!$bookingObject) {
            return response()->json(['error' => 'Object not found'], 404);
        }

        $bookingObject->name = $request->input('name');
        $bookingObject->description = $request->input('description');
        $bookingObject->price = $request->input('price');
        $bookingObject->photos = $request->input('photos');
        $bookingObject->preview_photo = $request->input('preview_photo');
        $bookingObject->save();

        return response()->json(['message' => 'Object updated successfully', 'object' => $bookingObject], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $bookingObject = BookingObject::find($id);

        if (!$bookingObject) {
            return response()->json(['error' => 'Object not found'], 404);
        }

        $bookingObject->delete();

        return response()->json(['message' => 'Object deleted successfully'], 200);
    }
}
