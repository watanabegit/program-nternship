<html>
<body>



	<?php
	//POST���\�b�h�󂯎��
	$name=$_POST["name"];     //���O
	$kome=$_POST["komento"];  //�R�����g
	$hensyuuketori=$_POST["uketori"];  //�ҏW����ԍ��\��
	$pass=$_POST["password"];  //�p�X���[�h

	touch('mission_2-5_watanabe.txt');  //�t�@�C���쐬
	$filename="mission_2-5_watanabe.txt";
	if (!empty ($name)and(!empty ($kome))and(!empty ($pass))and(empty ($hensyuuketori))){
	$fp=fopen($filename,'a');
	//���e����
	$toukoubi=date("Y")."�N".date("n��j�� G:i:s");
	//���e�ԍ�
	$hairetu=file($filename);
	$toukou=1;
	$toukou=count($hairetu);
	$toukou++;
	//��������
	fwrite($fp,$toukou.'<>'.$name.'<>'.$kome.'<>'.$toukoubi.'<>'.$pass.'<>'."\n");
	fclose($fp);}
	?>


	<?php
	//�폜
	$saku=$_POST["sakuzyo"]; //�폜����ԍ�
	$sakupass=$_POST["sakuzyopassword"]; //�p�X���[�h
	if (!empty ($saku)and(!empty ($sakupass))){
	  $fp=fopen($filename,'r+');//r+�͓ǂݎ��Ə�������
	  $hairetusakuzyo=file($filename);
	  ftruncate($fp,0);//�t�@�C����0�Ɋۂ߂�
	  fseek($fp,0);//�t�@�C���|�C���^��擪�ɖ߂�
	    foreach ($hairetusakuzyo as $valuesakuzyo){
	      $kugiri=explode("<>",$valuesakuzyo);
	        if ($kugiri[0]!==$saku){  //���e�ԍ��ƍ폜����ԍ�����v���邵�Ȃ��Ƃ�
	          fputs($fp,$valuesakuzyo);//��������
		}//if ($kugiri[0]!==$saku)
		    else if ($sakupass!==$kugiri[4]){  //���e�ԍ��ƍ폜����ԍ�����v���邪�A�p�X���[�h����v���Ȃ��Ƃ�
		      fputs($fp,$valuesakuzyo);//��������
		    }//else if ($sakupass!==$kugiri[4])
	    }//foreach
	  fclose($fp);
	  }//if !empty
	?>



	<?php
	//�ҏW
	$hen=$_POST["hensyu"]; //�ҏW����ԍ�
	$henpass=$_POST["hensyupassword"]; //�p�X���[�h
	if (!empty ($hen)){
	  $hairetuhensyu=file($filename);
	    foreach ($hairetuhensyu as $valuehensyu){
	      $kugiri=explode("<>",$valuehensyu);
	        if ($kugiri[0]==$hen and $henpass==$kugiri[4]){  //���e�ԍ��ƕҏW����ԍ�����v����@���@�p�X���[�h����v����Ƃ�
	          $huruiname=$kugiri[1];
	          $huruikome=$kugiri[2];
	         }//if ($kugiri[0]==$hen)
	    }//foreach
	}//if (!empty($hen))
	?>



	<?php
	//�ҏW�㏑��
	if (!empty($hensyuuketori)){
	  $atarasiiname=$_POST["name"];//�ҏW�㖼�O
	  $atarasiikome=$_POST["komento"];//�ҏW��R�����g
	  $timestamp= time(); //���t
	  $toukoubi=date("Y")."�N".date("n��j�� G:i:s",$timestamp);
	  $hairetuhensyu=file($filename);     //�z��

	  $fp=fopen($filename,'w');           //�㏑��
 	    foreach ($hairetuhensyu as $valuehensyu){     //���[�v
	      $kugiri=explode("<>",$valuehensyu);         //���o��
	      $hensyunumber=$kugiri[0];
	        if ($hensyuuketori==$hensyunumber){ //�ԍ���v������㏑��
	          fwrite($fp,$hensyunumber.'<>'.$atarasiiname.'<>'.$atarasiikome.'<>'.$toukoubi);
	        }//if ($hensyuuetori==$hensyunumber)
                    else {fwrite($fp,$valuehensyu); //����ȊO�͂��̂܂܏�������
	            }//else
	    }//foreach
	  fclose($fp);

	}//if(!empty($hensyuuketori))
	?>



