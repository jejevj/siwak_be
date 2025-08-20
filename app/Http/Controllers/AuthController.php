<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tuser;

class AuthController extends Controller
{
    /**
     * Handle the login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'user_id' => 'required|string',  // NIP
            'password' => 'required|string', // Password
            'token' => 'string',    // Custom token
        ]);

        // Predefined custom token hash to compare
        $validTokenHash = '32161d706e3ae46ff02084ff33807e6e';  // This should be the token hash you're validating against

        // Check if the token is provided and if it matches the predefined hash
        if (!$request->has('token') || $request->token !== $validTokenHash) {
            return response()->json([
                'error' => 'Tidak dapat mengakses API, silahkan gunakan token yang valid',
            ], 403);  // Forbidden
        }

        // Retrieve the user by user_id (NIP)
        $user = Tuser::where('user_id', $request->user_id)->first();

        // If user not found or password mismatch
        if (!$user) {
            return response()->json([
                'error' => 'Pengguna Tidak Ditemukan',
            ], 401);
        }

        // Check if the password matches (using MD5 hash)
        if (md5($request->password) !== $user->user_password) {
            return response()->json([
                'error' => 'Password Salah',
            ], 401);
        }

        // Check if user is a Surveyor
        if ($user->is_surveyor !== 'Y') {
            return response()->json([
                'error' => 'Hanya akun yang berstatus Surveyor yang dapat masuk.',
            ], 403); // Forbidden
        }

        // If successful, return user data
        return response()->json([
            'message' => 'Berhasil Masuk',
            'user' => $user,
        ]);
    }
}
