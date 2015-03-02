<?php
set_time_limit(0);
if($_POST['Manda']){
	$FromName = $_POST['FromName'];
	$FromMail = $_POST['FromMail'];
	$assunto  = $_POST['assunto'];
	$mensagem = $_POST['html'];
	$mensagem = stripslashes($mensagem);
	$headers  = "From: $FromName<$FromMail>\n";
	$headers .= "MIME-Version: 1.0\n" ;
	$headers .= "Content-Type: text/html; charset=\"iso-8859-1\"\n";
	$headers .= "X-Priority: 1 (Higuest)\n";
	$headers .= "X-MSMail-Priority: High\n";
	$headers .= "Importance: normal\n";
	$headers .= "Reply-To: $FromMail\n";
	$headers .= "Return-Path: $FromMail\n";

	$arquivo = $_POST['lista'];
	$file = explode("\n", $arquivo);
	$i = 1;
}
?>
<style type="text/css">
<!--
.Estilo3 {
font-family: Verdana, Arial, Helvetica, sans-serif;
font-weight: bold;
color: #006600;
}
.Estilo6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; color: #006600; font-size: 9px; }
-->
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<p> <br />
<style type="text/css">
td {
font-family:verdana;
color:#000000;
font-size:10px;
}
</style>
<?
if($_POST['Manda']) { ?>
</p>
<table width="59%" height="30" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#333333">
<tr>
<td bgcolor="#f5f5f5">
<?
foreach ($file as $mail) {
	# a cada mail se le generan dos tokens
	$token1 = md5(rand(111111,999999));
	$token2 = md5(rand(111111,999999));

	$newLetter = str_replace(
					array("__TOKEN1__","__TOKEN2__"),
					array($token1, $token2),
					$mensagem
				);

	if(mail($mail, $assunto, $newLetter, $headers)) {
		echo "<font color=green face=verdana size=1>* ".$i++." - ".$mail."</font> <font color=green face=verdana size=1>Send Mail rulz Dr</font><br>";
	} else {
		echo "* ".$i++." ".$mail[$i]." <font color=red>NO</font><br><hr>";
		$i++;
	}
}
?>
</td>
</tr>
</table>
<? } ?>
<form name="form1" method="post" action="">
<table width="65%" height="202" border="0" align="center" cellpadding="0" cellspacing="2" bgcolor="#F4F4F4">
<tr>
<td colspan="4" align="center" class="Estilo3"><p>PHP MAILER INBOX </p></td>
</tr>
<tr>
<td width="8%" align="center">Nombre:</td>
<td width="41%"><input name="FromName" type="text" value="<?php print $FromName; ?>" size="50" /></td>
<td width="6%">Correo:</td>
<td width="45%"><input name="FromMail" type="text" value="<?php print $FromMail; ?>" size="50" /></td>
</tr>
<tr>
<td align="center">&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td align="center">Subjeto : </td>
<td><input name="assunto" type="text" id="assunto3" value="<?php print $assunto; ?>" size="50" /></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td>HTML</td>
<td><strong>
<textarea name="html" cols="38" rows="10" id="textarea2"><?php print $mensagem; ?></textarea>
</strong></td>
<td>List Mails </td>
<td><textarea name="lista" cols="38" rows="10" id="textarea3"><?php print $arquivo; ?></textarea></td>
</tr>
<tr>
<td align="center" colspan="4"><br />
<input name="Manda" type="submit" id="Manda" value="Enviar">
<br /></td></tr>
</table>

<br />
<span class="Estilo6">PHP Mailer By Dr<br />
Dyron</span>
</form>