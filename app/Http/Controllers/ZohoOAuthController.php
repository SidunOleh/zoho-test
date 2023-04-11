<?php

namespace App\Http\Controllers;

use App\Services\Zoho\Exceptions\ZohoOAuthException;
use App\Services\Zoho\ZohoOAuth;

class ZohoOAuthController extends Controller
{
    public function getToken(ZohoOAuth $zohoOAuth, $code)
    {
        try {
            $result = $zohoOAuth->getToken($code);
        } catch (ZohoOAuthException $e) {
            $result = $e->getMessage();
        }

        return $result;
    }
}
