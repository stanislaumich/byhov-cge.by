<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Редактирование и добавление новостей</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript">
      _editor_url = "../htmlarea/";
      _editor_lang = "en";
    </script>
    <script type="text/javascript" src="../htmlarea/htmlarea.js"></script>
    <script type="text/javascript">
      HTMLArea.loadPlugin("FullPage");
      function initDocument() {
        var editor = new HTMLArea("editor");
        editor.registerPlugin(FullPage);
        editor.generate();
      }
      HTMLArea.onload = initDocument;
    </script>
  </head>
  <body onload="HTMLArea.init()">

<?php
 require "../config.php";

 $id=$_GET['id'];
 $act=$_GET['act'];
 $dbn = new PDO("sqlite:../".$nbasename,'','');
 $sth = $dbn->prepare("select * from `TEXT` where id=".$_GET['id']);
 if ($sth){$sth->execute();}
 if ($sth){$r = $sth->fetch(PDO::FETCH_ASSOC);}
 ?>

 <form  enctype="multipart/form-data" method=post action='editsave.php'>   
   <!-- вставка названия новости, описания и картинки -->
   Краткое название новости (только для себя)<input name='sname' type =text value='<?php echo $r['nname'] ?>' size=100> <br>
   Название новости для первой страницы<input name='lname' type =text value='<?php echo $r['nname'] ?>' size=100> <br>
   Фото новости:<input type='file' name='userfile'><br><br>
  <!--   -->
 <textarea id="editor" style="height: 30em; width: 100%;" name='TA'>
 
<?php
 if  ($act=='3'){
     $tfn='../'.$tpl.'/news/'.$r['id'].'_'.$r['fname'];	 
     $tr=file_get_contents($tfn);
	 $act=4;}
  else
     {$tr='';
      $act=1;
	  }
 echo $tr;
 //echo $tfn;
 ////////////////////////////////////////////////////////////////////
 echo"\n\n</textarea>";
 
 echo"<input type=hidden value='".$r['id']."' name='id'>";
 echo"<input type=hidden value='".$r['fname']."' name='fname'>";
 echo"<input type=hidden value='".$r['nname']."' name='nname'>";
 echo"<input type=hidden value='".$act."' name='act'>";
 //!!!!!!!!!echo"<input type=hidden value='".$nbasename."' name='nbasename'>";
?>
<input type=submit value='Готово' action=submit>

</form>
</body>
</html>