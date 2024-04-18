<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingObject;
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

        $filteredBookingObjects = $bookingObjects->map(function ($bookingObject) {
            return $bookingObject->only(['id', 'name_' . app()->getLocale() . ' as name', 'price', 'weekend_price', 'discount', 'discount_start_date', 'discount_end_date', 'zone', 'status', 'type', 'max_persons']);
        });

        return response()->json($filteredBookingObjects, 200);
    }

    public function update(Request $request, $id)
    {
        $bookingObject = BookingObject::find($id);

        $debug = new Debug();


        $debug->key = "request body";
        $debug->value = json_encode([
            "request" => $request->all(),
            "ID" => $id
        ]);
        
        $debug->save();

        if (!$bookingObject) {
            return response()->json(['error' => __('object_not_found')], 404);
        }

        $request->validate([
            'price' => 'required|numeric',
            'weekend_price' => 'required|numeric',
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

        $bookingObject->save();

        return response()->json($request->all(), 200);

        return response()->json($bookingObject->only(['id', 'name', 'price', 'weekend_price', 'discount', 'discount_start_date', 'discount_end_date', 'zone', 'status', 'type', 'max_persons']), 200);
    }

    public function updateAllByType(Request $request)
    {
        $request->validate([
            'type' => 'required|in:sunbed,bed,bungalow,second bungalow,little cottage,big cottage',
            'price' => 'sometimes|required|numeric',
            'weekend_price' => 'sometimes|required|numeric',
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

        $bookingObjects = BookingObject::where('type', $request->input('type'))->select('id', 'name', 'price', 'weekend_price', 'discount', 'discount_start_date', 'discount_end_date', 'zone', 'status', 'type', 'max_persons')->get();

        return response()->json($bookingObjects, 200);
    }

}
