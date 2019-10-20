<?php

namespace Application\Chatbot;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class OnboardingConversation extends Conversation
{
    public $B_WELCOME_MESSAGE = "Wall Street English rất vui được hỗ trợ bạn!";
    protected $firstname;
    protected $email;
    protected $user;
    protected $recipient;

    public function stopsConversation(IncomingMessage $message)
    {
        if ($message->getText() == 'stop') {
            return true;
        }

        return false;
    }

    public function run()
    {
        $this->user      = $this->bot->getUser();
        $this->recipient = $this->bot->getMessage()->getSender();

        $this->bot->userStorage()->save([
            "name"               => $this->user->getFirstName(),
            "last_name"          => $this->user->getLastName(),
            "has_booking"        => false,
            "has_confirm_email"  => false,
            "recipient"          => $this->recipient,
            "done_first_times"   => false,
            "ready_to_save_lead" => true,

            "test_quiz_vocabulary_travel_easy_done"      => 0,
            "test_quiz_vocabulary_travel_difficult_done" => 0,
            "test_quiz_vocabulary_office_easy_done"      => 0,
            "test_quiz_vocabulary_office_difficult_done" => 0,
            "test_quiz_vocabulary_life_easy_done"        => 0,
            "test_quiz_vocabulary_life_difficult_done"   => 0,

            "test_quiz_grammar_general_easy_done"            => 0,
            "test_quiz_grammar_general_difficult_done"       => 0,
            "test_quiz_grammar_idioms_easy_done"             => 0,
            "test_quiz_grammar_idioms_difficult_done"        => 0,
            "test_quiz_grammar_phrasal_verbs_easy_done"      => 0,
            "test_quiz_grammar_phrasal_verbs_difficult_done" => 0,

            //#############################################################
            "vocabulary_by_image_done_first_times"           => false,
            //#############################################################
            "vocabulary_by_image_travel_new_word_done"       => 0,
            "vocabulary_by_image_travel_idioms_done"         => 0,
            "vocabulary_by_image_travel_phrasal_verbs_done"  => 0,

            "vocabulary_by_image_travel_new_word_complete"      => false,
            "vocabulary_by_image_travel_idioms_complete"        => false,
            "vocabulary_by_image_travel_phrasal_verbs_complete" => false,
            //#############################################################

            "vocabulary_by_image_job_new_word_done"      => false,
            "vocabulary_by_image_job_idioms_done"        => false,
            "vocabulary_by_image_job_phrasal_verbs_done" => false,

            "vocabulary_by_image_job_new_word_complete"      => false,
            "vocabulary_by_image_job_idioms_complete"        => false,
            "vocabulary_by_image_job_phrasal_verbs_complete" => false,
            //#############################################################

            "vocabulary_by_image_daily_new_word_done"      => false,
            "vocabulary_by_image_daily_idioms_done"        => false,
            "vocabulary_by_image_daily_phrasal_verbs_done" => false,

            "vocabulary_by_image_daily_new_word_complete"      => false,
            "vocabulary_by_image_daily_idioms_complete"        => false,
            "vocabulary_by_image_daily_phrasal_verbs_complete" => false,
        ]);

        $question = Question::create('Chào ' . $this->user->getFirstName() . "\r\n" . $this->B_WELCOME_MESSAGE . "\r\nBạn muốn chọn chức năng nào?")
            ->fallback('Chọn 1 trong các chức năng trên!')
            ->callbackId('create_database_1')
            ->addButtons([
                Button::create('Đặt lịch hẹn')->value('book_appointment'),
                Button::create('Làm bài kiểm tra')->value('test_quiz_english'),
                Button::create('Từ vựng & ngữ pháp')->value('learn_vocabulary_grammar'),
                Button::create('Chat với WSE Team')->value('chat_with_agent'),
            ]);

        $this->ask($question, function(Answer $answer) {
            // Detect if button was clicked:
            $selectedValue = $answer->getValue();
            if ($answer->isInteractiveMessageReply()) {
                switch ($selectedValue) {
                    case 'test_quiz_english' :
                        $this->bot->startConversation(new TestQuestion());
                        break;
                    default :
                        return $this->repeat();
                }
            } else {
                if (!empty(trim($answer->getText())))
                    return $this->repeat();
            }
        });
    }
}

