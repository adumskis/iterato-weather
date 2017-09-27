<?php

namespace App\WeatherServices;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;

class OpenWeatherMap implements WeatherInterface
{
    private $client;
    private $city = null;
    private $appId;
    private $baseUri = 'http://api.openweathermap.org/data/2.5/weather';
    private $data = null;
    private $units;
    private $query;

    public function __construct($appId = null, $units = 'metric')
    {
        $this->client = new Client();
        $this->appId = $appId;
        $this->units = $units;
    }

    public function query($query)
    {
        $this->query = $query;
        $this->data = null;
        $this->city = null;

        return $this;
    }

    public function units($units)
    {
        $this->units = $units;

        return $this;
    }

    public function appId($appId)
    {
        $this->appId = $appId;

        return $this;
    }

    public function raw($city = null)
    {
        if (!is_null($city)) {
            $this->city($city);
        }

        $this->getData();

        return $this->data;
    }

    private function getData()
    {
        if (!is_null($this->data)) {
            return $this->data;
        }
        if (is_null($this->appId)) {
            throw new \Exception('Unspecified App ID for OpenWeatherMap');
        }
        if (is_null($this->query)) {
            throw new \Exception('Unspecified query');
        }


        try {
            $request = $this->client->request('GET', $this->baseUri, [
                'query' => [
                    'appid' => $this->appId,
                    'q'     => $this->query,
                    'units' => $this->units,
                ],
            ]);
        } catch (RequestException $e) {
            throw new \Exception("Service repond with {$e->getCode()} code");
        }

        if ($request->getReasonPhrase() != 'OK') {
            throw new \Exception('Something wrong with request response');
        }

        $this->data = json_decode($request->getBody()->getContents());

        return $this->data;
    }

    public function getCity()
    {
        return $this->getData()->name;
    }
}
