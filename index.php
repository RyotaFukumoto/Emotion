
<!DOCTYPE HTML>
<?php
	//マルチバイト対応
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

	//検索処理
	if(isset($_GET['submit'])){
		// $likedislikes = 0;
		$like = 0;
		$dislike = 0;
		// $joysads = 0;
		$joy = 0;
		$sad = 0;
		// $angerfears = 0;
		$anger = 0;
		$fear = 0;
		$counts = 0;
		$text = "";
		//require
		require_once('phpQuery-onefile.php');
		//URLデコード
		$url = urldecode( $_GET["url"]);

		//要素取得
		if (strstr($url, 'yahoo')) {
			//ページ取得
			$html = file_get_contents($url);
			//DOM取得
			$doc = phpQuery::newDocument($html);

			// 	echo "yahooです";
		 	if (isset($doc[".rte clearFix"])){
				// print('rteありますすす<br><br>');
				// echo $doc[".rte clearFix"]->text()."<br /><hr />";
				$text = $doc[".rte clearFix"]->text();
		 	}else if(isset($doc[".entryTd"])){
				// print('entryTdありますすすすｓ<br><br>');
				// echo $doc[".entryTd"]->text()."<br /><hr />";
				$text = $doc[".entryTd"]->text();
		 	}else if(isset($doc[".entryBody"])){
				// print('entrybodyありますすすすｓ<br><br>');
				// echo $doc[".entryBody"]->text()."<br /><hr />";
				$text = $doc["entryBody"]->text();
			}
		}else if  (strstr($url, 'ameblo.jp')) {
			//ページ取得
			$html = file_get_contents($url);
			//DOM取得
			$doc = phpQuery::newDocument($html);

			// echo "amebloです";
			if (isset($doc[".skin-entryBody"])){
				// print('skinありますすす<br><br>');
				// echo $doc[".skin-entryBody"]->text()."<br /><hr />";
				$text = $doc[".skin-entryBody"]->text();
		 	}else if(isset($doc[".articleText"])){
				// print('articleTextありますすすすｓ<br><br>');
				// echo $doc[".articleText"]->text()."<br /><hr />";
				$text = $doc[".articleText"]->text();
			}else if(isset($doc[".subContentsInner"])){
				// print('subContentsInnerありますすすすｓ<br><br>');
				// echo $doc[".subContentsInner"]->text()."<br /><hr />";
				$text = $doc[".subContentsInner"]->text();
			}
		}else if  (strstr($url, 'fc2')) {
			//ページ取得
			$html = file_get_contents($url);
			//DOM取得
			$doc = phpQuery::newDocument($html);

			// echo "fc2です";
			if (isset($doc[".entry_body"])){
				// print('entry_bodyありますすす<br><br>');
				// echo $doc[".entry_body"]->text()."<br /><hr />";
				$text = $doc[".entry_body"]->text();
			}else if(isset($doc[".main_body"])){
				// print('main_bodyありますすすすｓ<br><br>');
				// echo $doc[".main_body"]->text()."<br /><hr />";
				$text = $doc[".main_body"]->text();
			}else if(isset($doc[".contents_body"])){
				// print('contents_bodyありますすすすｓ<br><br>');
				// echo $doc[".contents_body"]->text()."<br /><hr />";
				$text = $doc[".contents_body"]->text();
			}else if(isset($doc[".entry-content"])){
				// print('entry-contentありますすすすｓ<br><br>');
				//  echo $doc[".entry-content"]->text()."<br /><hr />";
				$text = $doc[".entry-content"]->text();
			}else if(isset($doc[".inner-contents"])){
				// print('inner-contentsありますすすすｓ<br><br>');
				//  echo $doc[".inner-contents"]->text()."<br /><hr />";
				$text = $doc[".inner-contents"]->text();
			}else if(isset($doc[".entry_text"])){
				// print('entry_textありますすすすｓ<br><br>');
				//  echo $doc[".entry_text"]->text()."<br /><hr />";
				$text = $doc[".entry_text"]->text();
			}
		}else if(strstr($url, 'livedoor')){
			$html = file_get_contents($url);
			//DOM取得
			$doc = phpQuery::newDocument($html);

			// echo "livedoorです";
			if (isset($doc[".article-body"])){
				// print('article-bodyありますすす<br><br>');
				// echo $doc[".entry_body"]->text()."<br /><hr />";
				$text = $doc[".article-body"]->text();
			}
		}else if(strstr($url, 'goo')){
			$html = file_get_contents($url);
			//DOM取得
			$doc = phpQuery::newDocument($html);

			// echo "gooです";
			if (isset($doc[".entry-body"])){
				// print('entry-bodyありますすす<br><br>');
				// echo $doc[".entry_body"]->text()."<br /><hr />";
				$text = $doc[".entry-body"]->text();
			}
		}else{
			 	$errmess =	"このページは対応していません";
 		}
		$arr =	mb_str_split($text,25);

		// print_r($arr);
		$counts = count($arr);

		# API接続URL作成
		$api_url='http://ap.mextractr.net/ma9/emotion_analyzer?apikey=';
		//apikeyは各自で書き換えてください
		// $api_key='AFA9E3C631DEEB9FE2E9E14114E8DE0E148DB6E4';//福本１
		// $api_key='AF987632250187D34CDFEC31474ADE8AABD2E397';//福本2
		// $api_key='03B9E9231D6C2EACCA2E15C43FA4C9B2934F17D8';//林
		$api_key='A09C2D091C0995F3A08AE6184FBB80A4BBDA38DE';//望月
		$base_url = $api_url.$api_key.'&out=json&text=';

    $proxy = array(
      "http" => array(
      //  "proxy" => "tcp://proxy.kmt.neec.ac.jp:8080",
      //  'request_fulluri' => true,
      ),
    );
    //$proxy_context = stream_context_create($proxy);
		if($counts != 0){
			for ($i=0; $i < $counts ; $i++) {
				$tex = $arr[$i];

		    try{
		      $response = file_get_contents($base_url.$tex,false);
		      $result = json_decode($response,true);
					if(isset($result["analyzed_text"])){
						if($result["likedislike"] > 0){
							$like = $like + ($result["likedislike"] * 5);
						}else {
							$dislike = $dislike + ($result["likedislike"] * -5);
						}
						// $likedislikes = $likedislikes + ($result['likedislike'] *5);
						if($result["joysad"] > 0){
							$joy = $joy + ($result["joysad"] * 5);
						}else {
							$sad = $sad + ($result["joysad"] * -5);
						}
						// $joysads = $joysads + ($result['joysad'] *5);
						if($result["angerfear"] > 0){
							$anger = $anger + ($result["angerfear"] * 5);
						}else {
							$fear = $fear + ($result["angerfear"] * 5);
						}
						// $angerfears = $angerfears + ($result['angerfear'] *5);
					}else{
						$errmess = "APIキーが使用制限に達しました。";
					}
		    }catch(Exception $e){
		      header("Location: index.php");
		    }
			}
		}else {
			unset($like);
			unset($dislike);
			unset($joy);
			unset($sad);
			unset($anger);
			unset($fear);
		}
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
		//グラフ表示
		window.onload = function () {
			var chart = new CanvasJS.Chart("chartContainer", {
				theme: "theme2",//theme1
				title:{
					text: "分析結果"
				},
				animationEnabled: false,   // change to true
				data: [
				{
					// Change type to "bar", "area", "spline", "pie",etc.
					type: "pie",
					dataPoints: [
						<?php
							if($like != 0){
								echo '{ label: "好き",  y: '.$like.  '},';
							}
							if($dislike != 0){
								echo '{ label: "嫌い",  y: '.$dislike.  '},';
							}
							if($joy != 0){
								echo '{ label: "嬉しい",  y: '.$joy.  '},';
							}
							if($sad != 0){
								echo '{ label: "悲しい",  y: '.$sad.  '},';
							}
							if($anger != 0){
								echo '{ label: "怒り",  y: '.$anger.  '},';
							}
							if($fear != 0){
								echo '{ label: "怖い",  y: '.$fear.  '},';
							}
						?>
					]
				}
				]
			});
			chart.render();
		}
  </script>
	<script type="text/javascript">
	 //スペース削除
		function change(str){
			while(str.substr(0,1) == ' ' || str.substr(0,1) == '　'){
				str = str.substr(1);
			}
			return str;
		}
		//null チェック
		function check(frm){
			var url = change(frm.elements['url'].value);
			if(url==""){
				alert("URLを入力してください。");
				return false;
			}else{
				return true;
			}
		}
	</script>
	<style type="text/css">
		body{
			background: url(haikei.jpg) no-repeat center center fixed;
          -webkit-background-size:cover;
          -moz-background-size:cover;
          -o-background-size:cover;
          background-size:cover;
          height: 100%;
		}
		.aaa{
			width: 60%;
			margin: auto;
			margin-top: 5%;
		}
		@media screen and (max-width:650px){
			.aaa{
				width: 90%;
				margin-top: 10%;
			}
		}
		</style>
		<title>感情分析</title>
</head>
<body>
		<div class="container">
			<div class= "center-block" >
				<div style="text-align:center;margin-bottom:10px;">
					<a href="./index.php" ><img src="frame.jpg" style="height:100px;"></a>
				</div>
				<div>
					<form action=""　method="get" class="form-inline" onsubmit="return check(this)">
						<!-- input type="text" name="text"　placeholder="テキストを入力してください"> -->
						<div class="row" style="text-align:center;">
							<div class="col-xs-10 col-md-10">
								<input type="text" name="url" class="form-control" id="url" placeholder="URLを入力してください。" style="width:100%">
							</div>
							<div class="col-xs-2 col-md-2">
								<button type="submit" name="submit"　value="" class="btn btn-default" style="width:100%">検索</button>
							</div>
						</div>

						<label style="color: #ff0000;"><?php
						 	if(isset($errmess)){
								// echo '<span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>'.$errmess;
								echo '<div class="alert alert-warning alert-dismissible fade in" role="alert">';
								echo '<button type="button" class="close" data-dismiss="alert">';
								echo '<span aria-hidden="true">×</span>';
								echo '</button>';
								echo '<strong>'.$errmess.'</strong>アラート';
								echo '<p><a href="#" data-dismiss="alert">閉じる</a></p>';
								echo '</div>';
							}
						 ?></label>
					</form>
				</div>
			</div><!-- center-bloc end-->
			<div style="text-align:center;">
				<div id="chartContainer" style="height: 250px; width: 100%;margin:auto"></div>
			</div>
		</div>
	</body>
</html>
