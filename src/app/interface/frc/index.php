<?php
$INCLUDE_ROOT = $_SERVER['DOCUMENT_ROOT'] . '/includes/';
require_once($INCLUDE_ROOT . "Navbar.php");
require_once($INCLUDE_ROOT . "Session.php");
require_once($INCLUDE_ROOT . "Footer.php");
require_once($INCLUDE_ROOT . "FusionTeamQuery.php");
require_once($INCLUDE_ROOT . "Database.php");

?>
<?php
session_start();

if (!FusionSessionInterface::isLoggedIn())
{
    header("Location: /app/auth/");
    die("Unauthorized. If you don't get redirected, click <a href='/app/auth/'>here</a>");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="/assets/bootstrap/jquery-3.3.1.slim.min.js"></script>
    <script src="/assets/centering.js"></script>
    <script src="/assets/materialize/js/materialize.js"></script>
    <link href="/assets/materialize/css/materialize.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="/assets/loading-btn/loading.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/loading-btn/loading-btn.css"/>
    <link rel="stylesheet" href="/assets/fonts.css"/>
    <link rel="stylesheet" href="/assets/materialize_whitetheme.css"/>
    <script>
        let intid=<?=$_GET['t'];?>;

        let pit = () => {
            location.replace("/app/interface/frc/pit/?t=" + intid);
        }

        let match = () => {
            location.replace("/app/interface/frc/pit/?t=" + intid);
        }
    </script>
    <title>FUSION Add Team</title>
</head>
<body>
<header>
    <!-- NAV BEGIN -->
    <?php
    $Navbar = new Navbar();
    $Navbar->setAuthProvider(FusionSessionInterface::class);
    $Navbar->setNavbarFramework("materialize");
    $Navbar->setNavbarType("loggedIn");
    $Navbar->bindParam("{{P_MODE}}", "Scouting team");
    $Navbar->render();
    ?>
    <!-- NAV END -->
</header>
<main>
    <div class="container">
        <?php
            $internal_id_input = $_GET['t'];

            $db = new FusionDBInterface();
            $db->connect();

            if (!FusionTeamQuery::getTeamInfoByInternalId($internal_id_input, $db))
            {
                // FAIL NOW!
                die("<p> Internal System Error. This team does not exist. <a href='/'>Go back</a></p></body></html>");
            }
        ?>
        <div class="center-div" style="text-align: center;">
            <h1 class="flow-text">Select scouting mode</h1>
            <a class="waves-effect waves-light btn-large btn-override-rainbow" onclick="pit();">Pit Scouting</a>
            <a class="waves-effect waves-light btn-large btn-override-rainbow" onclick="match();">Scout match</a>
        </div>
    </div>
</main>
<?php UIFooter::render(); ?>
</body>
</html>