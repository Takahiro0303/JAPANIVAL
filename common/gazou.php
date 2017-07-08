<?php

for ($i = 0; $i< count($_FILES["upfile"]["tmp_name"]); $i++) {
  if (is_uploaded_file($_FILES["upfile"]["tmp_name"][$i])) {
    $fileName = "files/".date("[Y-m-d_His]").$_FILES["upfile"]["name"][$i];
    if (file_exists($fileName)===false) {
      if (move_uploaded_file($_FILES["upfile"]["tmp_name"][$i], $fileName)) {
        chmod($fileName, 0644);
        echo $_FILES["upfile"]["name"][$i] . "をアップロードしました。<br>";
      } else {
        echo "アップロードエラー";
      }
    } else {
      echo "既にファイルが存在します。少し時間をおいてやり直してください。";
    }
  } else {
    echo "ファイルが選択されていません";
  }
}

?>

<html>
<head>
  <title>複数画像ファイル選択</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
Files:<input type="file" name="upfile[]" multiple>
<input type="submit" value="submit">
</form>
</body>
</html>
