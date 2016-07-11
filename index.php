
<!DOCTYPE HTML>
<?php

$aaa = 0;
	if(isset($_GET['submit'])){

		$api_url='http://ap.mextractr.net/ma9/emotion_analyzer?apikey=';
		$api_key='A09C2D091C0995F3A08AE6184FBB80A4BBDA38DE';//apikeyは各自で書き換えてください
		$base_url = $api_url.$api_key.'&out=json&text=';
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
					$aaa = 1;

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

	<?php
if($aaa == 0 ){

}elseif($result['likedislike'] <= -30 && $result['joysad'] <= -30 &&  $result['angerfear'] > 30 ){
echo "とても心が乱れています。:(";
}elseif($result['likedislike'] <= -20 || $result['joysad'] <= -20 &&  $result['angerfear'] > 10 ){
echo "ストレスが溜まっています。";
}elseif ($result['likedislike'] <= -10 || $result['joysad'] <= -10 &&  $result['angerfear'] > 0) {
echo "不快な気分を感じていませんか？";
}elseif ($result['likedislike'] > 30 && $result['joysad'] > 30 &&  $result['angerfear'] <= 0) {
echo "とても幸せな気持ちになっています。";
}elseif ($result['likedislike'] > 20 || $result['joysad'] > 20 &&  $result['angerfear'] <= 0) {
echo "楽しい気持ちになっています";
}elseif ($result['likedislike'] >= 10 || $result['joysad'] >= 10 &&  $result['angerfear'] <= 0) {
echo "楽しい気分です。";
}else{
	echo "平常心です。";
}

?>

</body>
</html>
