<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        if (auth()->user()->role_id != 1) {
            return response()->json(['message' => __('permission_denied')], 403);
        }

        return response()->json([
            'roles' => Role::all(),
        ]);
    }
}
