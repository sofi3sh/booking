<?php

namespace App\Http\Controllers;

use App\Models\BookingObject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookingObjectController extends Controller
{

    private function userIsAdmin ($user)
    {
        return $user->role_id == 1;
    }
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

        $user = auth()->user();

        if (!$this->userIsAdmin($user)) {
            return response()->json(['message' => 'permission denied'], 403);
        }

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

        $user = auth()->user();

        if (!$this->userIsAdmin($user)) {
            return response()->json(['message' => 'permission denied'], 403);
        }

        $request->validate([
            'name' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric',
            'photos' => 'sometimes|required',
            'status' => 'sometimes|required|in:free,reserved,booked',
            'preview_photo' => 'sometimes|required|image|max:2048', // Max size: 2MB
        ]);

        $bookingObject = BookingObject::find($id);

        if (!$bookingObject) {
            return response()->json(['error' => 'Object not found'], 404);
        }

        if($request->has('name')) {
            $bookingObject->name = $request->input('name');
        }

        if($request->has('description')) {
            $bookingObject->description = $request->input('description');
        }

        if($request->has('price')) {
            $bookingObject->price = $request->input('price');
        }

        if($request->has('photos')) {
            $bookingObject->photos = $request->input('photos');
        }

        if($request->has('status')) {
            $bookingObject->status = $request->input('status');
        }

        if($request->hasFile('preview_photo')) {
            $previewPhotoPath = $request->file('preview_photo')->store('photos', 'public');

            if ($bookingObject->preview_photo) {
                Storage::disk('public')->delete($bookingObject->preview_photo);
            }

            $bookingObject->preview_photo = $previewPhotoPath;
        }

        $bookingObject->save();

        return response()->json(['message' => 'Object updated successfully', 'object' => $bookingObject], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $user = auth()->user();

        if (!$this->userIsAdmin($user)) {
            return response()->json(['message' => 'permission denied'], 403);
        }
        
        $bookingObject = BookingObject::find($id);

        if (!$bookingObject) {
            return response()->json(['error' => 'Object not found'], 404);
        }

        $bookingObject->delete();

        return response()->json(['message' => 'Object deleted successfully'], 200);
    }

}
