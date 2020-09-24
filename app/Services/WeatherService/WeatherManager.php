<?php

namespace App\Services\WeatherService;

class WeatherManager {

    /**
     * @param $coo
     * @param string $lang
     * @return array
     */
    public function getCooWeather($coo)
    {
        $owm_api = new OwmApiService();

        return $owm_api->call(strtolower('WEATHER'), [
            'lat' => $coo['latitude'],
            'lon' => $coo['longitude']
        ]);
    }

}
