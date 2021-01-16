<?PHP
/**************************************************************************************************************/
/* PAGE 1 acceuil menu ...
/*
/**************************************************************************************************************/
session_start();
// Gestion des variables de session
if (isset($_SESSION['count'])) {
    unset($_SESSION['count']);
    unset($_SESSION['img_captcha']);
}
if (!isset($_SESSION['util_connect']) && isset($_REQUEST['username'])) {
	$in_util=$_REQUEST['username'];
	$in_pass=$_REQUEST['password'];
	$in_captcha=$_REQUEST['captcha'];
	$in_crypt=$_REQUEST['crypt'];
	$in_session=$_REQUEST['s_id'];
	$log_ok=false;
	if ( password_verify($in_captcha, $in_crypt)) {
		include("../parm/aa_param.php");
		$qw_result = $mysqli->query("SELECT ut_pseudo, ut_nom, ut_prenom, ut_mp, ut_mail, ut_phrase from utilisateur WHERE ut_pseudo='".$in_util."' LIMIT 1;");
		if($qw_result != null) {
			$row = $qw_result->fetch_row();
			if(password_verify($in_pass, $row[5])) {
				$log_ok=true;
				$_SESSION['util_connect']=$row[0];
				$_SESSION['ut_pseudo'] = $row[0];
				$_SESSION['ut_nom'] = $row[1];
				$_SESSION['ut_prenom'] = $row[2];
				$_SESSION['ut_mp'] = $row[3];
				$_SESSION['ut_mail'] = $row[4];
				$_SESSION['ut_captcha']=$in_crypt;
			}
		}
		$qw_result->close();
	}
} 
if (isset($_SESSION['util_connect'])) {
	$ss_util=$_SESSION['util_connect'];
}

?>
