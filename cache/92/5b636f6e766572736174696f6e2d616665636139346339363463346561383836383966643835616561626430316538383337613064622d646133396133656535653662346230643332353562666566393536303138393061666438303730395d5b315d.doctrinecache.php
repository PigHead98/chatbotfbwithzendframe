<?php return unserialize('a:2:{s:8:"lifetime";i:1566560987;s:4:"data";a:5:{s:12:"conversation";O:31:"Application\\Chatbot\\SaveContact":6:{s:12:"' . "\0" . '*' . "\0" . 'firstname";N;s:8:"' . "\0" . '*' . "\0" . 'email";N;s:8:"' . "\0" . '*' . "\0" . 'phone";N;s:9:"' . "\0" . '*' . "\0" . 'idUser";s:16:"2491441967560806";s:8:"' . "\0" . '*' . "\0" . 'token";N;s:12:"' . "\0" . '*' . "\0" . 'cacheTime";N;}s:8:"question";s:52:"s:44:"Xin chào!! Hãy cho tôi biết tên bạn?";";s:20:"additionalParameters";s:6:"a:0:{}";s:4:"next";s:669:"C:32:"Opis\\Closure\\SerializableClosure":623:{a:5:{s:3:"use";a:0:{}s:8:"function";s:286:"function(\\BotMan\\BotMan\\Messages\\Incoming\\Answer $answer) {
            $this->firstname = $answer->getText();
            $this->say(\'Chào \' . $this->firstname);//->say(\'Nice to meet you \'.$this->firstname);
            $this->askEmail();

            // Save result

        }";s:5:"scope";s:31:"Application\\Chatbot\\SaveContact";s:4:"this";O:31:"Application\\Chatbot\\SaveContact":6:{s:12:"' . "\0" . '*' . "\0" . 'firstname";N;s:8:"' . "\0" . '*' . "\0" . 'email";N;s:8:"' . "\0" . '*' . "\0" . 'phone";N;s:9:"' . "\0" . '*' . "\0" . 'idUser";s:16:"2491441967560806";s:8:"' . "\0" . '*' . "\0" . 'token";N;s:12:"' . "\0" . '*' . "\0" . 'cacheTime";N;}s:4:"self";s:32:"000000002914f1cc000000005fe6ebed";}}";s:4:"time";s:21:"0.90155000 1566559187";}}');