<?php


namespace App\Firebase;

use Firebase\Auth\Token\Verifier;
use Kreait\Firebase\JWT\IdTokenVerifier;

class Guard
{
    public function user($request)
    {
        $token = $request->bearerToken();

        try {
            $verifier = IdTokenVerifier::createWithProjectId('daily-check-in-comento');

            $token = $verifier->verifyIdToken($token);

            $claims = $token->payload();

            return \App\Models\User::firstOrCreate(
                ['uid'=>$claims['sub']],
                ['email'=>$claims['email'],'photoURL'=>$claims['picture'],'displayName'=>$claims['name']]
            );
        }
        catch (\Exception $e) {
            return null;
        }
    }
}
