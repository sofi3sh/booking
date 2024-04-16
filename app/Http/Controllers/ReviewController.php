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
            return response()->json(['message' => __('no_reviews_found')], 404);
        }
        return response()->json($reviews, 200);
    }

    public function store(Request $request, $id) 
    {
        $user = auth()->user();

        $object = BookingObject::find($id);

        if (!$object) {
            return response()->json(['error' => __('object_not_found')], 404);
        }

        $request->validate([
            'text' => 'required|string',
            'rating' => 'required|integer|between:1,5',
        ]);

        $review = new Review();
        $review->user_id = $user->id;
        $review->object_id = $id;

        $review->object_type = $object->type;

        $review->text = $request->input('text');
        $review->rating = $request->input('rating');
        $review->save();

        return response()->json($review, 200);
    }


    public function showAllByObjectId($id)
    {

        $object = BookingObject::find($id);

        if (!$object) {
            return response()->json(['error' => __('object_not_found')], 404);
        }

        if ($object->type === 'sunbed' || $object->type === 'bed') {

            $reviews = Review::all()->where('object_type', $object->type);

            if ($reviews->isEmpty()) {
                return response()->json(['message' => __('no_reviews_found')], 404);
            }

            $reviewsWithUser = $this->reviewWithUser($reviews);


            return response()->json($reviewsWithUser, 200);

        } else {
            $reviews = Review::all()->where('object_id', $id);

            if ($reviews->isEmpty()) {
                return response()->json(['message' => __('no_reviews_found')], 404);
            }

            $reviewsWithUser = $this->reviewWithUser($reviews);
        
            return response()->json($reviewsWithUser, 200);
        
        }

    }

    private function reviewWithUser($reviews) {

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


        return $reviewsWithUser;
    }


}
