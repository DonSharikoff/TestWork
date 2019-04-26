<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use Laravel\Passport\Client;
use GuzzleHttp\Exception\BadResponseException;

trait LoginHelper {

    protected function getClient(Request $request): Client {
        return Client::where('secret', $request->secret)->where('id', $request->client_id)->firstOrFail();
    }

    protected function login(Request $request, Client $client): \Illuminate\Http\JsonResponse {
        try {
        $response = (new \GuzzleHttp\Client)->post(config('app.url').'/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $client->id,
                'client_secret' => $client->secret,
                'username' => $request->email,
                'password' => $request->password
            ]
        ]);
            return response()->json(json_decode($response->getBody(), true));
        } catch (BadResponseException $exception) {
            $message = ($exception->getCode() === 400)
                ? 'Invalid Request. Please enter a username or a password'
                : 'Your credentials is incorrect. Please try again';
            return response()->json($message, $exception->getCode());
        }
    }
}
