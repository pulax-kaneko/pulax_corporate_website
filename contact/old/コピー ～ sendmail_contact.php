<?php header("Content-Type:text/html;charset=Shift_JIS"); ?>
<?php
//==========================================================
//  ���[���t�H�[���V�X�e��
//==========================================================

// ���̃t�@�C���̖��O
$script ="sendmail_contact.php";

// ���[���𑗐M����A�h���X(�����w�肷��ꍇ�́u,�v�ŋ�؂�)
$to = "info@pulax.co.jp";

// ���M����郁�[���̃^�C�g��
$sbj = "�y�z�[���y�[�W����̂��₢���킹�z";

// ���M�m�F��ʂ̕\��(����=1, ���Ȃ�=0)
$chmail = 1;

// ���M��Ɏ����I�ɃW�����v����(����=1, ���Ȃ�=0)
// 0�ɂ���ƁA���M�I����ʂ��\������܂��B
$jpage = 0;

// ���M��ɃW�����v����y�[�W(���M��ɃW�����v����ꍇ)
$next = "http://www.pulax.co.jp/contact/contactform.html";

// ���o�l�́A���M�҂̃��[���A�h���X�ɂ���(����=1, ���Ȃ�=0)
// ����ꍇ�́A���[�����͗���name�������uemail�v�ɂ��Ă��������B
$from_add = 1;

// ���o�l�ɑ��M���e�m�F���[���𑗂�(����=1, ����Ȃ�=0)
// ����ꍇ�́A���[�����͗���name�������uemail�v�ɂ��Ă��������B
$remail = 1;

// ���o�l�ɑ��M�m�F���[���𑗂�ꍇ�̃��[���̃^�C�g��
$resbj = "���₢���킹���肪�Ƃ��������܂����y������Ѓv���b�N�X�z";

// �K�{���͍��ڂ�ݒ肷��(����=1, ���Ȃ�=0)
$esse = 1;

// �K�{���͍���(���̓t�H�[���Ŏw�肵��name)
$eles = array('�M�Ж�','���S���Җ�','���S���҃t���K�i','email','TEL');


//--------------------------------------------------------------------
// �ȏ�Ŋ�{�I�Ȑݒ�͏I���ł��B
// �ȉ��̕ύX�͎��ȐӔC�ł��肢���܂��B(�s���̓f�t�H���g��)
// �����͉�ʂ̃��C�A�E�g �� 88�s�ڎ���
// ���M���[���̃��C�A�E�g �� 103�s�ڎ���
// ���o�l�ւ̑��M�m�F���[���̃��C�A�E�g �� 128�s�ڎ���
// ���M�m�F��ʂ̃��C�A�E�g �� 163�s�ڎ���
// ���M�I����ʂ̃��C�A�E�g �� 194�s�ڎ���
// ���M�m�F��ʂ�I����ʂ̃w�b�_�ƃt�b�^ �� 209�s�ڎ���
//--------------------------------------------------------------------

$sendm = 0;
foreach($_POST as $key=>$var) {
  if($var == "eweb_submit") $sendm = 1;
}

// �����̒u������
$string_from = "�_";
$string_to = "�[";

