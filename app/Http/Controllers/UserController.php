<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUsersRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Models\Booking;
use App\Models\AdditionalObject;
use App\Models\AdditionalBooking;
use Carbon\Carbon;

class UserController extends Controller
{
    private function userIsAdmin ($user)
    {
        return $user->role_id == 1;
    }

    private function userIsBookingAgent($user)
    {
        return $user->role_id == 2;
    }

    public function getProfile ()
    {
        $user = auth()->user();

        return response()->json([
            'id' => $user->id,
            'phone' => $user->phone,
            'name' => $user->name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'date_of_birth' => $user->date_of_birth,
            'photo' => $user->photo,
            'role_id' => $user->role_id,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'sometimes|required|string',
            'phone' => 'sometimes|required|string|unique:users,phone,' . auth()->user()->id,
            'last_name' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:users,email,' . auth()->user()->id,
            'date_of_birth' => 'sometimes|required|date',
            'photo' => 'sometimes|required|image|max:2048', // Max size: 2MB
            'password' => 'sometimes|required|string',
            'new_password' => 'sometimes|required|string|min:8',
        ]);

        $user = auth()->user();

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('last_name')) {
            $user->last_name = $request->last_name;
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }

        if ($request->has('date_of_birth')) {
            $user->date_of_birth = $request->date_of_birth;
        }

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos/users', 'public');

            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            $user->photo = $photoPath;
        }

        if ($request->has('password') && $request->has('new_password')) {
            if (Hash::make($request->password) == $user->password) {
                $user->password = Hash::make($request->new_password);
            } else {
                return response()->json(['message' => __('incorrect_password')], 200);
            }
        }

        $user->save();

        return response()->json(['message' => __('profile_updated_successfully')], 200);
    }

    public function adminGetUsers ()
    {
        $user = auth()->user();

        if (!$this->userIsAdmin($user)) {
            return response()->json(['message' => __('permission_denied')], 403);
        }

        $allUsers = User::all()->where('role_id', 3);

        return response()->json(['users' => $allUsers], 200);
    }

    public function adminGetUserByPhone (Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
        ]);

        $user = auth()->user();

        if (!$this->userIsAdmin($user)) {
            if (!$this->userIsBookingAgent($user)) {
                return response()->json(['message' => __('permission_denied')], 403);
            }
        }

        if(!User::where('phone', $request->phone)->get()->first()) {
            return response()->json(['message' => __('user_not_found')], 404);
        }

        return response()->json(['user' => User::where('phone', $request->phone)->get()->first()], 200);
    }

    public function adminGetBookingAgents ()
    {
        $user = auth()->user();

        if (!$this->userIsAdmin($user)) {
            return response()->json(['message' => __('permission_denied')], 403);
        }

        $allUsers = User::all()->where('role_id', 2);

        return response()->json(['users' => $allUsers], 200);
    }

    public function adminEditUser (Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'name' => 'sometimes|required|string',
            'last_name' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:users,email,' . $request->user_id,
            'date_of_birth' => 'sometimes|required|date',
            'photo' => 'sometimes|required|image|max:2048', // Max size: 2MB
            'role_id' => 'sometimes|required|integer',
        ]);

        $user = auth()->user();

        if (!$this->userIsAdmin($user)) {
            return response()->json(['message' => __('permission_denied')], 403);
        }
        
        $targetUser = User::where('id', $request->user_id)->get()->first();

        if ($request->has('name')) {
            $targetUser->name = $request->name;
        }

        if ($request->has('last_name')) {
            $targetUser->last_name = $request->last_name;
        }

        if ($request->has('email')) {
            $targetUser->email = $request->email;
        }

        if ($request->has('date_of_birth')) {
            $targetUser->date_of_birth = $request->date_of_birth;
        }

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');

            if ($user->photo) {
                Storage::disk('public')->delete($targetUser->photo);
            }

            $targetUser->photo = $photoPath;
        }

        if ($request->has('role_id')) {
            $targetUser->role_id = $request->role_id;
        }

        $targetUser->save();

        return response()->json(['message' => __('profile_updated_successfully')], 200);
    }

    public function getUserBookings ()
    {
        $user = auth()->user();

        $bookingsOrderIds = Booking::select('order_id')
            ->where('user_id', $user->id)
            ->whereNotNull('order_id')
            ->groupBy('order_id')
            ->get();

        $orderBookingObjectIds = [];

        foreach ($bookingsOrderIds as $orderId) {
            $bookingsInOrder = Booking::select('id', 'user_id', 'object_id', 'booked_from', 'booked_to', 'payment_status', 'canceled', 'description', 'is_child', 'price')
                ->where('order_id', $orderId->order_id)
                ->get();

            $additionalBookingsInOrder = AdditionalBooking::select('id', 'user_id', 'additional_object_id', 'booked_from', 'booked_to', 'payment_status', 'description', 'is_child', 'price')
                ->where('order_id', $orderId->order_id)
                ->get();

            $transactionStatus = Transaction::select('transaction_status')->where('order_id', $request->order_id)->first();

            $allBookingsInOrder = $bookingsInOrder->merge($additionalBookingsInOrder);

            $orderBookingObjectIds[$orderId->order_id] = $allBookingsInOrder;
            $orderBookingObjectIds[$orderId->order_id]['transaction_status'] = $transactionStatus;
        };

        if (!$orderBookingObjectIds) {
            return response()->json(['message' => __('no_bookings_found')], 404);
        }

        return response()->json(['bookings' => $orderBookingObjectIds], 200);
    }

    public function resetPassword (Request $request)
    {
        $request->validate([
            'phone' => 'required|integer',
            'new_password' => 'required|string',
        ]);

        $user = User::where('phone', $request->phone)->first();

        if(!$user) {
            return response()->json(['message' => __('user_not_found')], 404);
        }

        if (!($user->phone_verified_at > Carbon::now()->subMinutes(5))) {
            return response()->json(['message' => __('confirm_phone')], 403);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => __('password_changed_successfully')], 200);
    }

    public function adminBlockUser (Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
        ]);

        $user = auth()->user();

        if (!$this->userIsAdmin($user)) {
            return response()->json(['message' => __('permission_denied')], 403);
        }

        $targetUser = User::where('id', $request->user_id)->first();

        if(!$targetUser) {
            return response()->json(['message' => __('user_not_found')], 404);
        }

        $userTokens = $targetUser->tokens;

        foreach ($userTokens as $userToken) {
            $userToken->revoke();
        }
        
        $targetUser->is_blocked = 1;
        $targetUser->save();

        return response()->json(['message' => __('profile_updated_successfully')], 200);
    }

    public function adminGetUserBookings (Request $request)
    {
        $request->validate([
            'phone' => 'required|integer'
        ]);

        $user = auth()->user();

        if (!$this->userIsAdmin($user)) {
            if (!$this->userIsBookingAgent($user)) {
                return response()->json(['message' => __('permission_denied')], 403);
            }
        }

        $targetUser = User::where('phone', $request->phone)->get()->first();

        if (!$targetUser) {
            return response()->json(['message' => __('user_not_found')], 404);
        }

        $bookingsOrderIds = Booking::select('order_id')
            ->where('user_id', $targetUser->id)
            ->whereNotNull('order_id')
            ->groupBy('order_id')
            ->get();

        $orderBookingObjectIds = [];

        foreach ($bookingsOrderIds as $orderId) {
            $bookingsInOrder = Booking::select('id', 'user_id', 'object_id', 'booked_from', 'booked_to', 'payment_status', 'canceled', 'description', 'price', 'created_at', 'is_child')
                ->where('order_id', $orderId->order_id)
                ->get();
            
            $additionalBookingsInOrder = AdditionalBooking::select('id', 'user_id', 'additional_object_id', 'booked_from', 'booked_to', 'payment_status', 'description', 'price')
                ->where('order_id', $orderId->order_id)
                ->get();

            $transactionStatus = Transaction::select('transaction_status')->where('order_id', $request->order_id)->first();

            $allBookingsInOrder = $bookingsInOrder->merge($additionalBookingsInOrder);

            $orderBookingObjectIds[$orderId->order_id] = $allBookingsInOrder;
            $orderBookingObjectIds[$orderId->order_id]['transaction_status'] = $transactionStatus;
        };

        if (!$orderBookingObjectIds) {
            return response()->json(['message' => __('no_bookings_found')], 404);
        }

        return response()->json(['bookings' => $orderBookingObjectIds], 200);
    }

    public function testDeleteUserByPhone (Request $request)
    {
        $request->validate([
            'phone' => 'required|integer'
        ]);

        $targetUser = User::where('phone', $request->phone)->get()->first();

        if (!$targetUser) {
            return response()->json(['message' => __('user_not_found')], 404);
        }
        
        $targetUser->delete();

        return response()->json(['message' => __('user deleted successfully')], 200);
    }
}
