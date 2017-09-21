<!DOCTYPE html><head><meta charset="utf-8" /><title>■文字列検索■</title></head><body>
<?php
$dirName = realpath ( './' );
$counter = 0;
// ディレクトリからディレクトリ・ファイル名を昇順で取得します。
$fileArrayAsc = scandir ( $dirName );
  $str = empty($_GET['str'])? '' : $_GET['str'];
  if(!empty($str)){
    recursiv ( $dirName );
  }

function recursiv($dirName) {
  global $str;
  // ディレクトリからディレクトリ・ファイル名を昇順で取得します。
  $fileArrayAsc = scandir ( $dirName  );
  
  unset($fileArrayAsc[0],$fileArrayAsc[1]);
  
  foreach ( $fileArrayAsc as $val ) {
    
    $path_parts = pathinfo ( $val ); // ファイル情報取得
    $basename = $path_parts ['basename'];
    $kac = $path_parts ['extension']; // 拡張子取得
      $f = $dirName . "/" . $val;
    
    if (! is_dir ( $f ) ){
      if (preg_match ( '/php|html|htm|txt|csv|css|js|cgi|json|htaccess|log/', $kac )
          && $val != basename($_SERVER['PHP_SELF'])  // 検索対象から自分を省く
          ) {
       wserch($f, $str);// ファイル内検索実行関数
      }
    } else { // 拡張子がない=ディレクトリなら
        recursiv ( $f );
    }
  }
  
}


function wserch($fname, $s) {
  $buffer = @file_get_contents ( $fname );  // ファイルオープン
  //var_dump (strstr (  h ( $buffer ), $s ));exit ();
  if(!empty($buffer))
    if (strstr ( $buffer, $s ))   // postされた文字列が含まれる場合はtrue
      echo "<li>" . $fname . "</li>";
     
}




function h($var) { // HTMLでのエスケープ処理をする関数
  if (is_array ( $var )) {
    return array_map ( 'h', $var );
  } else {
    return htmlspecialchars ( $var, ENT_QUOTES );
  }
}
?>
<form action="" method="get">
  <input type="text" name="str" placeholder="検索したい文字" style="width: 25em";/>
  <input type="submit" value=" Search "/>
</form>
</body>
</html>