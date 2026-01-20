<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\V2\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index() {
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => new UserResource(Auth::user())
        ]);
    }

    public function update(Request $request) {
        $user = Auth::user();
        
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string',
            'country' => 'nullable|string',
            'address' => 'nullable|string',
            'password' => 'nullable|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            if ($request->has('name')) $user->name = $request->name;
            if ($request->has('phone')) $user->phone = $request->phone;
            if ($request->has('country')) $user->country = $request->country;
            if ($request->has('address')) $user->address = $request->address;

            if ($request->has('password') && !empty($request->password)) {
                $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
            }

            if ($request->hasFile('avatar')) {
                // Determine file name
                $imageName = time() . '.' . $request->avatar->extension();
                // Move file
                $request->avatar->move(public_path('storage/users'), $imageName);
                
                // Construct path for database
                $user->avatar = 'users/' . $imageName;
            }

            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Profile updated successfully',
                'data' => new UserResource($user)
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update profile: ' . $e->getMessage()
            ], 500);
        }
    }
}
