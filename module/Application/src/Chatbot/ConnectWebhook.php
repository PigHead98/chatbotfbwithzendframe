<?php

namespace Application\Chatbot;

class ConnectWebhook
{
    private $verifyToken;

    public function __construct($verifyToken)
    {
        $this->verifyToken = $verifyToken;

    }

    public function verifyWebhook()
    {
        error_reporting(E_ALL | E_STRICT);
        ini_set('display_errors', 'on');
        if (isset($_REQUEST['hub_challenge']) && isset($_REQUEST['hub_verify_token'])) {
            $challenge    = $_REQUEST['hub_challenge'];
            $verify_token = $_REQUEST['hub_verify_token'];
            if ($verify_token == $this->verifyToken) {
                return $challenge;
            }

        }
        return false;
    }
}
