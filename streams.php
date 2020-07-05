<?php
//  author @github/Scobber
//
//  streams.php
//  Utility to discover stream id's
//
//
//
//
//  This file in the example is licensed under
//  GNU Affero General Public License v3.0
//  Please see LICENSE.md for more information
//
require("const.php");
ini_set('display_errors', '0');
class Camera
{
public $id;
public $width;
public $streamid;
public $name;
}
$defaultWidth=640;
$i = 0;
$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);

$url = 'https://'.$domain.':'.$port.'/api/2.0/camera?apiKey='.$apiKey;
$json = file_get_contents($url, false, stream_context_create($arrContextOptions));
//echo $json;
$cameraCount = count(json_decode($json, true)["data"]) - 1;
for ($i = 0; $i <= $cameraCount; $i++) {
	$camera[$i] = new Camera;
	$camera[$i]->id = json_decode($json, true)["data"][$i]["_id"];
	$camera[$i]->name = json_decode($json, true)["data"][$i]["name"];
	$camera[$i]->width = $defaultWidth;
	$camera[$i]->streamid = json_decode(file_get_contents('https://'.$domain.':'.$port.'/api/2.0/stream/5afbc20362e41cbf1e0f5265/1/url?apiKey=feT7rEtOVJafNw61jE5jmX7ge5P6NjYI',false,stream_context_create($arrContextOptions)),true)["data"][0]["streamName"];
	}
$max = count($camera) - 1;
for ($x = 0; $x <= $max; $x++) {
	echo "\tname: ".$camera[$x]->name. " data-cameraid: ".$camera[$x]->id." stream-id: " .$camera[$x]->streamid."\r\n";
} 