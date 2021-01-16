<?PHP include("../inc/user_init.php");
if (empty($_SESSION['util_connect'])) {header("Location:../index.php\n\n"); exit;}
?>
<!DOCTYPE html>
<html lang="fr">
<body>
	<h1> Bonjour <?php echo $ss_util;?>, bienvenu sur le site, vous êtes connecté.</h1>
</body>
</html>
