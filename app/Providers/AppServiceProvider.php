<?php

namespace App\Providers;

use App\Services\Zoho\ZohoOAuth;
use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Http::macro('zoho', function () {
            $tokens = json_decode(
                file_get_contents(config('zoho.tokens_path')), 
                true
            );
            
            return Http::withToken($tokens['access_token'], 'Zoho-oauthtoken')
                ->retry(2, 0, function (Exception $exception, PendingRequest $request) {
                    $body = json_decode($exception->response->getBody()->getContents(), true);
                    $code = $body['code'] ?? '';
                    // retry if access token is expired
                    if ($code == 'INVALID_TOKEN') {
                        $token = (new ZohoOAuth)->refreshToken();
                        $request->withToken($token, 'Zoho-oauthtoken');

                        return true;
                    }

                    return false;
                });
        });
    }
}
