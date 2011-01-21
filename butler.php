<?php
include_once('lib/SmartIRC.php');
class butlertron
{
    function test(&$irc, &$data)
    {
        $irc->message(SMARTIRC_TYPE_CHANNEL, '#butlertron', $data->nick.': It works!');
    }
    function quit(&$irc, &$data)
    {
            if ($data->nick == "Wakeuphate")
            {
                $irc->disconnect();
            }
    }
}
$bot = &new butlertron();
$irc = &new Net_SmartIRC();
$irc->setDebug(SMARTIRC_DEBUG_ALL);
$irc->setUseSockets(TRUE);
$irc->registerActionhandler(SMARTIRC_TYPE_CHANNEL, '^!test', $bot, 'test');
$irc->registerActionhandler(SMARTIRC_TYPE_CHANNEL, '^!quit', $bot, 'quit');
$irc->connect('irc.synirc.net', 6667);
$irc->login('MrButlertron', 'Mr. Butlertron', 0, 'MrButlertron');
$irc->join('#butlertron');
$irc->listen();
$irc->disconnect();
?>