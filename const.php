<?php
//  author @github/Scobber
//
//  const.php
//  Holds the Globals.
//
//
//
//
//  This file in the example is licensed under
//  GNU Affero General Public License v3.0
//  Please see LICENSE.md for more information
//
$apiKey = 'ndefqSsQmMgRk6mij2ynVfwOkG0lATOW';   // This is the Unifi API key. Get this from your controller - settings - users - username
$domain = '172.18.2.35';                        //  this is the ip / DNS name for the unifi video server.
$port = '7443';                                 //  SSL port of the unifi-video server

// This array is what controls which grid of cameras to select.
// The script should be called by /load.php?selector={array name}&size={1080|2160}
// add more sizes and configurations below.
// each array must have the hash from each camera feed. These hashes do not change unless you delete and readd a camera.
// so therefore you must have every video stream you want defined here. The ones below illustrate what to look for.
// the easiest way to get these hashes are to use your browsers developer tools and watch the network comms for the URI's
//
// !! Why this is important !!
// This script calls a HTTP request on the camera ID, which will return a dynamic uri where the feed is located.
// array("selector1" => array("camid1", "camid2", "camid3", "camid4" ...), "selector2" => array("camid1", "camid2", "camid3", "camid4" ...), ...) and so on
$camidarr = array("bricks" => array("5dde08b723f2a7b6e5897429", "5dde08b723f2a7b6e589742b", "5dde08b723f2a7b6e589742c", "5dde08b723f2a7b6e589742a"),
    "operations2" => array("5dde08b723f2a7b6e5897429", "5dde08b723f2a7b6e589742b", "5ee6d51d20fca0448d46745d", "5dde08b723f2a7b6e5897430",
        "5dde08b723f2a7b6e589742c", "5dde08b723f2a7b6e589742a", "5ee6d51d20fca0448d46745e", "5ee6d51a20fca0448d46745c",
        "5dde08b723f2a7b6e589742d", "5dde08b723f2a7b6e589742f", "5dde08b723f2a7b6e589742e", "5dde08b723f2a7b6e5897428"),
    "operations" => array("5ee6d51d20fca0448d46745d", "5dde08b723f2a7b6e5897430", "5ee6d51d20fca0448d46745e", "5ee6d51a20fca0448d46745c"));


if (isset($_GET['size'])) {
    $size = $_GET['size'];
} else {
    $size = 1080;
}

//overrides divisions for 4k screen
if ($size == 2160) {
    $divisions = 3;
} else {
    $divisions = 2;
}

