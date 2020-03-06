< !DOCTYPE html >
  <
  html lang = "en" >
  <
  head >
  <
  title > Редактирование завершено < /title> <
  meta http - equiv = "Content-Type"
content = "text/html; charset=utf-8" / >

  <
  ? php
require "../config.php";
$a = $_POST['a'];
$act = $_POST['act'];
$fname = $_POST['fname'];
$nname = $_POST['lname'];
$id = $_POST['id'];
$fn = $tpl.
'/'.$a.
'.tpl';
$ta = $_POST['TA'];
$lnames = $_POST['lname'];
//$nbasename=$_POST['nbasename'];
$uploaddir = '../'.$tpl.
'/news/files/';
//echo $ta;

if ($act == '4') {
  $dbn = new PDO("sqlite:../".$nbasename, '', '');
  $r = $dbn - > exec("update `TEXT` set nname='".$nname.
    "', ts=CURRENT_TIMESTAMP, upd=1 where id=$id");
  $sth = $dbn - > prepare("select * from `TEXT` where id=".$id);
  $sth - > execute();
  $r = $sth - > fetch(PDO::FETCH_ASSOC);
  $tfn = '../'.$tpl.
  '/news/'.$id.
  '_'.$r['fname'];
  echo $tfn;
  file_put_contents($tfn, $ta);
  $uploadfile = $uploaddir.basename($id.
    '_'.$_FILES['userfile']['name']);
  if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    //echo "Файл корректен и был успешно загружен.\n";
    $r = $dbn - > exec("update `TEXT` set dop='".$uploadfile.
      "' where id=".$id);
  } else {
    echo "Ошибка загрузки картинки\n";
  }
  $res = $id;
}


if ($act != '4') {
  $t = md5(uniqid("")); // без префикса
  $token = md5(uniqid(rand(), 1)); // лучше, труднее взломать
  $fn = $token.
  '.nws';

  $dbn = new PDO("sqlite:../".$nbasename, '', '');
  $r = $dbn - > exec("insert into `TEXT` (id,fname,nname,dt,dop) values(null,'".$fn.
    "','".$lnames.
    "','','')");
  $res = $dbn - > lastInsertID();
  //echo $res.'-'.$r;
  //print_r ($dbn->errorInfo());
  file_put_contents('../'.$tpl.
    '/news/'.$res.
    '_'.$fn, $ta);

  $uploadfile = $uploaddir.basename($res.
    '_'.$_FILES['userfile']['name']);
  //echo $uploadfile;
  if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    //echo "Файл корректен и был успешно загружен.\n";
    $r = $dbn - > exec("update `TEXT` set dop='".$uploadfile.
      "' where id=".$res);
  } else {
    echo "Ошибка загрузки картинки\n";
  }
}
$dbn = null;

if ($res != 0) {
  echo "<font color=green><center>Завершено успешно</font><br>";
} else { //http://byhov-cge.by/index.php?p=new&n=16
  echo "<center><font color=red>Ошибка добавления новости</font><br>";
}
echo "<a href='../index.php?p=new&n=".$res.
"'>Посмотреть результат</a><br>";
echo "<a href='../dm.php'>Перейти в панель управления</a></center>"; ?
>
<
/body> <
/html>