// �����͍��ڂ̃`�F�b�N
if($esse == 1) {
  $flag = 0;
  $length = count($eles) - 1;
  foreach($_POST as $key=>$var) {
    $key = strtr($key, $string_from, $string_to);
    if($var == "eweb_submit") ;
    else {
      for($i=0; $i<=$length; $i++) {
        if($key == $eles[$i] && empty($var)) {
          $errm .= "<FONT color=#ff0000>�u".$key."�v�͕K�{���͍��ڂł��B</FONT><BR>\n";
          $flag = 1;
        }
      }
    }
  }
  foreach($_POST as $key=>$var) {
    $key = strtr($key, $string_from, $string_to);
    for($i=0; $i<=$length; $i++) {
      if($key == $eles[$i]) {
        $eles[$i] = "eweb_ok";
      }
    }
  }
  for($i=0; $i<=$length; $i++) {
    if($eles[$i] != "eweb_ok") {
      $errm .= "<FONT color=#ff0000>�u".$eles[$i]."�v�����I���ł��B</FONT><BR>\n";
      $eles[$i] = "eweb_ok";
      $flag = 1;
    }
  }
  if($flag == 1){
    htmlHeader();
?>


<!--- �����͂����������̉�� --- �J�n --------------------->

���̓G���[<BR><BR>
<?php echo $errm; ?>
<BR><BR>
<INPUT type="button" value="�O��ʂɖ߂�" onClick="history.back()">

<!--- �I�� --->


<?php 
    htmlFooter();
    exit(0);
  }
}
//--- ���[���̃��C�A�E�g�̕ҏW --- �J�n ------------------->

$body="�ȉ��̓��e�Ńz�[���y�[�W����̂��₢���킹������܂����B\n";
$body.="���Ή��肢�܂��B\n\n";
$body.="���M�����F".date( "Y/m/d (D) H:i:s", time() )."\n";
$body.="�z�X�g���F".getHostByAddr(getenv('REMOTE_ADDR'))."\n";
$body.="-------------------------------------------------\n";
foreach($_POST as $key=>$var) {
  $key = strtr($key, $string_from, $string_to);
  if(get_magic_quotes_gpc()) $var = stripslashes($var);
  if($var == "eweb_submit") ;
  else $body.="[".$key."] ".$var."\n";
}
$body.="-------------------------------------------------\n\n";

//--- �I�� --->


if($remail == 1) {
//--- ���o�l�ւ̑��M�m�F���[���̃��C�A�E�g�̕ҏW --- �J�n ->

$rebody="�ȉ��̓��e�����M����܂����B\n\n";
$rebody.="-------------------------------------------------\n";
foreach($_POST as $key=>$var) {
  $key = strtr($key, $string_from, $string_to);
  if(get_magic_quotes_gpc()) $var = stripslashes($var);
  if($var == "eweb_submit") ;
  else $rebody.="[".$key."] ".$var."\n";
}
$rebody.="-------------------------------------------------\n\n";
$rebody.="���M�����F".date( "Y/m/d (D) H:i:s", time() )."\n";
$reto = $_POST['email'];
$rebody=mb_convert_encoding($rebody,"JIS","SHIFT_JIS");
$resbj="=?iso-2022-jp?B?".base64_encode(mb_convert_encoding($resbj,"JIS","SHIFT_JIS"))."?=";
$reheader="From: $to\nReply-To: ".$to."\nContent-Type: text/plain;charset=iso-2022-jp\nX-Mailer: PHP/".phpversion();

//--- �I�� --->
}

$body=mb_convert_encoding($body,"JIS","SHIFT_JIS");
$sbj="=?iso-2022-jp?B?".base64_encode(mb_convert_encoding($sbj,"JIS","SHIFT_JIS"))."?=";
if($from_add == 1) {
  $from = $_POST['email'];
  $header="From: $from\nReply-To: ".$_POST['email']."\nContent-Type: text/plain;charset=iso-2022-jp\nX-Mailer: PHP/".phpversion();
} else {
  $header="Reply-To: ".$_POST['email']."\nContent-Type: text/plain;charset=iso-2022-jp\nX-Mailer: PHP/".phpversion();
}
if($chmail == 0 || $sendm == 1) {
  mail($to,$sbj,$body,$header);
  if($remail == 1) { mail($reto,$resbj,$rebody,$reheader); }
}
else { htmlHeader();
?>

<!--- ���M�m�F��ʂ̃��C�A�E�g�̕ҏW --- �J�n ------------->

<font color="#CC3333">�ȉ��̓��e�ŊԈႢ���Ȃ���΁A�u���M����v�{�^���������Ă��������B</font><BR><BR>
<FORM action="<? echo $script; ?>" method="POST">
<? echo $err_message; ?>
<TABLE width="550" bgcolor="#cccccc" cellspacing="1" cellpadding="3">
<?php
foreach($_POST as $key=>$var) {
  $key = strtr($key, $string_from, $string_to);
  if(get_magic_quotes_gpc()) $var = stripslashes($var);
  $var = htmlspecialchars($var);
  print("<TR bgcolor=#ffffff><TD bgcolor=#eeeeee>".$key."</TD><TD>".$var);
?>
<INPUT type="hidden" name="<?= $key ?>" value="<?= $var ?>">
<?php
  print("</TD></TR>\n");
}
?>
</TABLE>
<BR>
<TABLE width="550" align="center" cellspacing="0" cellpadding="0">
<TR>
<TD>
<INPUT type="hidden" name="eweb_set" value="eweb_submit">
<INPUT type="submit" value="���M����">
<INPUT type="button" value="�O��ʂɖ߂�" onClick="history.back()">
</TD>
</TR>
</TABLE>
</FORM>

<!--- �I�� --->


<?php htmlFooter(); } if(($jpage == 0 && $sendm == 1) || ($jpage == 0 && ($chmail == 0 && $sendm == 0))) { htmlHeader(); ?>


<!--- ���M�I����ʂ̃��C�A�E�g�̕ҏW --- �J�n ------------->

<CENTER>
	���₢���킹�����܂��Ă��肪�Ƃ��������܂����B<BR>
	���M�͖����ɏI�����܂����B<BR><BR>
</CENTER>

<!--- �I�� --->


<?php htmlFooter(); } else if(($jpage == 1 && $sendm == 1) || $chmail == 0) { header("Location: ".$next); } function htmlHeader() { ?>


<!--- �w�b�_�[�̕ҏW --- �J�n ----------------------------->

<HTML>
<HEAD>
<TITLE>���₢���킹�t�H�[��</TITLE>
</HEAD>
<BODY>

<!--- �I�� --->


<?php } function htmlFooter() { ?>


<!--- �t�b�^�[�̕ҏW --- �J�n ----------------------------->

</BODY>
</HTML>

<!--- �I�� --->


<?php } ?>