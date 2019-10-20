<?php

namespace Application\Chatbot;

use Application\Controller\ChatbotController;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\Drivers\Facebook\Extensions\User;


class SaveContact extends Conversation
{
    protected $firstname;

    protected $email;

    protected $phone;

    protected $idUser;

    public function __construct($id)
    {
        $this->idUser = $id;
    }


    public function askFirstname()
    {
        $this->ask('Xin chào!! Hãy cho tôi biết tên bạn?', function(Answer $answer) {
            $this->firstname = $answer->getText();
            $this->say('Chào ' . $this->firstname);//->say('Nice to meet you '.$this->firstname);
            $this->askEmail();

            // Save result

        });
    }

    public function run()
    {
        // This will be called immediately
        $this->askFirstname();
        //$this->bot->reply("testing");

    }

    public function askEmail()
    {

        $this->ask('Nhập email của bạn', function(Answer $answer) {
            // Save result
            if ($this->checkEmail($answer->getText())) {
                $this->email = $answer->getText();
                $this->say('Mail, ' . $this->email . ' đã được lưu');
                return $this->askPhone();
            }
            $this->say('Mail,sai hãy nhập lại');

            return $this->repeat();


        });
    }

    public function askPhone()
    {
        $this->ask('Nhập sdt của bạn', function(Answer $answer) {
            // Save result
            $this->phone = $answer->getText();


            $this->save();
        });
    }

    //    public function askMood()
    //    {
    //        $this->ask('How are you?', function (Answer $response) {
    //            $this->say('Cool - you said ' . $response->getText());
    //        });
    //    }
    //
    public function askForDatabase()
    {
        $question = Question::create('Bạn muốn lưu thông tin?')
            ->fallback('Unable to create a new database')
            ->callbackId('create_database')
            ->addButtons([
                Button::create('Đồng ý!')->value('yes'),
                Button::create('Từ chối!')->value('no'),
            ]);

        $this->ask($question, function(Answer $answer) {
            // Detect if button was clicked:
            if ($answer->isInteractiveMessageReply()) {
                $selectedValue = $answer->getValue(); // will be either 'yes' or 'no'
                $selectedText  = $answer->getText(); // will be either 'Of course' or 'Hell no!'
            }
            if ($selectedValue == 'yes') {
                $this->say('đã lưu');
            }

        });
    }

    function question($text, $fallback, $callbackId)
    {
        $question = Question::create($text)
            ->fallback($fallback)
            ->callbackId($callbackId)
            ->addButtons([
                Button::create('yes')->value('yes'),
                Button::create('no')->value('no'),
            ]);

        return $question;
    }

    public function stopsConversation(IncomingMessage $message)
    {
        if ($message->getText() === 'Đồng ý!') {
            $this->say('tiếp tục??');

            return true;
        }

        return false;
    }

    private function checkEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }
//
//    public function SaveLead(){
//        $client = new \GuzzleHttp\Client();
//        $client->request('POST', 'https://'.CHATBOT_SERVER::$HOST.'be5579ac.ngrok.io/contacts/add', [
//            'form_params' => [
//                'phone' => $this->phone,
//                'email'             => $this->email,
//                'name'                  => $this->firstname,
//            ]
//        ]);
//
//    }
    function save()
    {

        //$test = new User($this->idUser, $this->firstname, '', null, ['mail' => $this->email, 'phone' => $this->phone]);
        $data = [
            'name' => $this->firstname,
            'email' => $this->email,
            'phone' => $this->phone,
        ];

        $payload = json_encode($data);

        // Prepare new cURL resource
        $ch = curl_init('https://5c1edcb6.ngrok.io/contacts/add');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        // Set HTTP Header for POST request
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($payload))
        );

        // Submit the POST request
        $result = curl_exec($ch);

        // Close cURL session handle
        curl_close($ch);

        $this->say('Thông tin đã được lưu lại!! Cảm ơn bạn ' . $this->firstname);
        return $this->bot->startConversation(new OnboardingConversation());
    }



    //    public function askPhoto()
    //    {
    //        $this->askForImages('Please upload an image.', function ($images) {
    //            // $images contains an array with all images.
    //        });
    //    }
    //
    //    public function askVideos()
    //    {
    //        $this->askForVideos('Please upload a video.', function ($videos) {
    //            // $videos is an array containing all uploaded videos.
    //        });
    //    }
    //
    //    public function askAudio()
    //    {
    //        $this->askForAudio('Please upload an audio file.', function ($audio) {
    //            // $audio is an array containing all uploaded audio files.
    //        });
    //    }
    //
    //    public function askLocation()
    //    {
    //        $this->askForLocation('Please tell me your location.', function (Location $location) {
    //            // $location is a Location object with the latitude / longitude.
    //            $this->lat = $location->getLatitude();
    //            $this->lng = $location->getLongitude();
    //            $this->say('your location is:'.$this->lat.' '.$this->lng);
    //        });
    //    }
    //
    //    public function askNextStep()
    //    {
    //        $this->ask('Shall we proceed? Say YES or NO', [
    //            [
    //                'pattern' => 'yes|yep',
    //                'callback' => function () {
    //                    $this->say('Okay - we\'ll keep going');
    //                }
    //            ],
    //            [
    //                'pattern' => 'nah|no|nope',
    //                'callback' => function () {
    //                    $this->say('PANIC!! Stop the engines NOW!');
    //                }
    //            ]
    //        ]);
    //    }

}
