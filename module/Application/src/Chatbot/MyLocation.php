<?php

namespace Application\Chatbot;

use BotMan\BotMan\Messages\Attachments\Location;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use OpenCage\Geocoder\Geocoder;

class MyLocation extends Conversation
{
    protected $lat = 0;

    protected $lng = 0;

    private $check;

    public function __construct($check)
    {
        $this->check = $check;
    }

    public function run()
    {
        // This will be called immediately
        if ($this->check == 'address')
        {
            $this->getLatLongFormAddress();
        }
        else $this->askLocation();

        //$this->bot->reply("testing");

    }

    public function askLocation()
    {
        $this->askForLocation('Nhấn vào nút gửi vị trí trên điện thoại', function(Location $location) {
            // $location is a Location object with the latitude / longitude.
            $this->lat = $location->getLatitude();
            $this->lng = $location->getLongitude();
            $check     = new CheckMinAddress($this->lat, $this->lng);
            $this->say('trung tâm gần bạn nhất là: ' . $check->minAddress()());
        });
    }

    public function getLatLongFormAddress()
    {
        $this->ask('Hãy ghi địa chỉ của bạn', function(Answer $answer) {
            $address   = $answer->getText(); // Google HQ

            $geocoder = new Geocoder('bf3a7baae8b24bd2a718f7b588430552');
            $result = $geocoder->geocode($address, ['language' => 'vi']);
            if ($result && $result['total_results'] > 0) {
                $this->lat = $result['results'][0]['geometry']['lng'];
                $this->lng = $result['results'][0]['geometry']['lat'];
            }

            $check     = new CheckMinAddress($this->lat, $this->lng);
            $this->say('trung tâm gần bạn nhất là: '.$this->lat.$this->lng. $check->minAddress()());
            // Save result

        });



    }
}