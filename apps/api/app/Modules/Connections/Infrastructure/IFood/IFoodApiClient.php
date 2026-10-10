<?php

namespace App\Modules\Connections\Infrastructure\IFood;

use App\Modules\Connections\Application\Contracts\IFoodGateway;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

final class IFoodApiClient implements IFoodGateway
{
    private const TOKEN_CACHE_KEY = 'connections:ifood:access-token';

    public function canAccessMerchant(string $merchantId): bool
    {
        $response = $this->merchantRequest($merchantId, $this->accessToken());

        if ($response->status() === 401) {
            Cache::forget(self::TOKEN_CACHE_KEY);
            $response = $this->merchantRequest($merchantId, $this->accessToken());
        }

        if ($response->status() === 403 || $response->status() === 404) {
            return false;
        }

        $response->throw();

        return $response->json('id') === $merchantId;
    }

    private function accessToken(): string
    {
        $cached = Cache::get(self::TOKEN_CACHE_KEY);
        if (is_string($cached) && $cached !== '') {
            return $cached;
        }

        $clientId = config('services.ifood.client_id');
        $clientSecret = config('services.ifood.client_secret');
        if (! is_string($clientId) || $clientId === '' || ! is_string($clientSecret) || $clientSecret === '') {
            throw new RuntimeException('Credenciais da aplicação iFood não configuradas.');
        }

        $response = Http::asForm()->acceptJson()->post($this->authenticationUrl(), [
            'grantType' => 'client_credentials',
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
        ])->throw();

        $token = $response->json('accessToken');
        $expiresIn = $response->json('expiresIn');
        if (! is_string($token) || $token === '' || ! is_numeric($expiresIn)) {
            throw new RuntimeException('Resposta de autenticação inválida do iFood.');
        }

        Cache::put(self::TOKEN_CACHE_KEY, $token, max((int) $expiresIn - 60, 1));

        return $token;
    }

    private function merchantRequest(string $merchantId, string $token): Response
    {
        return $this->request($token)->get($this->merchantUrl().'/merchants/'.$merchantId);
    }

    private function request(string $token): PendingRequest
    {
        return Http::acceptJson()->withToken($token)->timeout(15)->connectTimeout(5);
    }

    private function authenticationUrl(): string
    {
        return rtrim((string) config('services.ifood.authentication_url'), '/').'/oauth/token';
    }

    private function merchantUrl(): string
    {
        return rtrim((string) config('services.ifood.merchant_url'), '/');
    }
}
