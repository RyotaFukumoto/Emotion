
<!DOCTYPE HTML>
<?php
	if(isset($_GET['submit'])){
		$likedislikes = 0;
		$joysads = 0;
		$angerfears = 0;
		$counts = 0;
		$arr =	mb_str_split($_GET['text'],25);

		print_r($arr);
		$counts = count($arr);

			# code...
			$api_url='http://ap.mextractr.net/ma9/emotion_analyzer?apikey=';
			//$api_key='AFA9E3C631DEEB9FE2E9E14114E8DE0E148DB6E4';
			$api_key='AF987632250187D34CDFEC31474ADE8AABD2E397';//apikeyは各自で書き換えてください
			$base_url = $api_url.$api_key.'&out=json&text=';

			    $proxy = array(
			      "http" => array(
			      //  "proxy" => "tcp://proxy.kmt.neec.ac.jp:8080",
			      //  'request_fulluri' => true,
			      ),
			    );
			    //$proxy_context = stream_context_create($proxy);
					for ($i=0; $i < $counts ; $i++) {
						$tex = $arr[$i];

				    try{
				      $response = file_get_contents($base_url.$tex,false);
				      $result = json_decode($response,true);
							$result['likedislike'] *5;
							$result['joysad'] *5;
							$result['angerfear'] *5;
							$likedislikes = $likedislikes + $result['likedislike'];
							$joysads = $joysads + $result['joysad'] ;
							$angerfears = $angerfears + $result['angerfear'];
				    }catch(Exception $e){
				      header("Location: index.php");
				    }
					}
				echo "joysad".$joysads."　";
				echo "likedislike".$likedislikes."　";
				echo "angerfear".$angerfears;
		}


?>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link href="../tmp/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="../tmp/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../canvasjs/canvasjs.min.js"></script>
	<script type="text/javascript">
		window.onload = function () {
			var chart = new CanvasJS.Chart("chartContainer", {
				theme: "theme2",//theme1
				title:{
					text: "result"
				},
				animationEnabled: false,   // change to true
				data: [
				{
					// Change type to "bar", "area", "spline", "pie",etc.
					type: "column",
					dataPoints: [
						{ label: "like,dislike",  y: <?php echo $likedislikes?>  },
						{ label: "joy,sad", y: <?php echo $joysads?>  },
						{ label: "anger,fear", y: <?php echo $angerfears?> },
					]
				}
				]
			});
			chart.render();
		}
  </script>
	<script type="text/javascript">
		function change(str){
			while(str.substr(0,1) == ' ' || str.substr(0,1) == '　'){
				str = str.substr(1);
			}
			return str;
		}
		function check(frm){
			var url = change(frm.elements['url'].value);
			if(url==""){
				alert("urlを入力してください。");
				return false;
			}else{
				return true;
			}
		}
	</script>
</head>
<body>
	<div style="text-align:center;">
		<form action=""　method="get" onsubmit="return check(this)">
			<input type="text" name="url"　placeholder="URLを入力してください" >
			<button type="submit" name="submit"　value="">検索</button>
		</form>
	</div>
	<div style="text-align:center;">
		<div id="chartContainer" style="height: 250px; width: 80%;margin:auto"></div>
	</div>
</body>
</html>
<?php
function mb_str_split($str, $split_len = 1) {

	mb_internal_encoding('UTF-8');
	mb_regex_encoding('UTF-8');

	if ($split_len <= 0) {
			$split_len = 1;
	}

	$strlen = mb_strlen($str, 'UTF-8');
	$ret    = array();

	for ($i = 0; $i < $strlen; $i += $split_len) {
			$ret[ ] = mb_substr($str, $i, $split_len);
	}
	return $ret;
}
 ?>
