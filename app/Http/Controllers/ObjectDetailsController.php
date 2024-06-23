<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ObjectDetails;

class ObjectDetailsController extends Controller
{

    private function userIsAdmin ($user)
    {
        return $user->role_id == 1;
    }

    public function index()
    {
        $user = auth()->user();

        if (!$this->userIsAdmin($user)) {
            return response()->json(['message' => __('permission_denied')], 403);
        }

        $objectDetails = ObjectDetails::all();

        if($objectDetails->isEmpty()) {
            return response()->json(['message' => __('no_objects_details_found')], 404);
        }

        return response()->json($objectDetails, 200);
    }

    public function showAllByObjectId($objectId)
    {
        $objectDetails = ObjectDetails::select('id', 'title_' . app()->getLocale() . ' as title', 'description_' . app()->getLocale() . ' as description', 'img')->where('booking_object_id', $objectId)->get();

        if($objectDetails->isEmpty()) {
            return response()->json(['message' => __('no_objects_details_found')], 404);
        }

        return response()->json($objectDetails, 200);
    }

    public function show($id)
    {

        $user = auth()->user();

        if (!$this->userIsAdmin($user)) {
            return response()->json(['message' => __('permission_denied')], 403);
        }

        $objectDetail = ObjectDetails::find($id);

        if(!$objectDetail) {
            return response()->json(['message' => __('object_detail_not_found')], 404);
        }

        return response()->json($objectDetail, 200);

    }

    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$this->userIsAdmin($user)) {
            return response()->json(['message' => __('permission_denied')], 403);
        }

        $request->validate([
            'booking_object_id' => 'required|exists:booking_objects,id',
            'title_ua' => 'required|string',
            'title_en' => 'required|string',
            'description_ua' => 'required|string',
            'description_en' => 'required|string',
            'img' => 'sometimes|required|string',
        ]);

        $objectDetail = new ObjectDetails;

        $objectDetail->booking_object_id = $request->booking_object_id;
        $objectDetail->title_ua = $request->title_ua;
        $objectDetail->title_en = $request->title_en;
        $objectDetail->description_ua = $request->description_ua;
        $objectDetail->description_en = $request->description_en;
        
        if ($request->has('img')) {
            $objectDetail->img = $request->img;
        }

        $objectDetail->save();

        return response()->json($objectDetail, 200);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();

        if (!$this->userIsAdmin($user)) {
            return response()->json(['message' => __('permission_denied')], 403);
        }

        $request->validate([
            'booking_object_id' => 'sometimes|required|exists:booking_objects,id',
            'title_ua' => 'sometimes|required|string',
            'title_en' => 'sometimes|required|string',
            'description_ua' => 'sometimes|required|string',
            'description_en' => 'sometimes|required|string',
            'img' => 'sometimes|required|string',
        ]);

        $objectDetail = ObjectDetails::find($id);

        if(!$objectDetail) {
            return response()->json(['message' => __('object_detail_not_found')], 404);
        }

        if ($request->has('booking_object_id')) {
            $objectDetail->booking_object_id = $request->booking_object_id;
        }

        if ($request->has('title_ua')) {
            $objectDetail->title_ua = $request->title_ua;
        }

        if ($request->has('title_en')) {
            $objectDetail->title_en = $request->title_en;
        }

        if ($request->has('description_ua')) {
            $objectDetail->description_ua = $request->description_ua;
        }

        if ($request->has('description_en')) {
            $objectDetail->description_en = $request->description_en;
        }

        if ($request->has('img')) {
            $objectDetail->img = $request->img;
        }
        
        $objectDetail->save();

        return response()->json($objectDetail, 200);
    }

    public function destroy($id)
    {
        $user = auth()->user();

        if (!$this->userIsAdmin($user)) {
            return response()->json(['message' => __('permission_denied')], 403);
        }

        $objectDetail = ObjectDetails::find($id);

        if(!$objectDetail) {
            return response()->json(['message' => __('object_detail_not_found')], 404);
        }

        $objectDetail->delete();

        return response()->json(['message' => __('object_detail_deleted_successfully')], 200);
    }
}
