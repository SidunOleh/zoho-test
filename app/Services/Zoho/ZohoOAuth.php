<?php

namespace App\Services\Zoho;

use App\Services\Zoho\Exceptions\ZohoOAuthException;
use Illuminate\Support\Facades\Http;

class ZohoOAuth
{
    private $settings;

    private $url;

    public function __construct()
    {
        $this->settings = config('zoho');
        $this->url = 'https://accounts.zoho.eu/oauth/v2/token';
    }

    /**
     * get access/refresh tokens
     */
    public function getToken($code)
    {
        $response = Http::asForm()->post($this->url, [
            'grant_type' => 'authorization_code',
            'client_id' => $this->settings['client_id'],
            'client_secret' => $this->settings['client_secret'],
            'code' => $code,
        ])->json();
        if ( isset($response['error']) ) {
            throw new ZohoOAuthException($response['error']);
        }

        $this->writeTokens($response);

        return $response['access_token'];
    }

    /**
     * refresh access token
     */
    public function refreshToken()
    {
        $tokens = $this->readTokens();
        $response = Http::asForm()->post($this->url, [
            'grant_type' => 'refresh_token',
            'client_id' => $this->settings['client_id'],
            'client_secret' => $this->settings['client_secret'],
            'refresh_token' => $tokens['refresh_token'],
        ])->json();
        if ( isset($response['error']) ) {
            throw new ZohoOAuthException($response['error']);
        }

        $response['refresh_token'] = $tokens['refresh_token'];
        $this->writeTokens($response);

        return $response['access_token'];
    }

    /**
     * write tokens to file
     */
    private function writeTokens(array $tokens)
    {
        file_put_contents(
            $this->settings['tokens_path'], 
            json_encode($tokens)
        );
    }

    /**
     * read tokens from file
     */
    private function readTokens(): array
    {
        $tokens = file_get_contents($this->settings['tokens_path']);
        
        return json_decode($tokens, true);
    }
}