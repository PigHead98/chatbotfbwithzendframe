<?php

namespace Application\Chatbot;

class CheckMinAddress
{
    private $lat;
    private $long;
    private $address;

    public function __construct($lat, $long)
    {
        $this->lat  = $lat;
        $this->long = $long;
    }

    public function getDistanceBetweenPointsNew($latitude2, $longitude2)
    {
        $theta      = $this->long - $longitude2;
        $miles      = (sin(deg2rad($this->lat)) * sin(deg2rad($latitude2))) + (cos(deg2rad($this->lat)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
        $miles      = acos($miles);
        $miles      = rad2deg($miles);
        $miles      = $miles * 60 * 1.1515;
        $feet       = $miles * 5280;
        $yards      = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters     = $kilometers * 1000;

        return $kilometers;//compact('miles','feet','yards','kilometers','meters');
    }


    public function minAddress()
    {
        $listpoint     = [
            'q7' => [
                'lat'  => 40.770623,
                'long' => 73.964367,
            ],
            'q1' => [
                'lat'  => 70.770623,
                'long' => 64.964367,
            ],
            'q2' => [
                'lat'  => 41.770623,
                'long' => 70.964367,
            ],
            'q3' => [
                'lat'  => 60.770623,
                'long' => 74.964367,
            ],


        ];
        $this->address = 'q7';
        $min           = $this->getDistanceBetweenPointsNew(40.770623, 73.964367);
        foreach ($listpoint as $key => $value) {
            $distance = $this->getDistanceBetweenPointsNew($value['lat'], $value['long']);
            if ($min > $distance) {
                $min           = $distance;
                $this->address = $key;
            }
        }

        return $this->address;
    }
}
