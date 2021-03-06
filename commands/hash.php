<?php

$hash = function ($who, $message, $type) {

    $bot = actionAPI::getBot();

    if (!isset($message[1]) || empty($message[1]) || !isset($message[2]) || empty($message[2])) {
        return $bot->network->sendMessageAutoDetection($who, 'Usage: !hash [algorithm] [text]', $type, true);
    }
    
    if (in_array(strtolower($message[1]), hash_algos())) {
        $bot->network->sendMessageAutoDetection($who, hash(strtolower($message[1]), $message[2]), $type, true);
    }
};
