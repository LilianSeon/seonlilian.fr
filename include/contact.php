<?php
session_start();

$nom = utf8_decode($_POST['nom']);
$mail = ($_POST['email']);
$subject = utf8_decode($_POST['sujet']);
$message = 'From seonlilian.fr--> '."\r\n".utf8_decode($_POST['message']);
$headers = 'From: '.$nom.'<'.$mail.'>'."\r\n";
$headers .= 'Reply-to: <'.$mail.'>'."\r\n";
$to = 'eragnylilian@live.fr';

	echo "Tous les champs doivent être remplis.<br /><br />";
	if(isset($_POST['formenvoi'])){
		if(!empty($_POST['nom']) AND !empty($_POST['email']) AND !empty($_POST['sujet']) AND !empty($_POST['message']) AND !empty($_POST['captcha'])){
			if($_POST['captcha'] == $_SESSION['captcha']){
				mail($to, $subject, $message, $headers);
				header('Location: http://www.séon-lilian-cv.com/index.php#contact');
				echo "<script>alert(\"Votre message est bien envoyé, je vous répondrais au plus vite.\")</script>";
				echo '<div class="alert alert-success" role="alert">Votre message à été envoyé !<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
			}else{
				header('Location: http://www.séon-lilian-cv.com/index.php#contact');
				echo '<div class="alert alert-danger" role="alert"><font>Le nombre entré est invalide.</font><button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';
			}
		}	else {
			header('Location: http://www.séon-lilian-cv.com/index.php#contact');
				echo '<div class="alert alert-danger" role="alert"><font>Tous les champs ne sont pas remplis.</font>  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button></div>';

	}
}


?>
