<?php header("Content-Type:text/html;charset=Shift_JIS"); ?>
<?php
//==========================================================
//  メールフォームシステム
//==========================================================

// このファイルの名前
$script ="sendmail_contact.php";

// メールを送信するアドレス(複数指定する場合は「,」で区切る)
$to = "info@pulax.co.jp";

// 送信されるメールのタイトル
$sbj = "【ホームページからのお問い合わせ】";

// 送信確認画面の表示(する=1, しない=0)
$chmail = 1;

// 送信後に自動的にジャンプする(する=1, しない=0)
// 0にすると、送信終了画面が表示されます。
$jpage = 0;

// 送信後にジャンプするページ(送信後にジャンプする場合)
$next = "http://www.pulax.co.jp/contact/contactform.html";

// 差出人は、送信者のメールアドレスにする(する=1, しない=0)
// する場合は、メール入力欄のname属性を「email」にしてください。
$from_add = 1;

// 差出人に送信内容確認メールを送る(送る=1, 送らない=0)
// 送る場合は、メール入力欄のname属性を「email」にしてください。
$remail = 1;

// 差出人に送信確認メールを送る場合のメールのタイトル
$resbj = "お問い合わせありがとうございました【株式会社プラックス】";

// 必須入力項目を設定する(する=1, しない=0)
$esse = 1;

// 必須入力項目(入力フォームで指定したname)
$eles = array('貴社名','ご担当者名','ご担当者フリガナ','email','TEL');


//--------------------------------------------------------------------
// 以上で基本的な設定は終了です。
// 以下の変更は自己責任でお願いします。(行数はデフォルト時)
// 未入力画面のレイアウト → 88行目周辺
// 送信メールのレイアウト → 103行目周辺
// 差出人への送信確認メールのレイアウト → 128行目周辺
// 送信確認画面のレイアウト → 163行目周辺
// 送信終了画面のレイアウト → 194行目周辺
// 送信確認画面や終了画面のヘッダとフッタ → 209行目周辺
//--------------------------------------------------------------------

$sendm = 0;
foreach($_POST as $key=>$var) {
  if($var == "eweb_submit") $sendm = 1;
}

// 文字の置き換え
$string_from = "＼";
$string_to = "ー";

// 未入力項目のチェック
if($esse == 1) {
  $flag = 0;
  $length = count($eles) - 1;
  foreach($_POST as $key=>$var) {
    $key = strtr($key, $string_from, $string_to);
    if($var == "eweb_submit") ;
    else {
      for($i=0; $i<=$length; $i++) {
        if($key == $eles[$i] && empty($var)) {
          $errm .= "<FONT color=#ff0000>「".$key."」は必須入力項目です。</FONT><BR>\n";
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
      $errm .= "<FONT color=#ff0000>「".$eles[$i]."」が未選択です。</FONT><BR>\n";
      $eles[$i] = "eweb_ok";
      $flag = 1;
    }
  }
  if($flag == 1){
    htmlHeader();
?>


<!--- 未入力があった時の画面 --- 開始 --------------------->

入力エラー<BR><BR>
<?php echo $errm; ?>
<BR><BR>
<INPUT type="button" value="前画面に戻る" onClick="history.back()">

<!--- 終了 --->


<?php 
    htmlFooter();
    exit(0);
  }
}
//--- メールのレイアウトの編集 --- 開始 ------------------->

$body="以下の内容でホームページからのお問い合わせがありました。\n";
$body.="ご対応願います。\n\n";
$body.="送信日時：".date( "Y/m/d (D) H:i:s", time() )."\n";
$body.="ホスト名：".getHostByAddr(getenv('REMOTE_ADDR'))."\n";
$body.="-------------------------------------------------\n";
foreach($_POST as $key=>$var) {
  $key = strtr($key, $string_from, $string_to);
  if(get_magic_quotes_gpc()) $var = stripslashes($var);
  if($var == "eweb_submit") ;
  else $body.="[".$key."] ".$var."\n";
}
$body.="-------------------------------------------------\n\n";

//--- 終了 --->


if($remail == 1) {
//--- 差出人への送信確認メールのレイアウトの編集 --- 開始 ->

$rebody="以下の内容が送信されました。\n\n";
$rebody.="-------------------------------------------------\n";
foreach($_POST as $key=>$var) {
  $key = strtr($key, $string_from, $string_to);
  if(get_magic_quotes_gpc()) $var = stripslashes($var);
  if($var == "eweb_submit") ;
  else $rebody.="[".$key."] ".$var."\n";
}
$rebody.="-------------------------------------------------\n\n";
$rebody.="送信日時：".date( "Y/m/d (D) H:i:s", time() )."\n";
$reto = $_POST['email'];
$rebody=mb_convert_encoding($rebody,"JIS","SHIFT_JIS");
$resbj="=?iso-2022-jp?B?".base64_encode(mb_convert_encoding($resbj,"JIS","SHIFT_JIS"))."?=";
$reheader="From: $to\nReply-To: ".$to."\nContent-Type: text/plain;charset=iso-2022-jp\nX-Mailer: PHP/".phpversion();

//--- 終了 --->
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

<!--- 送信確認画面のレイアウトの編集 --- 開始 ------------->

<font color="#CC3333">以下の内容で間違いがなければ、「送信する」ボタンを押してください。</font><BR><BR>
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
<INPUT type="submit" value="送信する">
<INPUT type="button" value="前画面に戻る" onClick="history.back()">
</TD>
</TR>
</TABLE>
</FORM>

<!--- 終了 --->


<?php htmlFooter(); } if(($jpage == 0 && $sendm == 1) || ($jpage == 0 && ($chmail == 0 && $sendm == 0))) { htmlHeader(); ?>


<!--- 送信終了画面のレイアウトの編集 --- 開始 ------------->

<CENTER>
	お問い合わせ頂きましてありがとうございました。<BR>
	送信は無事に終了しました。<BR><BR>
</CENTER>

<!--- 終了 --->


<?php htmlFooter(); } else if(($jpage == 1 && $sendm == 1) || $chmail == 0) { header("Location: ".$next); } function htmlHeader() { ?>


<!--- ヘッダーの編集 --- 開始 ----------------------------->

<HTML>
<HEAD>
<TITLE>お問い合わせフォーム</TITLE>
</HEAD>
<BODY>

<!--- 終了 --->


<?php } function htmlFooter() { ?>


<!--- フッターの編集 --- 開始 ----------------------------->

</BODY>
</HTML>

<!--- 終了 --->


<?php } ?>