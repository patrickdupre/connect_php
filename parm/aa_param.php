<?PHP
date_default_timezone_set ("Europe/Paris");
$host="localhost";
$user="mysql";
$bdd="db_user";
$passwd="azerty";
// Quelle API Choisir voir https://www.php.net/manual/fr/mysqlinfo.api.choosing.php
$mysqli = new mysqli($host,$user,$passwd,$bdd);
if ($mysqli->connect_errno) {
    echo "Erreur : " . $mysqli->connect_errno . "=" . $mysqli->connect_error . "\n";
    exit('connection impossible');
}
else $mysqli->set_charset('utf8');
?>
