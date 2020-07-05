<?php
//  author @github/Scobber
//
//  OpenCameraByID.php
//  Loads the video stream
//
//
//
//
//  This file in the example is licensed under
//  GNU Affero General Public License v3.0
//  Please see LICENSE.md for more information
//
require("const.php");
$camid = $_GET['camid'];

$cols = 12 / $divisions;
$modwidth = $size / $divisions;
if ($divisions == 4)
    $modheight = ($size / $divisions) - ($size / $divisions) / $divisions;
else
    $modheight = ($size / $divisions);

?>
<html>
<head>
    <title>Live EvoStream WebSocket Video</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=<?php echo $modwidth; ?>;height=<?php echo $modheight; ?>, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>

    <script src="evostream.min.js"></script>
    <script>
        var ws;
        $(function () {
            setInterval(function () {
                var camhwid = $("#videoElement")[0]
                if (camhwid.paused == true) {
                    startPlay('wss://<?php echo $domain;?>:<?php echo $port;?>/<?php echo $camid;?>');
                }
            }, 60000);
        });

        function startPlay(uri) {

            initializePlayer();

            var streamURI = uri;
            streamURI += "?progressive&rebaseTimestampsToZero&fragmentDurationMillis=250";

            //connect to the streaming server via WS
            ws = new WebSocket(streamURI);
            ws.binaryType = 'arraybuffer';

            //setup the handler for when data arrives via WS
            ws.onmessage = function (msg) {
                var arrayView = new Uint8Array(msg.data);
                parseData(arrayView);
            };
        }
    </script>
</head>
<body style="margin:0px;padding:0px;overflow:hidden">
<video id="videoElement" width="100%" height="100%" autoplay muted></video>
<br>
<script>
    startPlay('wss://<?php echo $server;?>:<?php echo $port;?>/<?php echo $camid;?>');

</script>
</body>
</html>
 