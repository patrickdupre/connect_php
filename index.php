<?PHP
/* * *************************************************************************************************************
 * Composants utilisés sur le site :
 *  prismjs : Prism is a lightweight syntax highlighting library : https://github.com/PrismJS/prism & prismjs.com
 *  bcrypt : library for passwords hashes using the CRYPT_BLOWFISH : https://github.com/dcodeIO/bcrypt.js & http://dcode.io
 * leaflet : library for interactive maps : https://github.com/Leaflet/Leaflet & https://leafletjs.com/
 * Plantuml : Generate UML diagram from textual description https://github.com/plantuml/plantuml & http://plantuml.com/
 * mocodo : Modélisation Conceptuelle de Données. Nickel. Ni souris. http://mocodo.net & https://github.com/laowantong/mocodo
 * WebODF : WebODF - JavaScript Document Engine https://github.com/webodf/WebODF & http://webodf.org/
 * à voir :
 * - utilisation nextcloud : A cloud server to store your files centrally on a hardware controlled by you
 * - collabora (https://aur.archlinux.org/collabora-online-server-nodocker.git (https://www.collaboraoffice.com/code/))
 * PAGE 0 : login ...
 * sécurité à renforcer : https://httpd.apache.org/docs/2.4/howto/htaccess.html https://www.askapache.com/htaccess/
 * ************************************************************************************************************ */
// démarre la session en https
if($_SERVER["HTTP_HOST"] != "localhost" && (!isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on")) {
	header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"], true, 301);
	exit;
}
session_set_cookie_params(['lifetime' => 7200, 'path' =>'/','domain' =>".".$_SERVER['HTTP_HOST'],'secure' => TRUE,'httponly' =>TRUE,'samesite' => "Strict"]);
session_start();

// Gestion de la session courante pour éviter de surcharger le serveur ...
// au dela de 10 actualisations de la page => détruire/réinitialiser la session
/*if (empty($_SESSION['count'])) {
    $_SESSION['count'] = 1;
} else {*/
    if (!isset($_SESSION['count']) || @$_SESSION['count'] == 10 || isset($_SESSION['util_connect'])) {
        session_destroy();
        $_SESSION = array();
        $new_id = session_create_id("st2msi");
        session_commit();
        session_id($new_id);
        session_set_cookie_params(['lifetime' => 7200, 'path' =>'/','domain' =>".".$_SERVER['HTTP_HOST'],'secure' => TRUE,'httponly' =>TRUE,'samesite' => "Strict"]);
        session_start();
        $_SESSION['count'] = 1;
    }else {
        $_SESSION['count']++;
    }
//}
if (!isset($_SESSION['session_cours'])) {
    include "./inc/img_captcha.php";
    $_SESSION['session_cours'] = session_id();
    $txt_captcha = array("", 0); // Texte, Résultat attendu
    $txt_captcha = text_captcha_low();
    $pass_opt = ['cost' => 4,];
    $_SESSION['pass_captcha'] = password_hash((string) $txt_captcha[1], PASSWORD_BCRYPT, $pass_opt);
    $_SESSION['img_captcha'] = creer_captcha($txt_captcha[0]);
}
?>
<!DOCTYPE html>
<html lang="fr">

    <head>
        <title>Bienvenu</title>
        <link href="./inc/login.css" type="text/css" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
    </head>
    <body>
        <div class="login">
            <header>
                <table>
                    <tr>
                        <td style="padding-bottom: 0px;"><img src="img/java_monkey100.gif" alt="JS"></td>
                        <td>
                            <h1><pre id="Marquee">          Bonjour</pre></h1>
                        </td>
                    </tr>
                </table>
            </header>
            <main class="contenu">
               <form name="login_form" autocomplete="on" method="post" action="./pub/page_connect.php">
                    <p><input id="username" name="username" type="text" placeholder="Identifiant" title="Saisissez votre identifiant" required autofocus="autofocus" onchange="verif_elt(this.id, this.value)">
                    </p>
                    <p><input type="password" id="password" name="password" placeholder="Mot de passe" title="Saisissez votre mot de passe"required onchange="verif_elt(this.id, this.value)">
                    </p>
                    <img style="height:36px;" src="<?php echo $_SESSION['img_captcha']; ?>"><br>
                    <input id="captcha" id="captcha" type="text" required name="captcha" placeholder="Caractères entre ()" title="Saisir les caractères entre parenthèses"  autocomplete="off" onchange="verif_calc(this.value)"><strong id="out_calc"></strong>
                    <input type="hidden" id="crypt" name="crypt" value="<?php echo $_SESSION['pass_captcha']; ?>">
                    <input type="hidden" id="s_id" name="s_id" value="<?php echo session_id(); ?>"><br><br>
                    <input class="bt_val" id="button-submit" type="submit" value="Connexion">
                    <p><small style ="color:red;">Visiteurs : utilisez l'identifiant "Etudiant" et le mot de passe "Visiteur".</small></p>
                </form>
<?PHP include "./inc/legal.html"; ?>
            </main>
                <?PHP include "./inc/zz_copy.php"; ?>
        </div>
        <script language="JavaScript"><!--
                /** VERIFICATION DE L'IDENTIFIANT **/
            /** VERIFICATION DU MOT DE PASSE **/
            function verif_elt(id, txt) {
                var retour = clean_saisie(txt);
                if (txt.length < 5) {
                    retour = false;
                }
                if (retour) {
                    document.getElementById(id).style.color = "darkgreen";
                } else {
                    document.getElementById(id).style.color = "darkred";
                }
                return retour;
            }

            /** VERIFICATION DU CALCUL A EFFECTUER **/
            function verif_calc(nbr_saisi) {
                var ok_calc = clean_saisie(nbr_saisi);
                if (ok_calc) {
                    var bcrypt = dcodeIO.bcrypt;
                    var pass_captcha = document.getElementById("crypt").value.replace(/^\$2y/, "$2a");
                    var ok_calc = bcrypt.compareSync(nbr_saisi.toString(), pass_captcha);
                }
                if (ok_calc) {
                    document.getElementById("captcha").style.color = "darkgreen";
                } else {
                    document.getElementById("captcha").style.color = "darkred";
                }
                return ok_calc;
            }
            /** GESTION DU SCROLL / <MARQUEE> **/
            function myMarquee() {
                var tab_scroll = txt_scroll.split('');
                tab_scroll.push(tab_scroll.shift());
                txt_scroll = tab_scroll.join('');
                document.getElementById("Marquee").innerHTML = txt_scroll.slice(0, 22);
            }
            /** LA SAISIE EST-ELLE PROPRE ? **/
            function clean_saisie(saisie) {
                // enlever les caractères dangeureux de la saisie
                var retour = true;
                var tmp_sai = saisie.replace(/[\x00-\x22]|[\"\'\`<>\\\^=\$]/gm, "");
                if (tmp_sai != saisie) {
                    retour = false;
                }
                return retour;
            }
            /** INITIALISATION DE LA PAGE **/
            var ident_ok = false; // identifiant non saisi => non ok
            var pass_ok = false; // mot de passe non saisi => non ok
            var calc_ok = false; // captcha non saisi => non ok
            var txt_scroll = "          Bonjour et bienvenu sur le site st2msi.net des bts-sio slam du Lycée Claude Nougaro - 82300 Monteils... ";
            if ((new Date().getHours()) > 18) {
                txt_scroll = txt_scroll.replace(/jour/gm, "soir");
            }
            setInterval(myMarquee, 200);
-->
        </script>
        <script src="./inc/bcrypt/bcrypt.min.js"></script>
    </body>
</html>