class TestQuestion extends Conversation
{
    protected $user;
    public $COLLECTION = [
        [
            "title"       => "Noise in a room may be reduced by carpeting, draperies, and upholstered furniture______absorb sound.",
            "media"       => [
                "type" => "image",
                "url"  => "",
            ],
            "fallback"    => "",
            "callback_id" => "",
            "answer"      => "all of which",
            "options"     => ["of them all", "of all which", "which they all", "all of which"],
        ],
        [
            "title"       => "Round the corner _______",
            "media"       => [
                "type" => "image",
                "url"  => "",
            ],
            "fallback"    => "",
            "callback_id" => "",
            "answer"      => "stood a little boy",
            "options"     => ["a little boy is standing.", "stood a little boy.", "did a little boy stand."],
        ],
        [
            "title"       => "The graduation speech ____ the principal was so touching!",
            "media"       => [
                "type" => "image",
                "url"  => "",
            ],
            "fallback"    => "",
            "callback_id" => "",
            "answer"      => "given by",
            "options"     => ["giving by", "given by", "having given by"],
        ],
        [
            "title"       => "___________ gone to bed when I heard a knock on the door.",
            "media"       => [
                "type" => "image",
                "url"  => "",
            ],
            "fallback"    => "",
            "callback_id" => "",
            "answer"      => "Scarcely had I",
            "options"     => ["No sooner had I", "Scarcely had I", "Hardly when I"],
        ],
        [
            "title"       => "______the weather is good, this will be a great holiday.",
            "media"       => [
                "type" => "image",
                "url"  => "",
            ],
            "fallback"    => "",
            "callback_id" => "",
            "answer"      => "Providing",
            "options"     => ["Unless", "Providing", "If not"],
        ],
        //Bo 2 (question 6)
        [
            "title"       => "Let’s go to the movie theater, ____ ?",
            "media"       => [
                "type" => "image",
                "url"  => "",
            ],
            "fallback"    => "",
            "callback_id" => "",
            "answer"      => "hit",
            "options"     => ["Don’t you", "Let us", "Shall we"],
        ],
        [
            "title"       => "The wedding of Anna and Tom _____ this weekend.",
            "media"       => [
                "type" => "image",
                "url"  => "",
            ],
            "fallback"    => "",
            "callback_id" => "",
            "answer"      => "skipping class",
            "options"     => ["is going to take place", "would have taken place", "takes place"],
        ],
        [
            "title"       => "My sister is not interested in novels.____",
            "media"       => [
                "type" => "image",
                "url"  => "",
            ],
            "fallback"    => "",
            "callback_id" => "",
            "answer"      => "I am not, either",
            "options"     => ["So am I", "I am not, either", "I was not, either"],
        ],
        //question 9
        [
            "title"       => "Charlotte and I ___ for 2 years before I met her family.",
            "media"       => [
                "type" => "image",
                "url"  => "",
            ],
            "fallback"    => "",
            "callback_id" => "",
            "answer"      => "Had been going out",
            "options"     => ["Had been going out", "Had gone out", "Are going out"],
        ],
        //question 10
        [
            "title"       => "At no time ______ I would lend you my books.",
            "media"       => [
                "type" => "image",
                "url"  => "",
            ],
            "fallback"    => "",
            "callback_id" => "",
            "answer"      => "Sounds great!",
            "options"     => ["I promised", "I did promise", "did I promise"],
        ],
    ];

    // First question
    public function run()
    {
        $this->generalQuestion();
    }

