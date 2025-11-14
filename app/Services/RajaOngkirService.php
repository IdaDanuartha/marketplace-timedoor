<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RajaOngkirService
{
    protected string $key;
    protected string $baseUrl;

    public function __construct()
    {
        $this->key = config('services.rajaongkir.api_key');
        $this->baseUrl = config('services.rajaongkir.base_url');
    }

    public function calculateDomesticCost(int $destination, int $weight, ?string $couriers = null): array
    {
        $couriers = $couriers ??
            'jne:sicepat:jnt:ninja:tiki:lion:anteraja:pos';

        $response = Http::asForm()
            ->withHeaders([
                'key' => $this->key,
            ])->post("{$this->baseUrl}/calculate/district/domestic-cost", [
                'origin'      => config('services.rajaongkir.origin_city_id'),
                'destination' => $destination,
                'weight'      => $weight,
                'courier'     => $couriers,
                'price'       => 'lowest',
            ]);

        return $response->json()['data'] ?? [];
    }
}