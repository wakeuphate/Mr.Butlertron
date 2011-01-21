<?php
include_once('lib/SmartIRC.php');
class butlertron
{
  
  function youtube(&$irc, &$data)
  {
    $videoUrl = parse_url($data->message);
    parse_str($videoUrl['query'], $videoID);
    
    $youtubeXML = simplexml_load_string(file_get_contents("http://gdata.youtube.com/feeds/api/videos/".$videoID['v']."?fields=title"));
    $videoTitle = (string)$youtubeXML->title;
    
    $irc->message(SMARTIRC_TYPE_CHANNEL, $data->channel, $videoTitle); 
  }
  
  // http://live.xbox.com/en-US/MessageCenter/Compose?gamertag=phattycorpuscle&gt=phattycorpuscle
  //todo: @msggt username 
  function msggt(&$irc, &$data)
  {
    $irc->message(SMARTIRC_TYPE_CHANNEL, $data->channel, 'Not ready yet'); 
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
$irc->registerActionhandler(SMARTIRC_TYPE_CHANNEL, '^@msggt', $bot, 'msggt');
$irc->registerActionhandler(SMARTIRC_TYPE_QUERY|SMARTIRC_TYPE_NOTICE, '^!quit', $bot, 'quit');
$irc->connect('irc.synirc.net', 6667);
$irc->login('MrButlertron', 'Mr. Butlertron', 0, 'MrButlertron');
$irc->join(array('#butlertron'));
$irc->listen();
$irc->disconnect();
?>