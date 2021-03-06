<?php

$onTickle = function ($who, $array) {

    $bot = actionAPI::getBot();

    if (!isset($array['t'])) {
        return;
    }

    switch (substr($array['t'], 0, 2)) {
        case '/l':

            $key = 'tickle_' . $array['u'];
            if (!dataAPI::is_set($key)) {
                dataAPI::set($key, 0);
            }

            // Answer to tickle every 5 seconds
            if (time() - dataAPI::get($key) >= 5) {
                dataAPI::set($key, time());
                $bot->network->answerTickle($who);
            } else if (time() - dataAPI::get($key) <= 5) {
                dataAPI::set($key, time());
                if ($bot->botData['gameban_unban'] == 1) {
                    if (isset($bot->users[$who]) 
                    && is_object($bot->users[$who])
                    && $bot->users[$who]->isGamebanned()) {
                        $powers = xatVariables::getPowers();
                        $bot->network->unban($who);
                        $bot->network->sendMessage("{$bot->users[$who]->getRegname()} rapid tickled me to get unbanned from the gameban '{$powers[$bot->users[$who]->getGameban()]['name']}'.");
                    }
                }
            } else {
                return;
            }

            break;

        case '/a':

            if (!isset($bot->users[$who])) {
                return;
            }

            if (isset($array['po'])) {
                $bot->users[$who]->setDoubles($array['po']);
            }

            if (isset($array['x'])) {
                $bot->users[$who]->setXats($array['x']);
            }

            if (isset($array['y'])) {
                $bot->users[$who]->setDays($array['y']);
            }

            $bot->users[$who]->setPowers($array);

            break;

    }

    return;
};
