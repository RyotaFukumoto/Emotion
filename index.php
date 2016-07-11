<?php
	if(isset($_GET['submit'])){

	}
?>
<!DOCTYPE HTML>
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
						{ label: "like,dislike",  y: -25  },
						{ label: "joy,sad", y: 15  },
						{ label: "anger,fear", y: 10  },
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
