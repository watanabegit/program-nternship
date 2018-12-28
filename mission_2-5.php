<html>
<body>



	<?php
	//POSTメソッド受け取り
	$name=$_POST["name"];     //名前
	$kome=$_POST["komento"];  //コメント
	$hensyuuketori=$_POST["uketori"];  //編集する番号表示
	$pass=$_POST["password"];  //パスワード

	touch('mission_2-5_watanabe.txt');  //ファイル作成
	$filename="mission_2-5_watanabe.txt";
	if (!empty ($name)and(!empty ($kome))and(!empty ($pass))and(empty ($hensyuuketori))){
	$fp=fopen($filename,'a');
	//投稿日時
	$toukoubi=date("Y")."年".date("n月j日 G:i:s");
	//投稿番号
	$hairetu=file($filename);
	$toukou=1;
	$toukou=count($hairetu);
	$toukou++;
	//書き込み
	fwrite($fp,$toukou.'<>'.$name.'<>'.$kome.'<>'.$toukoubi.'<>'.$pass.'<>'."\n");
	fclose($fp);}
	?>


	<?php
	//削除
	$saku=$_POST["sakuzyo"]; //削除する番号
	$sakupass=$_POST["sakuzyopassword"]; //パスワード
	if (!empty ($saku)and(!empty ($sakupass))){
	  $fp=fopen($filename,'r+');//r+は読み取りと書き込み
	  $hairetusakuzyo=file($filename);
	  ftruncate($fp,0);//ファイルを0に丸める
	  fseek($fp,0);//ファイルポインタを先頭に戻す
	    foreach ($hairetusakuzyo as $valuesakuzyo){
	      $kugiri=explode("<>",$valuesakuzyo);
	        if ($kugiri[0]!==$saku){  //投稿番号と削除する番号が一致するしないとき
	          fputs($fp,$valuesakuzyo);//書き込む
		}//if ($kugiri[0]!==$saku)
		    else if ($sakupass!==$kugiri[4]){  //投稿番号と削除する番号が一致するが、パスワードが一致しないとき
		      fputs($fp,$valuesakuzyo);//書き込む
		    }//else if ($sakupass!==$kugiri[4])
	    }//foreach
	  fclose($fp);
	  }//if !empty
	?>



	<?php
	//編集
	$hen=$_POST["hensyu"]; //編集する番号
	$henpass=$_POST["hensyupassword"]; //パスワード
	if (!empty ($hen)){
	  $hairetuhensyu=file($filename);
	    foreach ($hairetuhensyu as $valuehensyu){
	      $kugiri=explode("<>",$valuehensyu);
	        if ($kugiri[0]==$hen and $henpass==$kugiri[4]){  //投稿番号と編集する番号が一致する　かつ　パスワードが一致するとき
	          $huruiname=$kugiri[1];
	          $huruikome=$kugiri[2];
	         }//if ($kugiri[0]==$hen)
	    }//foreach
	}//if (!empty($hen))
	?>



	<?php
	//編集上書き
	if (!empty($hensyuuketori)){
	  $atarasiiname=$_POST["name"];//編集後名前
	  $atarasiikome=$_POST["komento"];//編集後コメント
	  $timestamp= time(); //日付
	  $toukoubi=date("Y")."年".date("n月j日 G:i:s",$timestamp);
	  $hairetuhensyu=file($filename);     //配列

	  $fp=fopen($filename,'w');           //上書き
 	    foreach ($hairetuhensyu as $valuehensyu){     //ループ
	      $kugiri=explode("<>",$valuehensyu);         //取り出し
	      $hensyunumber=$kugiri[0];
	        if ($hensyuuketori==$hensyunumber){ //番号一致したら上書き
	          fwrite($fp,$hensyunumber.'<>'.$atarasiiname.'<>'.$atarasiikome.'<>'.$toukoubi);
	        }//if ($hensyuuetori==$hensyunumber)
                    else {fwrite($fp,$valuehensyu); //それ以外はそのまま書き込み
	            }//else
	    }//foreach
	  fclose($fp);

	}//if(!empty($hensyuuketori))
	?>



<form action="mission_2-5.php" method="POST">
名前：<br><input type="text" name="name" placeholder="<?php if(empty($POST["hensyu"])) {echo $huruiname;}?>" > <br>
コメント:<br><input type="text" name="komento" placeholder="<?php if(empty($POST["hensyu"])) {echo $huruikome;}?>"> <br>
パスワード:*パスワードは必ず入力してください<br><input type="text" name="password">

<!--編集する番号表示-->
<input type="hidden" name="uketori" value="<?php if(!empty($_POST["hensyu"]) and $henpass==$kugiri[4]) {echo $hen;}?>" > <!--編集対象番号が空ではない　かつ　パスワードが一致するとき-->
<input type="submit" value="送信">
<br>
<br>
<br>
削除対象番号：<br><input type="text" name="sakuzyo"> <br>
パスワード:*投稿する際に入力したパスワードを入力してください<br><input type="text" name="sakuzyopassword">  <input type="submit" value="削除"> <br>
<br>
<br>
編集対象番号：<br><input type="text" name="hensyu"> <br>
パスワード:*投稿する際に入力したパスワードを入力してください<br><input type="text" name="hensyupassword">  <input type="submit" value="編集"> <br>
</form>
</form>



	<?php
	//配列の作成、読み込み、区切り
	$hairetu=file($filename);
	foreach ($hairetu as $value){
	$kugiri=explode("<>",$value);
	//表示
	echo $kugiri[0].' '.$kugiri[1].' '.$kugiri[2].' '.$kugiri[3]."<br>\n";
	}
	?>


<br>
<br>
<br>
<br>
<br>
<br>
<br>
書き込み方<br>
　　新規投稿の場合<br>
　　　・投稿フォームに、名前・コメント（おめでとう！など）パスワード（自分が分かれば何でも可。削除・編集に使用します）を入力してください<br>
<br>
<br>
　　投稿を削除したい場合<br>
　　　①削除フォームに、削除したい投稿番号と投稿時に入力したパスワードを入力してください<br>
　　　②指定した投稿番号の名前・コメント・日付が削除されていることを確認してください<br>
<br>
<br>
　　投稿を編集したい場合<br>
　　　①まず編集フォームに、編集したい投稿番号と投稿時に入力したパスワードを入力してください<br>
　　　②投稿フォームに名前・コメントを新たに入力してください<br>
　　　　　※注意※<br>
　　　　　以前の投稿が各欄に表示されますが、そのまま送信すると空送信扱いになります<br>
　　　　　変更しない場合も必ず以前と同じ内容を入力しなおしてください<br>
　　　　　パスワードを変更しない場合は、パスワードを入力しなおす必要はありません<br>
　　　　　名前・コメントを新たに入力しパスワード欄はそのままで送信してください<br>
　　　③投稿の内容が変更されていることを確認してください
</body>
</html>