<form action="mission_2-5.php" method="POST">
���O�F<br><input type="text" name="name" placeholder="<?php if(empty($POST["hensyu"])) {echo $huruiname;}?>" > <br>
�R�����g:<br><input type="text" name="komento" placeholder="<?php if(empty($POST["hensyu"])) {echo $huruikome;}?>"> <br>
�p�X���[�h:*�p�X���[�h�͕K�����͂��Ă�������<br><input type="text" name="password">

<!--�ҏW����ԍ��\��-->
<input type="hidden" name="uketori" value="<?php if(!empty($_POST["hensyu"]) and $henpass==$kugiri[4]) {echo $hen;}?>" > <!--�ҏW�Ώ۔ԍ�����ł͂Ȃ��@���@�p�X���[�h����v����Ƃ�-->
<input type="submit" value="���M">
<br>
<br>
<br>
�폜�Ώ۔ԍ��F<br><input type="text" name="sakuzyo"> <br>
�p�X���[�h:*���e����ۂɓ��͂����p�X���[�h����͂��Ă�������<br><input type="text" name="sakuzyopassword">  <input type="submit" value="�폜"> <br>
<br>
<br>
�ҏW�Ώ۔ԍ��F<br><input type="text" name="hensyu"> <br>
�p�X���[�h:*���e����ۂɓ��͂����p�X���[�h����͂��Ă�������<br><input type="text" name="hensyupassword">  <input type="submit" value="�ҏW"> <br>
</form>
</form>



	<?php
	//�z��̍쐬�A�ǂݍ��݁A��؂�
	$hairetu=file($filename);
	foreach ($hairetu as $value){
	$kugiri=explode("<>",$value);
	//�\��
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
�������ݕ�<br>
�@�@�V�K���e�̏ꍇ<br>
�@�@�@�E���e�t�H�[���ɁA���O�E�R�����g�i���߂łƂ��I�Ȃǁj�p�X���[�h�i������������Ή��ł��B�폜�E�ҏW�Ɏg�p���܂��j����͂��Ă�������<br>
<br>
<br>
�@�@���e���폜�������ꍇ<br>
�@�@�@�@�폜�t�H�[���ɁA�폜���������e�ԍ��Ɠ��e���ɓ��͂����p�X���[�h����͂��Ă�������<br>
�@�@�@�A�w�肵�����e�ԍ��̖��O�E�R�����g�E���t���폜����Ă��邱�Ƃ��m�F���Ă�������<br>
<br>
<br>
�@�@���e��ҏW�������ꍇ<br>
�@�@�@�@�܂��ҏW�t�H�[���ɁA�ҏW���������e�ԍ��Ɠ��e���ɓ��͂����p�X���[�h����͂��Ă�������<br>
�@�@�@�A���e�t�H�[���ɖ��O�E�R�����g��V���ɓ��͂��Ă�������<br>
�@�@�@�@�@�����Ӂ�<br>
�@�@�@�@�@�ȑO�̓��e���e���ɕ\������܂����A���̂܂ܑ��M����Ƌ󑗐M�����ɂȂ�܂�<br>
�@�@�@�@�@�ύX���Ȃ��ꍇ���K���ȑO�Ɠ������e����͂��Ȃ����Ă�������<br>
�@�@�@�@�@�p�X���[�h��ύX���Ȃ��ꍇ�́A�p�X���[�h����͂��Ȃ����K�v�͂���܂���<br>
�@�@�@�@�@���O�E�R�����g��V���ɓ��͂��p�X���[�h���͂��̂܂܂ő��M���Ă�������<br>
�@�@�@�B���e�̓��e���ύX����Ă��邱�Ƃ��m�F���Ă�������
</body>
</html>