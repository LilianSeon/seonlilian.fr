<?php
session_start();

$nom = utf8_decode($_POST['nom']);
$mail = ($_POST['email']);
$subject = utf8_decode($_POST['sujet']);
$message = utf8_decode($_POST['message']);
$headers = 'From: '.$nom.'<'.$mail.'>'."\r\n";
$headers .= 'Reply-to: <'.$mail.'>'."\r\n";
$to = 'eragnylilian@live.fr';

?>
<html>
<head>
<meta charset="utf-8" />
</head>
<body>
</body>
</html>
<?php 
	if($_POST['captcha'] == $_SESSION['captcha']){
		mail($to, $subject, $message, $headers);
		echo 'Votre message à été envoyéé !';
	}else{
		echo 'Le nombre entré est invalide.';
	}

?>
