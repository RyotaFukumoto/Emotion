
<!DOCTYPE HTML>
<?php
	if(isset($_GET['submit'])){
		$base_url = 'http://ap.mextractr.net/ma9/emotion_analyzer?apikey=03B9E9231D6C2EACCA2E15C43FA4C9B2934F17D8&out=json&text='; //apikeyは各自で書き換えてください
		    $proxy = array(
		      "http" => array(
		       "proxy" => "tcp://proxy.kmt.neec.ac.jp:8080",
		       'request_fulluri' => true,
		      ),
		    );
		    $proxy_context = stream_context_create($proxy);
		    try{
		      $response = file_get_contents($base_url.$_GET['text'],false,$proxy_context);
		      $result = json_decode($response,true);
					$result['likedislike'] *= 10;
					$result['joysad'] *= 10;
					$result['angerfear'] *= 10;
					echo "joysad".$result['joysad']."　";
					echo "likedislike".$result['likedislike']."　";
					echo "angerfear".$result['angerfear'];
		    }catch(Exception $e){
		      header("Location: index.php");
		    }
	}
?>
<html>
<head>
	<meta charset="utf-8">
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
						{ label: "like,dislike",  y: <?php echo $result['likedislike']?>  },
						{ label: "joy,sad", y: <?php echo $result['joysad']?>  },
						{ label: "anger,fear", y: <?php echo $result['angerfear']?> },
					]
				}
				]
			});
			chart.render();
		}
	</script>
</head>
<body>
	<div style="text-align:center;">
		<form action=""　method="get">
			<input type="text" name="text"　placeholder="テキストを入力してください">
			<button type="submit" name="submit"　value="">検索</button>
		</form>
	</div>
	<div style="text-align:center;">
		<div id="chartContainer" style="height: 250px; width: 80%;margin:auto"></div>
	</div>
</body>
</html>
