
<!doctype html>
<html>
  <head>
    <title>
      スクレイピングテスト
    </title>
  </head>
  <body>
    <form method="get" action="">
      <input type="text" name="url" id="url" placeholder="URLを入力してください。">
      <button type="submit" name="search" value="serch">検索</button>
    </form>
    <hr />
  </body>
</html>
<?php
  if(isset($_GET["search"])){
      //require
      require_once('phpQuery-onefile.php');

      // ini_set('user_agent', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/47.0.2526.73 Safari/537.36');
      //ページ取得

      $url = urldecode( $_GET["url"]);
      $html = file_get_contents($url);

      //DOM取得
      $doc = phpQuery::newDocument($html);

      //要素取得
      // echo $doc["title"]->text();

      echo "<a href='".$url."'>".$doc["title"]->text()."</a><br /><hr />";
      echo $doc["#article"]->text()."<br /><hr />";
      echo $doc["p"]->text()."<br /><hr />";
      echo $doc[".maintxt"]->text()."<br /><hr />";
      echo $doc["#main"]->text()."<br /><hr />";
      echo $doc["blockquote"]->text()."<br /><hr />";
      echo $doc["div"]->text()."<br />";
    }
?>
