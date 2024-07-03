<?php

namespace App\Http\Controllers;

use App\Models\BookingObject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Booking;
use App\Enums\ObjectStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Lang;

class BookingObjectController extends Controller
{
    private function userIsAdmin ($user)
    {
        return $user->role_id == 1;
    }

    private function getAwailableObjectIdsByDate ($date)
    {
        return Booking::whereDate('booked_to', '>=', $date)
                    ->whereDate('booked_from', '<=', $date)
                    ->pluck('object_id')
                    ->unique();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $locale = app()->getLocale();

        $request->validate([
            'zone' => 'sometimes|required|in:bungalow,pool,cottages',
            'type' => 'sometimes|required|in:sunbed,bed,bungalow,second bungalow,little cottage,big cottage',
        ]);

        $zoneFilter = $request->input('zone');
        $typeFilter = $request->input('type');

        $bookingObjectsQuery = BookingObject::select(
            'id', 
            'name_' . app()->getLocale() . ' as name', 
            'description_' . app()->getLocale() . ' as description', 
            'price', 
            'weekend_price', 
            'discount', 
            'discount_start_date', 
            'discount_end_date', 
            'photos', 
            'zone', 
            'status', 
            'type', 
            'max_persons', 
            'preview_photo',
            'location',
            'position',
            'childrens_price',
            'childrens_weekend_price'
        );

        if ($zoneFilter) {
            $bookingObjectsQuery->where('zone', $zoneFilter);
        }

        if ($typeFilter) {
            $bookingObjectsQuery->where('type', $typeFilter);
        }

        $bookingObjects = $bookingObjectsQuery->get();

        if ($bookingObjects->isEmpty()) {
            return response()->json(['message' => __('no_objects_found')], 404);
        }

        return response()->json($bookingObjects, 200);
    }

