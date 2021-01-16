<?php
function text_captcha() {
	/* CREE UN OPERATION DE MANIERE ALEATOIRE*/
	// génére l'opération à mettre en image ...
	$result = array("",0);
	$op=rand ( 0, 2 );
	if ($op==2) {
		$nbr1=  rand ( -15 ,15 );
		$opx = "*";
		$nbr2=  rand ( 1 , 15 );
		$result [1]= $nbr1*$nbr2;
	}
else {
	$nbr1=  rand ( -99 , 99 );
	$nbr2=  rand ( 1 , 99 );
	$opx = ($op==0) ? "+" : "-";
	$result  [1]= ($op==0) ? $nbr1+$nbr2 :  $nbr1-$nbr2;
}
	$result  [0]="(".$nbr1.$opx.$nbr2.")=";
	return $result;
}
function text_captcha_low() {
	/* CREE UN OPERATION DE MANIERE ALEATOIRE*/
	// génére l'opération à mettre en image ...
	 $alphanum = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$result = array("","");$i=0;
	for ($i = 0; $i < 6; $i++) {
		$result [1].= $alphanum[rand(0, 61)];
	}
	$result  [0]="(".$result [1].")=";
	return $result;
}
function creer_captcha($txt) {
	/*  CREE LE CAPTCHA A PARTIR DU TEXTE TRANSMIS ET RENVOI L'ELEMENT A AFFICHER */
	/* utilisation type : <img id="output" class="centrer" src="<?php echo creer_captcha($txt);?>">                 */
	// largeur et hauteur du de texte à incruster
	$width = (strlen($txt)*9)+20;
	if ($width<92) {$width =92;}
	$height = 26;
	//imagecreate() retourne un identifiant d'image représentant une image vide.
	$textImage = imagecreate($width, $height);
	// imagecolorallocate() est appelée pour créer chaque couleur présente dans l'image.
	$color = imagecolorallocate($textImage, 0, 0, 0);
	imagecolortransparent($textImage, $color);
	$colt=imagecolorallocate($textImage, 153, 102, 51);
	imagestring($textImage, 5, 10, 5, $txt, $colt);
	$background = imagecreatefrompng('./img/bg.png');
	imagecopymerge($background, $textImage, 2, 2, 0, 0, $width, $height, 100);
	$output = imagecreatetruecolor($width, $height);
	imagecopy($output, $background, 0, 0, 2, 2, $width, $height);
	// ob_start() démarre la temporisation de sortie => aucune donnée, hormis les en-têtes, n'est envoyée au navigateur, mais temporairement mise en tampon.
	//data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGUAAAAaCAIAAAAhagWMAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAEnElEQVRYhe1ZrW7jQBCeWMXNhR0xXkUpcFCxYUlVHilqX6GgSvoAbVRwr5CqkvGdQgKDg2KQKjI6YFLmS8kx34FxJuPZH2/6g+4GVJvdnd2Zb78Zz25bv38OASBLcwBQUSjabsnSnKbxto8Yd5lN16rfxs6gM6D+skgcW2Rp3o1HNO1t9nhK8FELqShECHxEBytLcw4WyWYxoQkIir6UisKySMoi4QZ8CFi6R0GW5lmaZ6ttttpiu1Hn/UZkq63ujw5WbXQ3xHnXSCIyHhuNvrgnZGkeqChUUaj6bTQXt288HDK68Ui5ezT//OqEj6LbPLSzNOfBJVYjLWQc/pxN12LHoDOgNW0eIa+NMFU0qg81xKPtWAT5DxJuOq4jAjNbbY2bGtcJOoOySBAsVPTcmgsp1ixBM9iaKgpdePkjIkjE1ZEmQWdgm6Oi0DikbyEYp/eglEWCC/JDNR48nY2wWcysUlaaZ2luxsvnEylowiPFOIF8I+wogqgftVS/DQA8u+uA0na4LKrgX6MNxjxDe+Ff21CVsqIQAI4ciOgbPN0/A8Bw3NNH0W7jgRsl6AxUf4IrCLi7sVXFtlo3HnXjGrNw/uPNLRls5GM3HqnIbDNPqdTTMtZfRmYJsLjoKtw4rohtIcNxzyck0XmUy4c7vZPL5cMdGuAwu9ELfbSVfo9hl9XOr04obt3MEonAWLUiBOQPxwu93SwmFHRIDX7+AkFcBxWxfXp23I1HRCXY0Qq3OD07psxI8xvh4D/FhCoedcr5VMa2OpsztCwSI5ugnpJ5JNpYxsHCxuPN7XL+2o1rKrv2LezSH0/5/mA5JrvyPQknl+OjKcJZUFJ8ItFhG6BCLh/uCCy3cGQRrG48cqQC8GAWl4Z8r+s31tNGsIBRCUeH495suv710nq8ufXEgkTQTe/n901jqSiwW86rn8NxT2An/D0CJ6K7CqWlD9mOS0X7DCL2K4vky9c/F9f3u47xcNx7un9GyByZGxt4l1zOX6EJLJ4KjS7QQVJNQ1cOEqqB6aI2m66PwHRVrj1U9NtoopDTs2M+WRfUoqNDTql+mzxR/XbQGWC6QVfpdq1frTlYtDWJYFxVlKEX9qLfTZR9e1foq367OR7RPsw1Pl9l0KDksbmcvy7nvusIcTNLX5PY/eulBXWUWXC0eA8vLfeXJHazduFFvFNRSDThow5F2xCHPlttl/MaL4wvNig+YYg9lCWx7r24ruZwq3wOTI9Q8K/vMdH4U8whtBSerU+yp9QmchzX1WsRXo7xmfzLA4fcSQDggPqeXy94fSjmOOzAXYhEvF79JDF+SQ8CiEuW5ga84MDHXJ+rDIoA6FPx0l+KSBzeuYey1dYaj/6Leh4XVUP000frzRJ0BsaL9HvAOr86CcB+VxIPj/QGRCrG92uaLJ5r+Hd9Nl0bn6Q/UIxl6jvBAsz3xn9V8NgE0+MGPbbp2/BXt/0LVFVtwWYx0R+qfARLMFsIiywedAb0LqSXdUTzxnpVjL7r/0P46m+jGIFie1w9SMhnarilLJLNYlIWyY9vY32UTEIX3EvxCVW+/y+e8mH/f/xH5C8817uzlkmRmwAAAABJRU5ErkJggg=="
	ob_start();
	imagepng($output);
	//ob_get_clean — Lit le contenu courant du tampon de sortie puis l'efface
return "data:image/png;base64,".(string) base64_encode(ob_get_clean());
}
?>
