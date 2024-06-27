<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdditionalObject;

class AdditionalObjectController extends Controller
{
    private function userIsAdmin ($user)
    {
        return $user->role_id == 1;
    }

    public function getAdditionalObjects ()
    {
        $locale = app()->getLocale();

        $additionalObjects = AdditionalObject::select(
            'id',
            'name_' . app()->getLocale() . ' as name', 
            'description_' . app()->getLocale() . ' as description', 
            'price', 
            'weekend_price', 
            'is_available', 
        )
        ->get();

        if ($additionalObjects->isEmpty()) {
            return response()->json(['message' => __('no_objects_found')], 404);
        }

        return response()->json($additionalObjects, 200);
    }

    public function addAdditionalObject (Request $request)
    {
        $user = auth()->user();

        if (!$this->userIsAdmin($user)) {
            return response()->json(['message' => __('permission_denied')], 403);
        }

        $request->validate([
            'name_ua' => 'required|string',
            'name_en' => 'required|string',
            'description_ua' => 'required|string',
            'description_en' => 'required|string',
            'price' => 'required|numeric',
            'weekend_price' => 'required|numeric',
            'is_available' => 'required|boolean',
        ]);

        $newObject = new AdditionalObject([
            'name_ua' => $request->name_ua,
            'name_en' => $request->name_en,
            'description_ua' => $request->description_ua,
            'description_en' => $request->description_en,
            'price' => $request->price,
            'weekend_price' => $request->weekend_price,
            'is_available' => $request->is_available,
        ]);

        $newObject->save();

        return response()->json(['message' => __('object_created_successfully'), 'object' => AdditionalObject::get()->last()], 201);
    }

    public function editAdditionalObject(Request $request)
    {
        $user = auth()->user();
    
        if (!$this->userIsAdmin($user)) {
            return response()->json(['message' => __('permission_denied')], 403);
        }
    
        $validatedData = $request->validate([
            'id' => 'required|integer|exists:additional_objects,id',
            'name_ua' => 'sometimes|required|string',
            'name_en' => 'sometimes|required|string',
            'description_ua' => 'sometimes|required|string',
            'description_en' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric',
            'weekend_price' => 'sometimes|required|numeric',
            'is_available' => 'sometimes|required|boolean',
        ]);
    
        $additionalObject = AdditionalObject::findOrFail($validatedData['id']);
        $additionalObject->update($validatedData);
    
        return response()->json(['message' => __('object_updated_successfully')], 200);
    }

    public function deleteAdditionalObject (Request $request)
    {
        $user = auth()->user();

        if (!$this->userIsAdmin($user)) {
            return response()->json(['message' => __('permission_denied')], 403);
        }

        $request->validate([
            'id' => 'required|integer',
        ]);

        $additionalObject = AdditionalObject::find($request->id);

        if (!$additionalObject) {
            return response()->json(['error' => __('object_not_found')], 404);
        }

        $additionalObject->delete();

        return response()->json(['message' => __('object_deleted_successfully')], 200);
    }
}
