<?php
$INCLUDE_ROOT = $_SERVER['DOCUMENT_ROOT'] . '/includes/';
require_once($INCLUDE_ROOT . "Navbar.php");
require_once($INCLUDE_ROOT . "Session.php");
require_once($INCLUDE_ROOT . "Footer.php");
require_once($INCLUDE_ROOT . "FusionTeamQuery.php");
require_once($INCLUDE_ROOT . "Database.php");
require_once($INCLUDE_ROOT . "MatchAgent.php");

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
    <script src="/assets/match.js"></script>
    <link href="/assets/materialize/css/materialize.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="/assets/loading-btn/loading.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/loading-btn/loading-btn.css"/>
    <link rel="stylesheet" href="/assets/fonts.css"/>
    <link rel="stylesheet" href="/assets/materialize_whitetheme.css"/>
    <script>
        $(function() {
            $("#form-submit").on("click", function() {
                exportData(window.matchId, window.internalId);
            });
        });
    </script>
    <title>FUSION Match Scout</title>
</head>
<body>
<header>
    <!-- NAV BEGIN -->
    <?php
    $Navbar = new Navbar();
    $Navbar->setAuthProvider(FusionSessionInterface::class);
    $Navbar->setNavbarFramework("materialize");
    $Navbar->setNavbarType("loggedIn");
    $Navbar->bindParam("{{P_MODE}}", "Match scouting");
    $Navbar->render();
    ?>
    <!-- NAV END -->
</header>
<?php
$teamId = $_GET['t'];

$db = new FusionDBInterface();
$db->connect();

if (!FusionTeamQuery::getTeamInfoByInternalId($teamId, $db))
{
    // FAIL NOW!
    die("<p> Internal System Error. This team does not exist. <a href='/'>Go back</a></p></body></html>");
}

$name = FusionTeamQuery::getTeamInfoByInternalId($teamId, $db)[0]["frcTeamName"];
$match_id = $_GET['id'];

if (FusionMatchAgent::doesTeamHaveMatchRecord($teamId, $match_id, $db))
{
    echo "<script>alert('Warning: this match already has data on this team; by proceeding, you are overwriting that.');</script>";
}

