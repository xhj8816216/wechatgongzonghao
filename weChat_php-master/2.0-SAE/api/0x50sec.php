<?php
header('Content-type:text/html;charset=utf-8');
function sec0x50(){
    $data=array();
    $url='http://www.0x50sec.org/feed/';
    $result=file_get_contents($url);
    $xml=simplexml_load_string($result,'SimpleXMLElement', LIBXML_NOCDATA);
    
    for ($i=0; $i < 6; $i++) {
    	array_push($data,array('title'=>$xml->channel->item[$i]->title,'description'=>$xml->channel->item[$i]->description,'link'=>$xml->channel->item[$i]->link));
    }

    return $data;
}

print_r(sec0x50());

?>