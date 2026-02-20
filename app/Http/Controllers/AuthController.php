<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'role' => 'required|in:end_user,administrator',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
            'image' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ], 422);
        }

        $imageUrl = null;

        if ($request->image) {
            $imageData = base64_decode(
                preg_replace('#^data:image/\w+;base64,#i', '', $request->image)
            );

            if ($imageData === false) {
                return response()->json([
                    'message' => 'Invalid image data.'
                ], 400);
            }

            $fileName = 'profile_images/' . Str::uuid() . '.png';
            $supabaseUrl = rtrim(env('SUPABASE_URL'), '/');
            $supabaseKey = env('SUPABASE_SERVICE_ROLE_KEY');
            $bucket = 'image';

            try {
                $response = Http::withHeaders([
                    'apikey' => $supabaseKey,
                    'Authorization' => 'Bearer ' . $supabaseKey,
                    'Content-Type' => 'image/png',
                ])->withBody($imageData, 'image/png')
                  ->put("$supabaseUrl/storage/v1/object/$bucket/$fileName");

                if ($response->successful()) {
                    $imageUrl = "$supabaseUrl/storage/v1/object/public/$bucket/$fileName";
                } else {
                    return response()->json([
                        'message' => 'Image upload failed.'
                    ], 500);
                }

            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Image upload error: ' . $e->getMessage()
                ], 500);
            }
        }

        User::create([
            'name' => $request->name,
            'department' => $request->department,
            'role' => $request->role,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 'inactive',
            'image' => $imageUrl,
        ]);

        return response()->json([
            'message' => 'Account created successfully. Waiting for admin approval.',
            'image_url' => $imageUrl
        ]);
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first()
            ], 422);
        }

        $credentials = $request->only('email', 'password');

        // Check if user exists first
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Invalid email or password.'
            ], 401);
        }

        if ($user->status !== 'active') {
            return response()->json([
                'message' => 'Your account is pending approval.'
            ], 403);
        }

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid email or password.'
            ], 401);
        }

        // Prevent session fixation
        $request->session()->regenerate();

        return response()->json([
            'message' => 'Login successful!',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ]
        ]);
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'message' => 'Logged out successfully.'
        ]);
    }
}
