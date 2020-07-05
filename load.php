<?php
//  author @github/Scobber
//
//  load.php
//  Loads the grid matrix for UniFi Video cameras.
//  This code example does not require RTP to be enabled.
//
//  Camera streams are loaded in a similar way to the UniFi NVR
//
//  This file in the example is licensed under
//  GNU Affero General Public License v3.0
//  Please see LICENSE.md for more information
//
ini_set('display_errors', '0'); // hide errors

class Camera
{
    public $id;
    public $width;
    public $streamid;
}

$defaultWidth = 640;
$i = 0;
$arrContextOptions = array(
    "ssl" => array(
        "verify_peer" => false,
        "verify_peer_name" => false,
    ),
);
if (!$_GET['selector']) {
echo "No selector selected";
} else {

    // This part of the script deals with grids. So
    $selector = $_GET['selector'];

    $cols = 12 / $divisions;
    $modWidth = $size / $divisions;
    $modheight = ($size / $divisions);

    $apiKey = 'ndefqSsQmMgRk6mij2ynVfwOkG0lATOW';  // This is the Unifi API key. Get this from your controller - settings - users - username
    $domain = '172.18.2.35';  //  this is the ip / DNS name for the unifi video server.
    $port = '7443';  //  SSL port of the unifi-video server
//$url = 'https://'.$domain.':'.$port.'/api/2.0/camera?apiKey='.$apiKey;
//$json = file_get_contents($url, false, stream_context_create($arrContextOptions));
    $cameraCount = count($camidarr[$selector]) - 1;
    ?>
    <html>
    <head>
        <title>Our Video <?php echo $selector ?> Feeds.</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=<?php echo $size; ?>, initial-scale=1.0">
        <?php if ($selector == "operations")
            echo "        <meta http-equiv=\"refresh\" content=\"3600\">"; // use this to narrowly provision a http refresh for a collection of images.
        else
            echo "        <meta http-equiv=\"refresh\" content=\"120\">";
        ?>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
              integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
              crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
                integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
                crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
                integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
                crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
                integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
                crossorigin="anonymous"></script>
        <link rel="stylesheet" href="style.css">
        <script>
            function resizeIframe(obj) {
                //	  alert(obj[0].contentWindow.document.body.scrollHeight)
                obj[0].style.height = obj[0].contentWindow.document.body.scrollHeight + 'px';
                obj[0].style.width = obj[0].contentWindow.document.body.scrollWidth + 'px';
            }

            $(function () {
                setInterval(function () {

                    $("iframe").each(function () {
                        //resizeIframe($(this));
                    });


                }, 3000);
            });

        </script>
    </head>
    <body style="background-color: black;">
    <?php
    for ($i = 0; $i <= $cameraCount; $i++) {
        $camera[$i] = new Camera;
        $camera[$i]->id = $camidarr[$selector][$i];
        $camera[$i]->width = $defaultWidth;
        $camera[$i]->streamid = json_decode(file_get_contents('https://' . $domain . ':' . $port . '/api/2.0/stream/' . $camera[$i]->id . '/1/url?apiKey=' . $apiKey, false, stream_context_create($arrContextOptions)), true)["data"][0]["streamName"];
    }
    $max = count($camera) - 1;
    // So we use i-frames! This is IMPORTANT as the 'evostream' JS is unable to control more then one video viewport.
    for ($x = 0; $x <= $max; $x++)
        echo "<iframe class=\"col-$cols\" src=\"https://cosmos.careys.com.au/evovideo/OpenCameraByID.php?camid=" . $camera[$x]->streamid . "\" width=\"$modwidth\" height=\"$modheight\" frameborder=\"0\" style=\"overflow:hidden;\"></iframe>";
    ?>
    </body>
    </html>
<?php } ?>