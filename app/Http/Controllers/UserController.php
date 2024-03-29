<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUsersRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    private function userIsAdmin ($user)
    {
        return $user->role_id == 1;
    }

    public function getProfile ()
    {
        $user = auth()->user();

        return response()->json([
            'name' => $user->name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'date_of_birth' => $user->date_of_birth,
            'photo' => $user->photo,
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
            $photoPath = $request->file('photo')->store('photos', 'public');

            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            $user->photo = $photoPath;
        }

        if ($request->has('password') && $request->has('new_password')) {
            if (Hash::make($request->password) == $user->password) {
                $user->password = Hash::make($request->new_password);
            }
        }

        $user->save();

        return response()->json(['message' => 'Profile updated successfully'], 200);
    }

    public function adminGetUsers ()
    {
        $user = auth()->user();

        if (!$this->userIsAdmin($user)) {
            return response()->json(['message' => 'permission denied'], 403);
        }

        $allUsers = User::all()->where('role_id', 3);

        return response()->json(['users' => $allUsers], 200);
    }

    public function adminGetBookingAgents ()
    {
        $user = auth()->user();

        if (!$this->userIsAdmin($user)) {
            return response()->json(['message' => 'permission denied'], 403);
        }

        $allUsers = User::all()->where('role_id', 2);

        return response()->json(['users' => $allUsers], 200);
    }

    public function adminEditUser (Request $request) {

        $request->validate([
            'user_id' => 'required|integer',
            'name' => 'sometimes|required|string',
            'last_name' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:users,email,' . $request->user_id,
            'date_of_birth' => 'sometimes|required|date',
            'photo' => 'sometimes|required|image|max:2048', // Max size: 2MB
        ]);

        $user = auth()->user();

        if (!$this->userIsAdmin($user)) {
            return response()->json(['message' => 'permission denied'], 403);
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

        $targetUser->save();

        return response()->json(['message' => 'Profile updated successfully'], 200);
    }

    public function getUserBookings ()
    {
        $user = auth()->user();

        $booking = Booking::where('user_id', $user->id)->get();

        if (!$booking) {
            return response()->json(['message' => 'No bookings found'], 404);
        }

        return response()->json(['bookings' => $booking], 200);
    }
}
