<?php
ini_set('display_errors', '1');
class Camera
{
public $id;
public $width;
public $streamid;
}
$defaultWidth=640;
$i = 0;
$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);

$apiKey = 'feT7rEtOVJafNw61jE5jmX7ge5P6NjYI';
$domain = '172.18.2.41';
$port = '7443';
$url = 'https://'.$domain.':'.$port.'/api/2.0/camera?apiKey='.$apiKey;
$json = file_get_contents($url, false, stream_context_create($arrContextOptions));
$cameraCount = count(json_decode($json, true)["data"]) - 1;
?>
<html>
    <head>
        <title>CFL AllCamera Feed.</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=1080, initial-scale=1.0">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="style.css">
		<script>
  		function resizeIframe(obj) {
		//	  alert(obj[0].contentWindow.document.body.scrollHeight)
    	obj[0].style.height = obj[0].contentWindow.document.body.scrollHeight + 'px';
		obj[0].style.width = obj[0].contentWindow.document.body.scrollWidth + 'px';
		  }

		$(function() {
		setInterval(function(){ 
			
		$("iframe").each(function() { 
		//resizeIframe($(this)); 
		});


		 }, 3000);
		});

		</script>
</head>
<body>
<?php
for ($i = 0; $i <= $cameraCount; $i++) {
	$camera[$i] = new Camera;
	$camera[$i]->id = json_decode($json, true)["data"][$i]["_id"];
	$camera[$i]->width = $defaultWidth;
	$camera[$i]->streamid = json_decode(file_get_contents('https://'.$domain.':'.$port.'/api/2.0/stream/'. $camera[$i]->id .'/1/url?apiKey=feT7rEtOVJafNw61jE5jmX7ge5P6NjYI',false,stream_context_create($arrContextOptions)),true)["data"][0]["streamName"];
	}
$max = count($camera) - 1;

for ($x = 0; $x <= $max; $x++) {
	//if(($x==3)||($x=6)) { echo "<div class=\"row\">";}
	echo "<iframe class=\"col-3\" src=\"https://cosmos.careys.com.au/evovideo/OpenCameraByID.php?camid=". $camera[$x]->streamid ."\" width=\"1024\" height=\"433\" frameborder=\"0\" style=\"overflow:hidden;\"></iframe>";
	//echo "\t<div class=\"camera grid\" data-cameraid=\"".$camera[$x]->id."\" data-width=\"".$camera[$x]->width."\" data-poll=\"true\" data-id=\"".$camera[$x]->streamid."\"></div>\r\n";
	//if(($x==3)||($x==6)) { echo "</div>";}
	
} 
?>
</body>
</html>