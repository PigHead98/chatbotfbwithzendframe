<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;


use Application\Chatbot\FacebookBot;
use Application\Chatbot\MyLocation;
use Application\Chatbot\SaveContact;
use BotMan\BotMan\BotMan;
use BotMan\Drivers\Facebook\Extensions\ButtonTemplate;
use BotMan\Drivers\Facebook\Extensions\ElementButton;
use BotMan\Drivers\Facebook\FacebookDriver;
use Zend\Mvc\Controller\AbstractActionController;

class ChatbotController extends AbstractActionController
{
    private $entityManager;
    private $contactManager;

    public function __construct($entityManager, $contactManager)
    {
        $this->entityManager  = $entityManager;
        $this->contactManager = $contactManager;
    }

    public function indexAction()
    {
        $obj = json_decode(file_get_contents('php://input'), true);
        if(isset($obj))
        {
            //var_dump(json_encode($obj));
            $this->contactManager->addResult($obj);
        }

        //        $this->verifyWebhook();
        //
        $token        = 'EAAG1K8JhPjYBAAhVBs0ZBv5UrVkcx4Rzu8ZCnc8WOgmnAsZAa6TL8jkNS9hhZCgTnjxf4WEgZAgQZAy3UVy81D4Mvj2rAVFHuZCHtKJ6F6CVvUGZBlfakGBRAwReLEykRw4Tv8JvSFZAa4mpK6U3gZBySKH9mTZAK2xpEyWnWIkZBE9d1ZAZBU8m7eWO9p';
        $app_secret   = '8e48d2df931d7a3bef53a5ef157ec032';
        $verification = 'apollo_chatbot';
        //
        $facebookbot = new FacebookBot($token, $app_secret, $verification);

        $botman    = $facebookbot->createBotman();
        $listStart =
            [
                'Get Started',
                'Hello',
                'Hi',
                'News',
                'Start',
                'Bắt Đầu',
            ];

        $list = [
            'list start'    => [
                'Get Started',
                'Hello',
                'Hi',
                'News',
                'Start',
                'Bắt Đầu',
            ],
            'list stop'     => [
                'stop',
            ],
            'list contact'  => [
                'savecontact',
            ],
            'list location' => [
                'mylocation' => [
                    'text' => [
                        'Xin cho biết vị trí của bạn:' => [
                            'textBtn' => [
                                'Gửi vị trí',
                                'Nhập địa chỉ của bạn',
                            ],
                            'payload' => [
                                'gps',
                                'address',
                            ],
                        ],
                    ],
                ],
            ],
        ];
        foreach ($listStart as $key => $value) {
            $botman->hears($value, function(BotMan $bot) {
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
        }


        $botman->hears('stop', function(BotMan $bot) {
            $bot->reply('stopped');
        })->stopsConversation();

        $botman->hears('mylocation', function(BotMan $bot) {
            $a = $bot->getMessage()->getPayload();
            $bot->reply(ButtonTemplate::create('Xin cho biết vị trí của bạn: ' . $a['sender']['id'])
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
            $bot->startConversation(new MyLocation('gps'));

        });

        $botman->hears('address', function(BotMan $bot) {
            $bot->startConversation(new MyLocation('address'));
        });


        $botman->hears('savecontact', function(BotMan $bot) {
            $a = $bot->getMessage()->getPayload();
            $bot->startConversation(new SaveContact($a['sender']['id']), $a['sender']['id'], FacebookDriver::class);
        });

        $botman->listen();

        die;

    }
}
