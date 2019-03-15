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
    <script src="/assets/pre_match.js"></script>
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
            location.replace("/app/interface/frc/match/?t=" + intid);
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
<?php
    $internal_id_input = $_GET['t'];

    $db = new FusionDBInterface();
    $db->connect();

    if (!FusionTeamQuery::getTeamInfoByInternalId($internal_id_input, $db))
    {
        // FAIL NOW!
        die("<p> Internal System Error. This team does not exist. <a href='/'>Go back</a></p></body></html>");
    }

    $name = FusionTeamQuery::getTeamInfoByInternalId($internal_id_input, $db)[0]["frcTeamName"];

    echo("<script> window.internalId = " . $internal_id_input . ";</script>");
?>
<main>
    <div class="container">
        <div class="step-1-wrapper">
            <h5 style="font-weight:bolder;">Fusion Match Scouting</h5>
            <p>Let's get started. What is the match number? This is important.</p>
            <div class="row">
                <div class="col s8 m6 l3" style="padding: 0;">
                    <textarea id="match-id" class="materialize-textarea" type="number"></textarea>
                    <label for="match-id">Match Number</label>
                </div>
                <a class="waves-effect waves-teal btn col s4 m2 l2 right" href="#!" id="step-1-confirm">confirm</a>
            </div>
        </div>
        <div class="step-2-wrapper" style="display:none;">
            <p id="step-2-confirmation">You will be scouting Team <?=$name?>'s position in MATCH </p>
            <div class="row">
                <div class="col s6 m3 l2">
                    <a href="#!" class="btn" id="yes-btn">Yes</a>
                </div>
                <div class="col s6 m3 l2">
                    <a href="#!" class="btn" onclick="location.reload();">No</a>
                </div>
            </div>
        </div>
    </div>
</main>
<?php UIFooter::render(); ?>
</body>
</html>