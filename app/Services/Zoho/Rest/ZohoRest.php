<?php

namespace App\Services\Zoho\Rest;

use App\Services\Zoho\Exceptions\ZohoRestException;
use Illuminate\Support\Facades\Http;

abstract class ZohoRest
{
    /**
     * Insert record
    */
    public function insert(array $data): array 
    {
        $url = 'https://www.zohoapis.eu/crm/v2/' . $this->name;
        $response = Http::zoho()->post($url, [
            'data' => [$data],
        ])->json();

        if ($response['data'][0]['status'] != 'success') {
            throw new ZohoRestException($response['data'][0]['message']);
        }

        return $response['data'][0];
    }
}