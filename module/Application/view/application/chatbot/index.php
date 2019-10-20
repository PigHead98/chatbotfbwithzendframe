<?php



//$cacheDriver = new \Doctrine\Common\Cache\ArrayCache();
//\Doctrine\Common\Util\Debug::dump($cacheDriver);die;

//
//
//$REDIS_SERVER = [
//
//    "REAL" => [
//        'host'     => 'redis-14029.c1.asia-northeast1-1.gce.cloud.redislabs.com',
//        "port"     => 14029,
//        'password' => 'osi5pxXCNkT4e7nxJkGsl3Wg7zxwD8xz',
//    ],
//
//];
//
//$cacheDriver = new RedisCache($REDIS_SERVER['REAL']['host'], $REDIS_SERVER['REAL']['port'], $REDIS_SERVER['REAL']['password']);
//
$token        = 'EAAG1K8JhPjYBAHHPtbWfJu1G5TgHflZBUxkp8OW5OsTxV8GqAhwYAnIZBwXFDdfkR0RxjnZBZCRo9Sk8NpGZCc0cSGUynasfYqNOkya27cFV3ZCpVPInIZCAud7iJNGPIqyZA2DPBE3l3KvzxIDYQmDzxl5lYlCfIzlJY7Su2FCQFg1R44IcLXnM';
$app_secret   = '8e48d2df931d7a3bef53a5ef157ec032';
$verification = 'apollo_chatbot';
//
$facebookbot = new facebookbot($token, $app_secret, $verification);

$botman = $facebookbot->createBotman();

$botman->hears('start', function(BotMan $bot) {
    //$bot->reply('Hello yourself.');

    $bot->reply(ButtonTemplate::create('Can we help you')
        ->addButton(ElementButton::create('save contact')
            ->type('postback')
            ->payload('savecontact')
        )
        ->addButton(ElementButton::create('Trung tâm gần nhất')
            ->type('postback')
            ->payload('mylocation')
        //->url('https://www.google.com/maps/dir/?api=1&destination=apollo')
        )
    );
});
$botman->hears('savecontact', function(Botman $bot) {
    $bot->startConversation(new classSaveContact);
    //    $bot->ask('One more thing - what is your email?', function(Botman $bot,Answer $answer) {
    //        // Save result
    //        //$this->email = $answer->getText();
    //
    //        $bot->reply('Great - that is all we need, '.$answer->getText());
    //        //$this->askLocation();
    //
    //    });
});

$botman->hears('mylocation', function(BotMan $bot) {
    $a = $bot->getMessage()->getPayload();
    $bot->reply(ButtonTemplate::create('Xin cho biết vị trí của bạn: '.$a['sender']['id'])
        ->addButton(ElementButton::create('Gửi vị trí')
            ->type('postback')
            ->payload('gps')
        )
        ->addButton(ElementButton::create('Nhập địa chỉ của bạn')
            ->type('postback')
            ->payload('address')
        ));

});

$botman->hears('gps', function(BotMan $bot) {
    $attachment = new Image('https://scontent.xx.fbcdn.net/v/t1.15752-0/p280x280/68296965_2497972463602311_3325527868020097024_n.jpg?_nc_cat=110&_nc_oc=AQlLJu7OIZvSqpbB6-Wd-B4ym1gJW7sig6Ln9et68rsNxnMW6kun8ul1A35PfKCrAOGkAJMMrEaR92RgnzeGPTVP&_nc_ad=z-m&_nc_cid=0&_nc_zor=9&_nc_ht=scontent.xx&oh=6f1a874a9f6f5aa1ebdddf28ae96d9ba&oe=5DD33C0A', [
        'custom_payload' => true,
    ]);

    // Build message object
    $message = OutgoingMessage::create('Chỉ dành cho điện thoại')
        ->withAttachment($attachment);

    // Reply message object
    $bot->reply($message);
    //$bot->startConversation(new myLocation);
});

$botman->hears('address', function(BotMan $bot) {
    $bot->startConversation(new classMyLocation);
});

