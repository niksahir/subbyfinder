<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirebaseAuth;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Contractor;
use App\Models\SubContractor;

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

            if($request->type == 'contractor'){
                $contractor = Contractor::firstOrCreate(['email' => $email]);
                Auth::guard('contractor')->login($contractor);

                return redirect()->route('contractor.dashboard.index'); // Ensure this executes
            }elseif($request->type == 'subcontractor'){
                $subcontractor = SubContractor::firstOrCreate(['email' => $email]);
                Auth::guard('subcontractor')->login($subcontractor);

                return redirect()->route('subcontractor.dashboard.index'); // Ensure this executes
            }else{
                return response()->json(['error' => $e->getMessage()], 401);
            }
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
}
