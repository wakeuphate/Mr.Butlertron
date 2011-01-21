<?php
include_once('lib/SmartIRC.php');
class butlertron
{
  
  function youtube(&$irc, &$data)
  {
    if(preg_match('/http:\/\/www\.youtube[^"]+/', $data->message, $matches) != 0)
    {
      $irc->message(SMARTIRC_TYPE_CHANNEL, '#butlertron', 'Mate, You just posted this youtube link: '.$matches[0]); 
    }
  }
  
  
  //todo: authentication for turning mr butlertron off, not based on username.
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
$irc->registerActionhandler(SMARTIRC_TYPE_CHANNEL, '/http:\/\/www\.youtube[^"]+/', $bot, 'youtube');
$irc->registerActionhandler(SMARTIRC_TYPE_QUERY|SMARTIRC_TYPE_NOTICE, '^!quit', $bot, 'quit');
$irc->connect('irc.synirc.net', 6667);
$irc->login('MrButlertron', 'Mr. Butlertron', 0, 'MrButlertron');
$irc->join('#butlertron');
$irc->listen();
$irc->disconnect();
?>