//$config = [
//    //Your driver-specific configurations
//    "facebook" => [
//        "token"        => "EAAG1K8JhPjYBAHHPtbWfJu1G5TgHflZBUxkp8OW5OsTxV8GqAhwYAnIZBwXFDdfkR0RxjnZBZCRo9Sk8NpGZCc0cSGUynasfYqNOkya27cFV3ZCpVPInIZCAud7iJNGPIqyZA2DPBE3l3KvzxIDYQmDzxl5lYlCfIzlJY7Su2FCQFg1R44IcLXnM",
//        'app_secret'   => '8e48d2df931d7a3bef53a5ef157ec032',
//        'verification' => 'apollo_chatbot',
//
//    ],
//];

// Give the bot something to listen for.
//$botman->hears('start', function(BotMan $bot) {
//    //$bot->reply('Hello yourself.');
//
//    $bot->reply(ButtonTemplate::create('Can we help you')
//        ->addButton(ElementButton::create('Trung tâm gần nhất')
//            ->type('postback')
//            ->payload('mylocation')
//        )
//        ->addButton(ElementButton::create('save contact')
//            ->type('postback')
//            ->payload('contact')
//        )
//        ->addButton(ElementButton::create('trung tâm gần nhất')
//            ->url('https://www.google.com/maps/dir/?api=1&destination=apollo')
//        )
//
//    );
//});
$listpoint = [
    'q1' => [
        'lat'  => 40.770623,
        'long' => -73.964367,
    ],
    'q2' => [
        'lat'  => 41.770623,
        'long' => -70.964367,
    ],
    'q3' => [
        'lat'  => 60.770623,
        'long' => -74.964367,
    ],

];

$botman->receivesLocation(function(BotMan $bot, Location $location) {
    $lat = $location->getLatitude();
    $lng = $location->getLongitude();

    $bot->reply('trung tâm gần bạn nhất là: '.$lat.' '.$lng);
});
//$botman->hears('contact', function(BotMan $bot) {
//    $bot->reply('Nhập tên của bạn ')
//        ->type('postback')
//        ->payload('(a-zA-Z)');
//
//});
//
//$botman->hears('([0-9]+)', function ($bot, $number) {
//    $bot->reply('your phone numbers: '.$number.' hãy nhập mail của bạn');
//});
//$botman->hears('name is {a}', function($bot,$name) {
//    $bot->reply('Your name is: '.$name.' hãy nhập sdt của ban');
//
//});
//
//$botman->hears('mail is {a}', function ($bot, $mail) {
//    if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
//        $bot->reply('your mail is: '.$mail);
//    }
//    else $bot->reply('your mail is false');
//});
//$input = json_decode(file_get_contents('php://input'), true);
//

// Start listening
$botman->listen();

//function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2)
//{
//    $theta      = $longitude1 - $longitude2;
//    $miles      = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
//    $miles      = acos($miles);
//    $miles      = rad2deg($miles);
//    $miles      = $miles * 60 * 1.1515;
//    $feet       = $miles * 5280;
//    $yards      = $feet / 3;
//    $kilometers = $miles * 1.609344;
//    $meters     = $kilometers * 1000;
//
//    return $kilometers;//compact('miles','feet','yards','kilometers','meters');
//}
//
//$point1 = ['lat' => 40.770623, 'long' => -73.964367];
//$point2 = ['lat' => 40.758224, 'long' => -73.917404];
//
//
//$distance  = [];
//$address   = '';
//$min       = getDistanceBetweenPointsNew($point1['lat'], $point1['long'], $listpoint['q1']['lat'], $listpoint['q1']['long']);
//foreach ($listpoint as $key => $value) {
//    $distance = getDistanceBetweenPointsNew($point1['lat'], $point1['long'], $value['lat'], $value['long']);
//    if ($min < $distance) {
//        $min     = $distance;
//        $address = $key;
//    }
//}
//
//function checkMinAddress($lat,$long,array $lissAddress) {
//
//    $address   = '';
//    $min       = getDistanceBetweenPointsNew($lat, $long, $lissAddress['q1']['lat'], $lissAddress['q1']['long']);
//    foreach ($lissAddress as $key => $value) {
//        $distance = getDistanceBetweenPointsNew($lat, $long, $value['lat'], $value['long']);
//        if ($min < $distance) {
//            $min     = $distance;
//            $address = $key;
//        }
//    }
//    return $address;
//}

/*echo $address;
echo '<br>';
echo checkMinAddress($point1['lat'], $point1['long'],$listpoint);*/


?>

