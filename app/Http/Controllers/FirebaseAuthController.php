<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirebaseAuth;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FirebaseAuthController extends Controller
{
    public function login(Request $request, FirebaseAuth $firebaseAuth)
    {
            try {
            $authHeader = $request->header('Authorization');
            if (!$authHeader) return response()->json(['error' => 'No token provided'], 401);

            $idToken = str_replace('Bearer ', '', $authHeader);
            $verifiedIdToken = $firebaseAuth->verifyIdToken($idToken);
            $uid = $verifiedIdToken->claims()->get('sub');
            $email = $verifiedIdToken->claims()->get('email');
            $name = $request->input('name', 'Firebase User');

            Log::alert("message",['email' => $email, 'name' => $name, 'type' => $request->input('type','contractor')]);
            $user = User::firstOrCreate(['email' => $email], ['name' => $name]);
            Auth::login($user);

            return response()->json(['message' => 'Login successful', 'user' => $user]);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
}