    public function getAvailableObjectsByDate (Request $request)
    {
        $request->validate([
            'date' => 'required|date',
        ]);

        $date = Carbon::parse($request->date)->toDateString();
        
        $unavailableObjectIds = $this->getAwailableObjectIdsByDate($date);

        $availableObjects = BookingObject::whereNotIn('id', $unavailableObjectIds)->get();
        $unavailableObjects = BookingObject::whereIn('id', $unavailableObjectIds)->get();

        foreach ($availableObjects as $object) {
            $object->status = ObjectStatus::FREE->value;
        }

        foreach ($unavailableObjects as $object) {
            $object->status = ObjectStatus::BOOKED->value;
        }

        $allObjects = $availableObjects->merge($unavailableObjects);
    
        return response()->json($allObjects, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$this->userIsAdmin($user)) {
            return response()->json(['message' => __('permission_denied')], 403);
        }

        $rules = [
            'name_ua' => 'required|string',
            'name_en' => 'required|string',
            'description_ua' => 'sometimes|required|string',
            'description_en' => 'sometimes|required|string',
            'price' => 'required|numeric',
            'weekend_price' => 'sometimes|required|numeric',
            'discount' => 'sometimes|required|numeric|between:0,100',
            'discount_start_date' => 'sometimes|required|date',
            'discount_end_date' => 'sometimes|required|date',
            'zone' => 'sometimes|required|in:bungalow,pool,cottages',
            'status' => 'sometimes|required|in:free,reserved,booked',
            'type' => 'sometimes|required|in:sunbed,bed,bungalow,second bungalow,little cottage,big cottage',
            'preview_photo' => 'sometimes|required|image|max:2048', // Max size: 2MB
            'photos' => 'sometimes|required|array',
            'photos.*' => 'image|max:2048',
            'max_persons' => 'sometimes|required|integer',
            'location' => 'sometimes|required|string',
            'position' => 'sometimes|required|integer',
            'childrens_price' => 'sometimes|required|numeric',
            'childrens_weekend_price' => 'sometimes|required|numeric'
        ];

        $request->validate($rules);

        $newObject = new BookingObject();

        $newObject->name_ua = $request->input('name_ua');
        $newObject->name_en = $request->input('name_en');

        if($request->has('description_ua')) {
            $newObject->description_ua = $request->input('description_ua');
        }

        if($request->has('description_en')) {
            $newObject->description_en = $request->input('description_en');
        }

        $newObject->price = $request->input('price');

        if($request->has('weekend_price')) {
            $newObject->weekend_price = $request->input('weekend_price');
        }

        if($request->has('discount')) {
            $newObject->discount = $request->input('discount');
        }

        if($request->has('discount_start_date')) {
            $newObject->discount_start_date = $request->input('discount_start_date');
        }

        if($request->has('discount_end_date')) {
            $newObject->discount_end_date = $request->input('discount_end_date');
        }
        
        if ($request->hasFile('photos')) {
            $photos = $request->file('photos');
            $photoPaths = [];

            foreach ($photos as $photo) {
                $photoPath = $photo->store('photos', 'public');
                $photoPaths[] = $photoPath;
            }

            $newObject->photos = $photoPaths;
        }

        if($request->has('zone')) {
            $newObject->zone = $request->input('zone');
        }

        if($request->has('status')) {
            $newObject->status = $request->input('status');
        }

        if($request->has('type')) {
            $newObject->type = $request->input('type');
        }

        if ($request->hasFile('preview_photo')) {
            $previewPhotoPath = $request->file('preview_photo')->store('photos', 'public');
            $newObject->preview_photo = $previewPhotoPath;
        }

        if($request->has('max_persons')) {
            $newObject->max_persons = $request->input('max_persons');
        }

        if($request->has('location')) {
            $newObject->location = $request->input('location');
        }

        if($request->has('position')) {
            $newObject->position = $request->input('position');
        }

        if($request->has('childrens_price')) {
            $newObject->childrens_price = $request->input('childrens_price');
        }

        if($request->has('childrens_weekend_price')) {
            $newObject->childrens_weekend_price = $request->input('childrens_weekend_price');
        }

        $newObject->save();

        return response()->json(['message' => __('object_created_successfully'), 'object' => BookingObject::get()->last()], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $bookingObject = BookingObject::find($id);

        if (!$bookingObject) {
            return response()->json(['error' => __('object_not_found')], 404);
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
            return response()->json(['message' => __('permission_denied')], 403);
        }

        $rules = [
            'name_ua' => 'sometimes|required|string',
            'name_en' => 'sometimes|required|string',
            'description_ua' => 'sometimes|required|string',
            'description_en' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric',
            'weekend_price' => 'sometimes|required|numeric',
            'discount' => 'sometimes|required|numeric|between:0,100',
            'discount_start_date' => 'sometimes|required|date',
            'discount_end_date' => 'sometimes|required|date',
            'zone' => 'sometimes|required|in:bungalow,pool,cottages',
            'status' => 'sometimes|required|in:free,reserved,booked',
            'type' => 'sometimes|required|in:sunbed,bed,bungalow,second bungalow,little cottage,big cottage',
            'preview_photo' => 'sometimes|required|image|max:2048', // Max size: 2MB
            'max_persons' => 'sometimes|required|integer',
            'location' => 'sometimes|required|string',
            'position' => 'sometimes|required|integer',
            'childrens_price' => 'sometimes|required|numeric',
            'childrens_weekend_price' => 'sometimes|required|numeric'

        ];
        
        $request->validate($rules);

        $bookingObject = BookingObject::find($id);

        if (!$bookingObject) {
            return response()->json(['error' => __('object_not_found')], 404);
        }

        if($request->has('name_ua')) {
            $bookingObject->name_ua = $request->input('name_ua');
        }

        if($request->has('name_en')) {
            $bookingObject->name_en = $request->input('name_en');
        }

        if($request->has('description_ua')) {
            $bookingObject->description_ua = $request->input('description_ua');
        }

        if($request->has('description_en')) {
            $bookingObject->description_en = $request->input('description_en');
        }

        if($request->has('price')) {
            $bookingObject->price = $request->input('price');
        }

        if($request->has('weekend_price')) {
            $bookingObject->weekend_price = $request->input('weekend_price');
        }

        if($request->has('discount')) {
            $bookingObject->discount = $request->input('discount');
        }

        if($request->has('discount_start_date')) {
            $bookingObject->discount_start_date = $request->input('discount_start_date');
        }

        if($request->has('discount_end_date')) {
            $bookingObject->discount_end_date = $request->input('discount_end_date');
        }

        if($request->has('zone')) {
            $bookingObject->zone = $request->input('zone');
        }

        if($request->has('status')) {
            $bookingObject->status = $request->input('status');
        }

        if($request->has('type')) {
            $bookingObject->type = $request->input('type');
        }

        if($request->hasFile('preview_photo')) {
            $previewPhotoPath = $request->file('preview_photo')->store('photos', 'public');

            if ($bookingObject->preview_photo) {
                Storage::disk('public')->delete($bookingObject->preview_photo);
            }

            $bookingObject->preview_photo = $previewPhotoPath;
        }

        if($request->has('max_persons')) {
            $bookingObject->max_persons = $request->input('max_persons');
        }

        if($request->has('location')) {
            $bookingObject->location = $request->input('location');
        }

        if($request->has('position')) {
            $bookingObject->position = $request->input('position');
        }

        if($request->has('childrens_price')) {
            $bookingObject->childrens_price = $request->input('childrens_price');
        }

        if($request->has('childrens_weekend_price')) {
            $bookingObject->childrens_weekend_price = $request->input('childrens_weekend_price');
        }

        $bookingObject->save();

        return response()->json(['message' => __('object_updated_successfully'), 'object' => $bookingObject], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $user = auth()->user();

        if (!$this->userIsAdmin($user)) {
            return response()->json(['message' => __('permission_denied')], 403);
        }
        
        $bookingObject = BookingObject::find($id);

        if (!$bookingObject) {
            return response()->json(['error' => __('object_not_found')], 404);
        }
        
        if (!empty($bookingObject->photos)) {
            foreach ($bookingObject->photos as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }

        if (!empty($bookingObject->preview_photo)) {
            Storage::disk('public')->delete($bookingObject->preview_photo);
        }

        $bookingObject->delete();

        return response()->json(['message' => __('object_deleted_successfully')], 200);
    }

    public function deletePhotosByName(Request $request, $id)
    {
        $user = auth()->user();

        if (!$this->userIsAdmin($user)) {
            return response()->json(['message' => __('permission_denied')], 403);
        }

        $bookingObject = BookingObject::find($id);

        if (!$bookingObject) {
            return response()->json(['error' => __('object_not_found')], 404);
        }

        $photosToDelete = $request->input('photos');

        if ($photosToDelete) {
            $newArray = [];
            foreach ($photosToDelete as $photoName) {
                foreach ($bookingObject->photos as $photo) {
                    if ($photo !== $photoName) {
                        array_push($newArray, $photo);
                    }

                    if ($photo === $photoName) {
                        Storage::disk('public')->delete($photo);
                    }
                }
            }

            $bookingObject->photos = $newArray;
            $bookingObject->save();
        }

        return response()->json(['object' => $bookingObject], 200);
    }

    public function addObjectPhotos(Request $request, $id) {
        $user = auth()->user();

        if (!$this->userIsAdmin($user)) {
            return response()->json(['message' => __('permission_denied')], 403);
        }

        $bookingObject = BookingObject::find($id);

        if (!$bookingObject) {
            return response()->json(['error' => __('object_not_found')], 404);
        }

        $request->validate([
            'photos.*' => 'image|max:2048',
        ]);

        if ($request->hasFile('photos')) {
            $photos = $request->file('photos');
            $photoPaths = $bookingObject->photos ?? [];
        
            foreach ($photos as $photo) {
                $photoPath = $photo->store('photos', 'public');
                $photoPaths[] = $photoPath;
            }
        
            $bookingObject->photos = $photoPaths;
        }

        $bookingObject->save();

        return response()->json(['object' => $bookingObject], 200);
    }
}
