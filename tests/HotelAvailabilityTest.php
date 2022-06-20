<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class HotelAvailabilityTest extends TestCase
{
    public function test_search()
    {
        $request = [
            'fromDate' => '2022-01-03',
            'toDate' => '2022-01-04',
            'adults' => 1,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "localhost" . '?' . http_build_query($request));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PORT, '8887');
        $output = curl_exec($ch);
        curl_close($ch);

        $this->assertEquals('[{"Provider":"Fantastic Yurts","Hotel":"Yangtze River Yurts","Room":1,"Price":100},{"Provider":"Fantastic Yurts","Hotel":"Yangtze River Yurts","Room":2,"Price":100},{"Provider":"Fantastic Yurts","Hotel":"Yangtze River Yurts","Room":3,"Price":100},{"Provider":"Fantastic Yurts","Hotel":"Yangtze River Yurts","Room":4,"Price":100}]', $output);
    }

    public function test_commission()
    {
        $request = [
            'fromDate' => '2022-01-06',
            'toDate' => '2022-01-06',
            'adults' => 1,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "localhost" . '?' . http_build_query($request));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PORT, '8887');
        $output = curl_exec($ch);
        curl_close($ch);

        $this->assertEquals('[{"Provider":"Fantastic Yurts","Hotel":"Indian Burial Ground Yurts","Room":1,"Price":200}]', $output);
    }
}
