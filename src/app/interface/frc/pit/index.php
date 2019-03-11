<?php
$INCLUDE_ROOT = $_SERVER['DOCUMENT_ROOT'] . '/includes/';
require_once($INCLUDE_ROOT . "Navbar.php");
require_once($INCLUDE_ROOT . "Session.php");
require_once($INCLUDE_ROOT . "Footer.php");
require_once($INCLUDE_ROOT . "FusionTeamQuery.php");
require_once($INCLUDE_ROOT . "Database.php");
require_once($INCLUDE_ROOT . "PitScoutingInterface.php");

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
    <script src="/assets/pit.js"></script>
    <script>
        let intid=<?=$_GET['t'];?>;

        let back = () => {
            location.replace("/app/interface/frc/?t=" + intid);
        };
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
    $Navbar->bindParam("{{P_MODE}}", "Pit scouting team");
    $Navbar->render();
    ?>
    <!-- NAV END -->
</header>
<main>
    <div class="container">
        <a href="#!" onclick="back()" style="margin-top:10px;">< Back</a>
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
        ?>
        <div class="container-fluid">
            <h1 class="flow-text">Pit Scouting — Team <?=$name?></h1>
            <p> You are currently <b>pit scouting</b> Team <?=$name?>. Here, you can enter qualitative and quantitative measurements about Team <?=$name?>'s ROBOT.</p>
            <?php
                $lo = PitScoutingInterface::doesTeamHaveData($internal_id_input, $db);
                $lastInfo = null;

                if ($lo)
                {
                    echo "<script>alert('WARNING! This team already has pit scouting data added by " .$lo.". By proceeding, you are overwriting that data.');</script>";
                    $lastInfo = PitScoutingInterface::getAllDataAndParse($internal_id_input, $db);
                    echo "<script>window.lastInfo=JSON.parse('" . json_encode($lastInfo) . "');</script>";
                }
            ?>
            <hr>
            <h1 class="flow-text">Intake</h1>
            <!-- FORMSET 1 BEGIN: INTAKE -->
            <div class="row">
                <div class="input-field col s12 m6 l6">
                    <select id="intake-selector" class="browser-default">
                        <option value="ground">Ground</option>
                        <option value="exchange">Exchange</option>
                        <option value="none" selected>None (No Intake)</option>
                    </select>
                </div>
                <div id="group-hatchescargo" style="display: none;">
                    <div class="input-field col s6 m3 l3">
                        <label>
                            <input type="checkbox" class="filled-in" checked="checked" id="intake-hatches"/>
                            <span>Hatches</span>
                        </label>
                    </div>
                    <div class="input-field col s6 m3 l3">
                        <label>
                            <input type="checkbox" class="filled-in" checked="checked" id="intake-cargo"/>
                            <span>Cargo</span>
                        </label>
                    </div>
                </div>
            </div>
            <!-- FORMSET 1 END-->
            <h1 class="flow-text">Drive-off</h1>
            <!-- FORMSET 2 BEGIN: DRIVEOFF -->
            <div class="row">
                <div class="input-field col s12 m6 l6">
                    <select id="driveoff-selector" class="browser-default">
                        <option value="1" default>Level 1</option>
                        <option value="2">Level 2</option>
                    </select>
                </div>
                <div id="group-driveoffstats">
                    <div class="input-field col s4 m2 l2">
                        <label>
                            <input type="checkbox" class="filled-in" checked="checked" id="assist-left"/>
                            <span>Left Assist</span>
                        </label>
                    </div>
                    <div class="input-field col s4 m2 l2">
                        <label>
                            <input type="checkbox" class="filled-in" checked="checked" id="assist-right"/>
                            <span>Right Assist</span>
                        </label>
                    </div>
                    <div class="input-field col s4 m2 l2">
                        <label>
                            <input type="checkbox" class="filled-in" checked="checked" id="assist-simul"/>
                            <span>Simultaneous Assist</span>
                        </label>
                    </div>
                </div>
            </div>
            <!-- FORMSET 2 END-->
            <h1 class="flow-text">Piece Ability</h1>
            <!-- FORMSET 3 BEGIN: PIECE ABILITY-->
            <div class="row">

            </div>
        </div>
    </div>
</main>
    <?php UIFooter::render(); ?>
</body>
</html>