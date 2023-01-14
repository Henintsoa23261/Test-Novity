<?php 

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class weatherService{

    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getWeather(): array {

        $response = $this->client->request(
            'GET',
            'https://api.openweathermap.org/data/2.5/weather?lat=43.33333&lon=5.5&appid=56b14e7696cce32cf1f1ef642ed064d4&lang=fr&units=metric'
        );

        return $response->toArray();
    }

}