    public function generalQuestion()
    {

        $index = $this->bot->userStorage()->get("test_quiz_grammar_general_difficult_done");
        if ($this->COLLECTION[$index]["media"]["url"] != "") {
            $question = MediaTemplate::create()
                ->element(MediaUrlElement::create($this->COLLECTION[$index]["media"]["type"])->url($this->COLLECTION[$index]["media"]["url"])
                );
            $this->ask($question, function(Answer $answer) {

            });
        }

        $q        = new GenerateQuestion();
        $question = $q->generate($index, 5,
            $this->COLLECTION[$index]['title'],
            $this->COLLECTION[$index]['fallback'],
            $this->COLLECTION[$index]['callback_id'],
            $this->COLLECTION[$index]['options']
        );

        $this->ask($question, function(Answer $answer) {
            $answer_text = trim($answer->getText());
            if ($answer_text != "" && ($answer_text != "a" && $answer_text != "b" && $answer_text != "c" && $answer_text != "d"))
                return $this->repeat();

            if ($answer->isInteractiveMessageReply()) {
                $index = $this->bot->userStorage()->get("test_quiz_vocabulary_travel_difficult_done");
                $this->say('The Answer is : ' . $this->COLLECTION[$index]["answer"]);
                $this->bot->userStorage()->save([
                    "test_quiz_vocabulary_travel_difficult_done" => $index + 1,
                ]);
                $index = $this->bot->userStorage()->get("test_quiz_vocabulary_travel_difficult_done");
                if ($index <= count($this->COLLECTION) - 1) {
                    if ($index == 5) {
                        $this->say('bạn đã hoàn thành!!!');
                        $this->bot->userStorage()->save([
                            "done_first_times" => true,
                        ]);
                        $this->bot->userStorage()->save([
                            "current_ebook_cate" => "vocabulary",
                            "current_ebook"      => "du_lich",
                        ]);
                    } else {
                        if ($index % 5 == 0) {
                            $this->bot->startConversation(new TryAnotherFunction_Conversion());
                        } else {
                            $this->generalQuestion();
                        }
                    }
                } else {
                    $this->bot->startConversation(new TryAnotherFunction_Conversion());
                }
            }
        });
    }
}

class GenerateQuestion
{
    private $option = ["a", "b", "c", "d", "e", "f"];
    private $optionBold = ["a", "b", "c", "d", "e", "f"];

    public function generate($num, $total, $title, $fallback, $callback_id, $buttons)
    {
        $_button = [];
        foreach ($buttons as $index => $btn) {
            //$_button[] =  Button::create($btn)->value( $this->option[$index]);
            $_button[] = Button::create(strtoupper($this->option[$index]))->value($this->option[$index]);
            $title     .= "\r\n" . strtoupper($this->optionBold[$index]) . "." . $btn;
        }
        $question = Question::create("[" . (($num % 5) + 1) . "/" . $total . "]\r\n" . $title)
            ->fallback($fallback)
            ->callbackId($callback_id)
            ->addButtons($_button);

        return $question;
    }
}

class TryAnotherFunction_Conversion extends Conversation
{
    public function run()
    {
        $array_buttons = [];
        if (!$this->bot->userStorage()->get("has_booking")) {
            $array_buttons[] = Button::create('Đặt lịch hẹn')->value('try_book_appointment');
        }

        $array_buttons[] = Button::create('Làm bài kiểm tra')->value('try_test_quiz_english');
        $array_buttons[] = Button::create('Từ vựng & ngữ pháp')->value('learn_vocabulary_grammar');
        $array_buttons[] = Button::create('Chat với WSE Team')->value('chat_with_agent');

        $question = Question::create("Bạn có muốn thử những chức năng khác?")
            ->fallback('Chọn 1 trong các chức năng trên!')
            ->callbackId('create_database_1')
            ->addButtons($array_buttons);

        $this->ask($question, function(Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                $selectedValue = $answer->getValue();
                switch ($selectedValue)
                {
                    case "try_book_appointment" : $this->say('lấy sách');break;//$this->bot->startConversation(new BookingAppointmentConversation());
                    case "try_test_quiz_english" : $this->say('test');break;//$this->bot->startConversation(new TestAndQuizConversation());
                    default : return $this->repeat();
                }
            } else {
                if (!empty(trim($answer->getText())))
                    return $this->repeat();
            }
        });
    }
}