echo("<script> window.internalId = " . $teamId . "; window.matchId = ".$match_id."</script>");
?>
<main>
    <div class="container">
        <h2 class="flow-text" style="font-weight:bolder;">Team <?=$name?>'s performance at match <?=$match_id?></h2>
        <p class="flow-text">Sandstorm Phase</p>
        <div class="divider"></div>
        <div class="section">
            <p> What was preloaded? </p>
            <div class="input-field col s12 m6 l6">
                <select id="preloaded-piece" class="browser-default">
                    <option value="none" default>Nothing was preloaded</option>
                    <option value="cargo">Cargo</option>
                    <option value="hatch">Hatch</option>
                </select>
            </div>
            <p> What was the starting position? </p>
            <select id="starting-position" class="browser-default">
                <option value="-2">Leftmost</option>
                <option value="-1">Left</option>
                <option value="0" selected>Center</option>
                <option value="1">Right</option>
                <option value="2">Rightmost</option>
            </select>
            <p> How was the drive-off? </p>
            <select id="driveoff-success" class="browser-default">
                <option value="true">The drive-off succeeded</option>
                <option value="false">The drive-off failed</option>
                <option value="none" selected>Select</option>
            </select>
            <div id="driveoff-success-notes" style="display: none;">
                <p>Was the drive-off solo or assisted?</p>
                <select id="driveoff-solo-or-assisted" class="browser-default">
                    <option value="solo">The drive-off was solo</option>
                    <option value="assisted">The drive-off was assisted</option>
                </select>
            </div>
            <div id="driveoff-failure-notes" style="display: none;">
                <p>Why did the drive-off fail?</p>
                <div class="input-field">
                    <textarea id="driveoff-failure-notes-text" class="materialize-textarea"></textarea>
                    <label for="driveoff-failure-notes">Failure notes</label>
                </div>
            </div>
            <p> How many of each were scored <b>in the sandstorm phase only?</b></p>
            <div id="cargo-hatches-wrapper-sandstorm" class="row">
                <div id="successful-cargo" class="col s12 m6 l6">
                    <i>Successful cargo...</i>
                    <div class="input-field">
                        <textarea id="cargo-success-cargoship-sandstorm" class="materialize-textarea" default="0"></textarea>
                        <label for="cargo-success-cargoship-sandstorm">... in cargoship</label>
                    </div>
                    <div class="input-field">
                        <textarea id="cargo-success-rocketship1-sandstorm" class="materialize-textarea"></textarea>
                        <label for="cargo-success-rocketship1-sandstorm">... in rocket ship 1</label>
                    </div>
                    <div class="input-field">
                        <textarea id="cargo-success-rocketship2-sandstorm" class="materialize-textarea"></textarea>
                        <label for="cargo-success-rocketship2-sandstorm">... in rocket ship 2</label>
                    </div>
                    <div class="input-field">
                        <textarea id="cargo-success-rocketship3-sandstorm" class="materialize-textarea"></textarea>
                        <label for="cargo-success-rocketship3-sandstorm">... in rocket ship 3</label>
                    </div>
                    <p style="color:red; font-weight: bolder;">Failed attempts at cargo:</p>
                    <div class="input-field">
                        <textarea id="cargo-fails-sandstorm" class="materialize-textarea"></textarea>
                        <label for="cargo-fails-sandstorm">failed attempts</label>
                    </div>
                </div>
                <div id="successful-hatches" class="col s12 m6 l6">
                    <i>Successful hatches...</i>
                    <div class="input-field">
                        <textarea id="hatches-success-cargoship-sandstorm" class="materialize-textarea" default="0"></textarea>
                        <label for="hatches-success-cargoship-sandstorm">... in cargoship</label>
                    </div>
                    <div class="input-field">
                        <textarea id="hatches-success-rocketship1-sandstorm" class="materialize-textarea"></textarea>
                        <label for="hatches-success-rocketship1-sandstorm">... in rocket ship 1</label>
                    </div>
                    <div class="input-field">
                        <textarea id="hatches-success-rocketship2-sandstorm" class="materialize-textarea"></textarea>
                        <label for="hatches-success-rocketship2-sandstorm">... in rocket ship 2</label>
                    </div>
                    <div class="input-field">
                        <textarea id="hatches-success-rocketship3-sandstorm" class="materialize-textarea"></textarea>
                        <label for="hatches-success-rocketship3-sandstorm">... in rocket ship 3</label>
                    </div>
                    <p style="color:red; font-weight: bolder;">Failed attempts at hatches:</p>
                    <div class="input-field">
                        <textarea id="hatches-fails-sandstorm" class="materialize-textarea"></textarea>
                        <label for="hatches-fails-sandstorm">failed attempts</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="divider"></div>
        <p class="flow-text">Tele-op phase (middle)</p>
        <div class="section">
            <p> How many of each were scored <b>in the tele-op phase only?</b></p>
            <div id="cargo-hatches-wrapper-teleop" class="row">
                <div id="successful-cargo" class="col s12 m6 l6">
                    <i>Successful cargo...</i>
                    <div class="input-field">
                        <textarea id="cargo-success-cargoship-teleop" class="materialize-textarea" default="0"></textarea>
                        <label for="cargo-success-cargoship-teleop">... in cargoship</label>
                    </div>
                    <div class="input-field">
                        <textarea id="cargo-success-rocketship1-teleop" class="materialize-textarea"></textarea>
                        <label for="cargo-success-rocketship1-teleop">... in rocket ship 1</label>
                    </div>
                    <div class="input-field">
                        <textarea id="cargo-success-rocketship2-teleop" class="materialize-textarea"></textarea>
                        <label for="cargo-success-rocketship2-teleop">... in rocket ship 2</label>
                    </div>
                    <div class="input-field">
                        <textarea id="cargo-success-rocketship3-teleop" class="materialize-textarea"></textarea>
                        <label for="cargo-success-rocketship3-teleop">... in rocket ship 3</label>
                    </div>
                    <p style="color:red; font-weight: bolder;">Failed attempts at cargo:</p>
                    <div class="input-field">
                        <textarea id="cargo-fails-teleop" class="materialize-textarea"></textarea>
                        <label for="cargo-fails-teleop">failed attempts</label>
                    </div>
                </div>
                <div id="successful-hatches" class="col s12 m6 l6">
                    <i>Successful hatches...</i>
                    <div class="input-field">
                        <textarea id="hatches-success-cargoship-teleop" class="materialize-textarea" default="0"></textarea>
                        <label for="hatches-success-cargoship-teleop">... in cargoship</label>
                    </div>
                    <div class="input-field">
                        <textarea id="hatches-success-rocketship1-teleop" class="materialize-textarea"></textarea>
                        <label for="hatches-success-rocketship1-teleop">... in rocket ship 1</label>
                    </div>
                    <div class="input-field">
                        <textarea id="hatches-success-rocketship2-teleop" class="materialize-textarea"></textarea>
                        <label for="hatches-success-rocketship2-teleop">... in rocket ship 2</label>
                    </div>
                    <div class="input-field">
                        <textarea id="hatches-success-rocketship3-teleop" class="materialize-textarea"></textarea>
                        <label for="hatches-success-rocketship3-teleop">... in rocket ship 3</label>
                    </div>
                    <p style="color:red; font-weight: bolder;">Failed attempts at hatches:</p>
                    <div class="input-field">
                        <textarea id="hatches-fails-teleop" class="materialize-textarea"></textarea>
                        <label for="hatches-fails-teleop">failed attempts</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="divider"></div>
        <p class="flow-text">Endgame phase (end)</p>
        <div class="section">
            <p>Did the robot climb at the end, or did it assist another?</p>
            <div class="input-field col s12 m6 l6">
                <select id="did-robot-climb" class="browser-default">
                    <option value="none" selected>The robot did not climb nor assist another</option>
                    <option value="solo">The robot climbed, solo</option>
                    <option value="assist">The robot climbed, assisted by another</option>
                    <option value="helpedassist">The robot assisted another robot</option>
                </select>
            </div>
            <p>What was the ending state?</p>
            <div class="input-field col s12 m6 l6">
                <select id="ending-state" class="browser-default">
                    <option value="level1" selected>Level 1</option>
                    <option value="llevel2">Left Level 2</option>
                    <option value="rlevel2">Right Level 2</option>
                    <option value="level3">Level 3</option>
                    <option value="offhab">Off-HAB</option>
                </select>
            </div>
            <p> Any last notes on <b>this robot</b>'s performance? </p>
            <div class="input-field">
                <textarea id="final-remarks" class="materialize-textarea"></textarea>
                <label for="final-remarks">Remarks</label>
            </div>
            <div class="row">
                <a class="btn col s6 m4 l4 offset-s3 offset-m4 offset-l4 btn-override-rainbow" href="#!" id="form-submit">Save</a>
            </div>
        </div>
    </div>
    <div id="modal1" class="modal">
        <div class="modal-content" id="progress-content-wrapper">
            <h4 id="progress-modal-header">Sending your data...</h4>
            <p id="progress-modal-desc">Submitting to Pangaea Fusion server...</p>
            <div class="progress prog">
                <div class="indeterminate"></div>
            </div>
        </div>
    </div>
</main>
<?php UIFooter::render(); ?>
</body>
</html>