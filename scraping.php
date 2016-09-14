
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

       //echo $doc["title"]->text();
       //echo $doc["title"];

      if (strstr($url, 'yahoo')) {
       echo "yahooです";
      } else if  (strstr($url, 'fc2'))  {
       echo "fc2です";
      }

      if (strstr($url, 'yahoo')) {
       echo "yahooです";
       if (isset($doc[".rte clearFix"])){
          print('rteありますすす<br><br>');
          echo $doc[".rte clearFix"]->text()."<br /><hr />";
       }else if(isset($doc[".entryTd"])){
          print('entryTdありますすすすｓ<br><br>');
          echo $doc[".entryTd"]->text()."<br /><hr />";
       }else if(isset($doc[".entryBody"])){
          print('entrybodyありますすすすｓ<br><br>');
          echo $doc[".entryBody"]->text()."<br /><hr />";
        }
      }else if  (strstr($url, 'ameblo.jp')) {
             echo "amebloです";
             if (isset($doc[".skin-entryBody"])){
                print('skinありますすす<br><br>');
                echo $doc[".skin-entryBody"]->text()."<br /><hr />";
             }else if(isset($doc[".articleText"])){
                print('articleTextありますすすすｓ<br><br>');
                echo $doc[".articleText"]->text()."<br /><hr />";
             }else if(isset($doc[".subContentsInner"])){
                print('subContentsInnerありますすすすｓ<br><br>');
                echo $doc[".subContentsInner"]->text()."<br /><hr />";
        }
      }else if  (strstr($url, 'fc2')) {
             echo "fc2です";
             if (isset($doc[".entry_body"])){
                print('entry_bodyありますすす<br><br>');
                echo $doc[".entry_body"]->text()."<br /><hr />";
             }else if(isset($doc[".main_body"])){
                print('main_bodyありますすすすｓ<br><br>');
                echo $doc[".main_body"]->text()."<br /><hr />";
             }else if(isset($doc[".contents_body"])){
                print('contents_bodyありますすすすｓ<br><br>');
                echo $doc[".contents_body"]->text()."<br /><hr />";
              }else if(isset($doc[".entry-content"])){
                 print('entry-contentありますすすすｓ<br><br>');
                 echo $doc[".entry-content"]->text()."<br /><hr />";
              }else if(isset($doc[".inner-contents"])){
                 print('inner-contentsありますすすすｓ<br><br>');
                 echo $doc[".inner-contents"]->text()."<br /><hr />";
              }else if(isset($doc[".entry_text"])){
                 print('entry_textありますすすすｓ<br><br>');
                 echo $doc[".entry_text"]->text()."<br /><hr />";
              }else{
          echo "このページは対応していません";
        }
     }
   }
?>
