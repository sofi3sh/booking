<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingObject;
use App\Models\AdditionalObject;
use App\Models\Booking;
use App\Models\Transaction;
use App\Models\Debug;
use Carbon\Carbon;

class OneCController extends Controller
{
    public function index()
    {
        $bookingObjects = BookingObject::all();

        if ($bookingObjects->isEmpty()) {
            return response()->json(['message' => __('no_objects_found')], 404);
        }

        $locale = app()->getLocale();
        $filteredBookingObjects = $bookingObjects->map(function ($bookingObject) use ($locale) {
            return [
                'id' => $bookingObject->id,
                'name' => $bookingObject->{'name_' . $locale},
                'price' => $bookingObject->price,
                'weekend_price' => $bookingObject->weekend_price,
                'discount' => $bookingObject->discount,
                'childrens_price' => $bookingObject->childrens_price,
                'childrens_weekend_price' => $bookingObject->childrens_weekend_price,
                'discount_start_date' => $bookingObject->discount_start_date,
                'discount_end_date' => $bookingObject->discount_end_date,
                'zone' => $bookingObject->zone,
                'status' => $bookingObject->status,
                'type' => $bookingObject->type,
                'max_persons' => $bookingObject->max_persons,
            ];
});

        return response()->json($filteredBookingObjects, 200);
    }

    public function update(Request $request, $id)
    {
        $bookingObject = BookingObject::find($id);

        if (!$bookingObject) {
            return response()->json(['error' => __('object_not_found')], 404);
        }

        $request->validate([
            'price' => 'required|numeric',
            'weekend_price' => 'required|numeric',
            'childrens_price' => 'sometimes|required|numeric',
            'childrens_weekend_price' => 'sometimes|required|numeric',
            'discount' => 'sometimes|nullable|numeric',
            'discount_start_date' => 'sometimes|nullable|date',
            'discount_end_date' => 'sometimes|nullable|date',
        ]);

        if ($request->has('price')) {
            $bookingObject->price = $request->input('price');
        }

        if ($request->has('weekend_price')) {
            $bookingObject->weekend_price = $request->input('weekend_price');
        }

        if ($request->has('discount')) {
            $bookingObject->discount = $request->input('discount');
        }

        if ($request->has('discount_start_date')) {
            $bookingObject->discount_start_date = Carbon::parse($request->input('discount_start_date'))->startOfDay();
        }

        if ($request->has('discount_end_date')) {
            $bookingObject->discount_end_date = Carbon::parse($request->input('discount_end_date'))->endOfDay();
        }

        if($request->has('childrens_price')) {
            $bookingObject->childrens_price = $request->input('childrens_price');
        }

        if($request->has('childrens_weekend_price')) {
            $bookingObject->childrens_weekend_price = $request->input('childrens_weekend_price');
        }

        $bookingObject->save();

        return response()->json($bookingObject->only(['id', 'name', 'price', 'weekend_price', 'childrens_price', 'childrens_weekend_price', 'discount', 'discount_start_date', 'discount_end_date', 'zone', 'status', 'type', 'max_persons']), 200);
    }

    public function updateAllByType(Request $request)
    {
        $request->validate([
            'type' => 'required|in:sunbed,bed,bungalow,second bungalow,little cottage,big cottage',
            'price' => 'sometimes|required|numeric',
            'weekend_price' => 'sometimes|required|numeric',
            'childrens_price' => 'sometimes|required|numeric',
            'childrens_weekend_price' => 'sometimes|required|numeric',
            'discount' => 'sometimes|nullable|numeric',
            'discount_start_date' => 'sometimes|nullable|date',
            'discount_end_date' => 'sometimes|nullable|date',
        ]);

        $updateData = [];

        if ($request->has('price')) {
            $updateData['price'] = $request->input('price');
        }

        if ($request->has('weekend_price')) {
            $updateData['weekend_price'] = $request->input('weekend_price');
        }

        if($request->has('childrens_price')) {
            $updateData['childrens_price'] = $request->input('childrens_price');
        }

        if($request->has('childrens_weekend_price')) {
            $updateData['childrens_weekend_price'] = $request->input('childrens_weekend_price');
        }

        if ($request->has('discount')) {
            $updateData['discount'] = $request->input('discount');
        }

        if ($request->has('discount_start_date')) {
            $updateData['discount_start_date'] = Carbon::parse($request->input('discount_start_date'))->startOfDay();
        }

        if ($request->has('discount_end_date')) {
            $updateData['discount_end_date'] = Carbon::parse($request->input('discount_end_date'))->endOfDay();
        }

        BookingObject::where('type', $request->input('type'))->update($updateData);

        $bookingObjects = BookingObject::where('type', $request->input('type'))->select('id', 'name_ua', 'name_en', 'price', 'weekend_price', 'childrens_price', 'childrens_weekend_price', 'discount', 'discount_start_date', 'discount_end_date', 'zone', 'status', 'type', 'max_persons')->get();

        return response()->json($bookingObjects, 200);
    }

    public function getLastOrdersByDays (Request $request)
    {
        $request->validate([
            'days' => 'required|integer'
        ]);

        $timeInterval = Carbon::now()->subDays($request->days);

        return Booking::where('created_at', '>', $timeInterval)->get();
    }


    public function getLastTransactionsByDays (Request $request)
    {
        $request->validate([
            'days' => 'required|integer'
        ]);

        $timeInterval = Carbon::now()->subDays($request->days);

        return Transaction::where('created_at', '>', $timeInterval)->get();
    }

    public function getAdditionalObjects (Request $request) 
    {
        $additionalOjects = AdditionalObject::all();

        if($additionalOjects->isEmpty()) {
            return response()->json(['message' => __('no_objects_found')], 404);
        }

        $locale = app()->getLocale();

        $filteredAdditionalOjects = $additionalOjects->map(function ($additionalOject) use ($locale) {

            return [
                'id' => $additionalOject->id,
                'name' => $additionalOject->translate($locale)->name,
                'price' => $additionalOject->price,
                'weekend_price' => $additionalOject->weekend_price,
                'childrens_price' => $additionalOject->childrens_price,
                'childrens_weekend_price' => $additionalOject->childrens_weekend_price,
            ];
        });

        return response()->json($filteredAdditionalOjects, 200);
    }

    public function updateAdditionalObjectById(Request $request, $id) {

        $additionalObject = AdditionalObject::find($id);

        $request->validate([
            'price' => 'required|numeric',
            'weekend_price' => 'required|numeric',
            'childrens_price' => 'sometimes|required|numeric',
            'childrens_weekend_price' => 'sometimes|required|numeric',
        ]);

        if (!$additionalObject) {
            return response()->json(['error' => __('object_not_found')], 404);
        }
        if($request->has('price')) {
            $additionalObject->price = $request->input('price');
        }
        if($request->has('weekend_price')) {
            $additionalObject->weekend_price = $request->input('weekend_price');
        }
        if($request->has('childrens_price')) {
            $additionalObject->childrens_price = $request->input('childrens_price');
        }
        if($request->has('childrens_weekend_price')) {
            $additionalObject->childrens_weekend_price = $request->input('childrens_weekend_price');
        }
        $additionalObject->save();

        return response()->json($additionalObject->only(['id','name_ua', 'price', 'weekend_price', 'childrens_price', 'childrens_weekend_price']), 200);
    }
}
