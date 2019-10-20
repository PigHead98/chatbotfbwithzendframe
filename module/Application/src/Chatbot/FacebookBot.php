<?php

namespace Application\Chatbot;

use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Facebook\FacebookDriver;
use BotMan\Drivers\Facebook\FacebookLocationDriver;
use BotMan\BotMan\Cache\DoctrineCache;


class FacebookBot extends ConnectWebhook
{

    private $config;

    private $token;

    private $app_secret;

    private $verification;

    protected $botman;

    public function __construct($token, $app_secret, $verification)
    {
        $this->app_secret   = $app_secret;
        $this->token        = $token;
        $this->verification = $verification;

        $this->config = [
            "facebook" => [
                "token"        => $this->token,
                'app_secret'   => $this->app_secret,
                'verification' => $this->verification,

            ],
        ];
        parent::__construct($this->verification);
        parent::verifyWebhook();
        // Load the driver(s) you want to use

        DriverManager::loadDriver(FacebookDriver::class);
        DriverManager::loadDriver(FacebookLocationDriver::class);

    }

    public function createBotman()
    {
        // Create an instance
        $doctrineCacheDriver = new \Doctrine\Common\Cache\PhpFileCache('cache');
//        $doctrineCacheDriver->deleteAll();echo 2;die;
        $this->botman = BotManFactory::create($this->config, new DoctrineCache($doctrineCacheDriver));
//        $this->botman = BotManFactory::create($this->config);
        return $this->botman;
    }


}
