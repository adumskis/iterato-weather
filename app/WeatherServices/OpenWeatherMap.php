<?php

namespace App\WeatherServices;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Class OpenWeatherMap
 * @package App\WeatherServices
 */
class OpenWeatherMap implements WeatherInterface
{
    /**
     * GuzzleHttp client
     * @var Client
     */
    private $client;


    /**
     * City found by query
     * @var string|null
     */
    private $city = null;


    /**
     * App ID for weather provider
     * @var string|null
     */
    private $appId;


    /**
     * URL of weather provider endpoint
     * @var string
     */
    private $baseUri = 'http://api.openweathermap.org/data/2.5/weather';


    /**
     * Response from weather provider
     * @var null
     */
    private $data = null;

    /**
     * Type of units
     * @var string
     */
    private $units;


    /**
     * Query for city
     * @var
     */
    private $query;

    public function __construct($appId = null, $units = 'metric')
    {
        $this->client = new Client();
        $this->appId = $appId;
        $this->units = $units;
    }

    /**
     * Set query to find city
     * @param string $query
     * @return $this
     */
    public function query($query)
    {
        $this->query = $query;
        $this->data = null;
        $this->city = null;

        return $this;
    }


    /**
     * Set units
     * @param string $units
     * @return $this
     */
    public function units($units)
    {
        $this->units = $units;

        return $this;
    }

    /**
     * Set app id
     * @param string $appId
     * @return $this
     */
    public function appId($appId)
    {
        $this->appId = $appId;

        return $this;
    }


    /**
     * Get raw response from provider
     * @param null $city
     * @return null
     */
    public function raw($city = null)
    {
        if (!is_null($city)) {
            $this->city($city);
        }

        $this->getData();

        return $this->data;
    }


    /**
     * Sends request to provider and saves response data
     * @return mixed|null
     * @throws \Exception
     */
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

    /**
     * Get city from response
     * @return mixed
     */
    public function getCity()
    {
        return $this->getData()->name;
    }
}
