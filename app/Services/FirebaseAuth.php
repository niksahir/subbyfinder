<?php

namespace App\Services;

use Kreait\Firebase\Factory;

class FirebaseAuth
{
    protected $auth;

    public function __construct()
    {
        $factory = (new Factory)->withServiceAccount(storage_path('app/firebase/firebase_credentials.json'));
        $this->auth = $factory->createAuth();
    }

    public function verifyIdToken($idToken)
    {
        return $this->auth->verifyIdToken($idToken);
    }
}
