<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\BookingObject;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index() 
    {
        
        $reviews = Review::all();

        if ($reviews->isEmpty()) {
            return response()->json(['message' => 'No reviews found'], 404);
        }
        return response()->json($bookingObjects, 200);;
    }

    public function store(Request $request, $id) 
    {
        $user = auth()->user();

        $object = BookingObject::find($id);

        if (!$object) {
            return response()->json(['error' => 'Object not found'], 404);
        }

        $request->validate([
            'text' => 'required|string',
        ]);

        $review = new Review();
        $review->user_id = $user->id;
        $review->object_id = $id;

        $review->object_zone = $object->zone;

        $review->text = $request->input('text');
        $review->save();

        return response()->json($review, 200);
    }


    public function showAllByObjectId($id)
    {

        $object = BookingObject::find($id);

        if (!$object) {
            return response()->json(['error' => 'Object not found'], 404);
        }

        if ($object->zone === 'pool') {

            $reviews = Review::all()->where('object_zone', $object->zone);

            if ($reviews->isEmpty()) {
                return response()->json(['message' => 'No reviews found'], 404);
            }

            $reviewsWithUser = $reviews->map(function ($review) {
                $reviewData = $review->toArray();
                $user = User::find($review->user_id);
                if (!$user) {
                    $reviewData['user_name'] = 'Anonymous';
                    $reviewData['user_last_name'] = null;
                    $reviewData['user_photo'] = null;
                } else {
                    $reviewData['user_name'] = $user->name;
                    $reviewData['user_last_name'] = $user->last_name;
                    $reviewData['user_photo'] = $user->photo;
                }
                
                return $reviewData;
            });


            return response()->json($reviewsWithUser, 200);

        } else {
            $reviews = Review::all()->where('object_id', $id);

            if ($reviews->isEmpty()) {
                return response()->json(['message' => 'No reviews found'], 404);
            }

            $reviewsWithUser = $reviews->map(function ($review) {
                $reviewData = $review->toArray();
                $user = User::find($review->user_id);
                if (!$user) {
                    $reviewData['user_name'] = 'Anonymous';
                    $reviewData['user_last_name'] = null;
                    $reviewData['user_photo'] = null;
                } else {
                    $reviewData['user_name'] = $user->name;
                    $reviewData['user_last_name'] = $user->last_name;
                    $reviewData['user_photo'] = $user->photo;
                }
                
                return $reviewData;
            });
        
            return response()->json($reviewsWithUser, 200);
        
        }

    }


}
