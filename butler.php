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
    
    $irc->message(SMARTIRC_TYPE_CHANNEL, $data->channel, chr(2).'Title: '.chr(2).$videoTitle); 
  }
  
  // http://live.xbox.com/en-US/MessageCenter/Compose?gamertag=phattycorpuscle&gt=phattycorpuscle
  //todo: @msggt username 
  function msggt(&$irc, &$data)
  {
    $gamertag = substr($data->message, 7);
    $liveUrl = 'http://live.xbox.com/en-US/MessageCenter/Compose?gamertag='.$gamertag.'&gt='.$gamertag;
    $short = file_get_contents('http://tinyurl.com/api-create.php?url='.$liveUrl);
    $irc->message(SMARTIRC_TYPE_CHANNEL, $data->channel, chr(2).'Message '.$gamertag.': '.chr(2).$short);
  }
  
  function profile(&$irc, &$data)
  {
    $gamertag = substr($data->message, 9);
    $liveUrl = 'http://live.xbox.com/en-US/MyXbox/Profile?gamertag='.$gamertag;
    $short = file_get_contents('http://tinyurl.com/api-create.php?url='.$liveUrl);
    $irc->message(SMARTIRC_TYPE_CHANNEL, $data->channel, chr(2).$gamertag.': '.chr(2).$short);
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
$irc->registerActionhandler(SMARTIRC_TYPE_CHANNEL, '^@profile', $bot, 'profile');
$irc->registerActionhandler(SMARTIRC_TYPE_QUERY|SMARTIRC_TYPE_NOTICE, '^!quit', $bot, 'quit');
$irc->connect('irc.synirc.net', 6667);
$irc->login('MrButlertron', 'Mr. Butlertron', 0, 'MrButlertron');
$irc->join(array('#butlertron', '#uguu'));
$irc->listen();
$irc->disconnect();
?>