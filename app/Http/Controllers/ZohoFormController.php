<?php

namespace App\Http\Controllers;

use App\Http\Requests\ZohoRequest;
use App\Services\Zoho\Exceptions\ZohoRestException;
use App\Services\Zoho\Rest\ZohoAccount;
use App\Services\Zoho\Rest\ZohoDeal;

class ZohoFormController extends Controller
{
    private $zohoAccount;

    private $zohoDeal;

    public function __construct(ZohoAccount $zohoAccount, ZohoDeal $zohoDeal)
    {
        $this->zohoAccount = $zohoAccount;
        $this->zohoDeal = $zohoDeal;
    }

    public function handle(ZohoRequest $request)
    {
        try {
            $validated = $request->validated();
            $account = $this->zohoAccount->insert($validated['account']);
            $validated['deal']['Account_Name'] = [
                'id' => $account['details']['id'],
                'name' => $validated['account']['Account_Name'],
            ];
            $this->zohoDeal->insert($validated['deal']);
        } catch (ZohoRestException $e) {
            return response([
                'message' => $e->getMessage(),
            ], 500);
        }

        return response(['message' => 'Successfully created.']);
    }
}
