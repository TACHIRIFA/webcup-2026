<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class WebcupApiClient
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private string $webcupApiUrl,
        private string $webcupApiKey,
    ) {}

    public function getRequests(): array
    {
        $response = $this->httpClient->request(
            'GET',
            $this->webcupApiUrl,
            [
                'headers' => [
                    'X-Webcup-Api-Key' => $this->webcupApiKey,
                    'Accept' => 'application/json',
                ],
            ]
        );

        return $response->toArray();
    }
}
