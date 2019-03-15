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
    <script src="/assets/izitoast/izitoast.min.js"></script>
    <link href="/assets/materialize/css/materialize.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="/assets/loading-btn/loading.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/loading-btn/loading-btn.css"/>
    <link rel="stylesheet" href="/assets/fonts.css"/>
    <link rel="stylesheet" href="/assets/materialize_whitetheme.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/izitoast/izitoast.min.css" />
    <script src="/assets/pit.js"></script>
    <script>
        let intid=<?=$_GET['t'];?>;

        let back = () => {
            location.replace("/app/interface/");
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
    <div class="container" style="margin-top: 25px;">
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
            <h1 class="flow-text no-bottom-margin">Pit Scouting — Team <?=$name?></h1>
            <p> You are currently <b>pit scouting</b> Team <?=$name?>. Here, you can enter qualitative and quantitative measurements about Team <?=$name?>'s ROBOT.</p>
            <?php
                $lo = PitScoutingInterface::doesTeamHaveData($internal_id_input, $db);
                $lastInfo = null;

                if ($lo)
                {
                    echo "<script>alert('WARNING! This team already has pit scouting data added by " .$lo. ". By proceeding, you are overwriting that data.');</script>";
                    $lastInfo = PitScoutingInterface::getAllDataAndParse($internal_id_input, $db);

                    echo "<script>window.lastInfo = " . json_encode($lastInfo) . ";</script>";
                }

                echo "<script>window.internalId=" . $internal_id_input . ";</script>";
            ?>
            <hr>
            <h1 class="flow-text no-bottom-margin">Intake</h1>
            <!-- FORMSET 1 BEGIN: INTAKE -->
            <div class="formset-1" >
                <div class="row">
                    <div class="input-field col s4 m4 l4">
                        <label>
                            <input type="checkbox" class="filled-in" checked="checked" id="can-ground-intake"/>
                            <span>Ground Intake</span>
                        </label>
                    </div>
                    <div class="input-field col s4 m4 l4">
                        <label>
                            <input type="checkbox" class="filled-in" checked="checked" id="can-ground-hatches"/>
                            <span>Hatches</span>
                        </label>
                    </div>
                    <div class="input-field col s4 m4 l4">
                        <label>
                            <input type="checkbox" class="filled-in" checked="checked" id="can-ground-cargo"/>
                            <span>Cargo</span>
                        </label>
                    </div>
                </div>
                <div class="row" style="margin-top: 35px;">
                    <div class="input-field col s4 m4 l4">
                        <label>
                            <input type="checkbox" class="filled-in" checked="checked" id="can-exchange-intake"/>
                            <span>Exchange Intake</span>
                        </label>
                    </div>
                    <div class="input-field col s4 m4 l4">
                        <label>
                            <input type="checkbox" class="filled-in" checked="checked" id="can-exchange-hatches"/>
                            <span>Hatches</span>
                        </label>
                    </div>
                    <div class="input-field col s4 m4 l4">
                        <label>
                            <input type="checkbox" class="filled-in" checked="checked" id="can-exchange-cargo"/>
                            <span>Cargo</span>
                        </label>
                    </div>
                </div>
            </div>
            <!-- FORMSET 1 END-->
            <h1 class="flow-text no-bottom-margin" style="margin-top: 4.3rem;">Drive-off</h1>
            <!-- FORMSET 2 BEGIN: DRIVEOFF -->
            <div class="row" style="margin-bottom: 55px;">
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
                            <span>Simult. Assist</span>
                        </label>
                    </div>
                </div>
            </div>
            <!-- FORMSET 2 END-->
            <h1 class="flow-text">Piece Ability</h1>
            <!-- FORMSET 3 BEGIN: PIECE ABILITY-->
            <div class="" style="margin-bottom: 55px;">
                <div class="row" style="margin-top:35px">
                    <div class="cargoship-wrapper">
                        <div class="input-field col s4 m4 l4">
                            <label>
                                <input type="checkbox" class="filled-in" id="cargoship-capable"/>
                                <span>Cargo Ship</span>
                            </label>
                        </div>
                        <div class="input-field col s4 m4 l4">
                            <label>
                                <input type="checkbox" class="filled-in" id="cargoship-hatch" style="display: none;"/>
                                <span style="display: none;">Cargo Ship: Hatch</span>
                            </label>
                        </div>
                        <div class="input-field col s4 m4 l4">
                            <label>
                                <input type="checkbox" class="filled-in" id="cargoship-cargo" style="display: none;"//>
                                <span style="display: none;">Cargo Ship: Cargo</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top:35px">
                    <div class="rocketlevel1-wrapper">
                        <div class="input-field col s4 m4 l4">
                            <label>
                                <input type="checkbox" class="filled-in" id="rocketlevel1-capable"/>
                                <span>Rocket L1</span>
                            </label>
                        </div>
                        <div class="input-field col s4 m4 l4">
                            <label>
                                <input type="checkbox" class="filled-in" id="rocketlevel1-hatch" style="display: none;"/>
                                <span style="display: none;">Rocket L1: Hatch</span>
                            </label>
                        </div>
                        <div class="input-field col s4 m4 l4">
                            <label>
                                <input type="checkbox" class="filled-in" id="rocketlevel1-cargo" style="display: none;"//>
                                <span style="display: none;">Rocket L1: Cargo</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top:35px">
                    <div class="rocketlevel2-wrapper">
                        <div class="input-field col s4 m4 l4">
                            <label>
                                <input type="checkbox" class="filled-in" id="rocketlevel2-capable"/>
                                <span>Rocket L2</span>
                            </label>
                        </div>
                        <div class="input-field col s4 m4 l4">
                            <label>
                                <input type="checkbox" class="filled-in" id="rocketlevel2-hatch" style="display: none;"/>
                                <span style="display: none;">Rocket L2: Hatch</span>
                            </label>
                        </div>
                        <div class="input-field col s4 m4 l4">
                            <label>
                                <input type="checkbox" class="filled-in" id="rocketlevel2-cargo"/>
                                <span style="display: none;">Rocket L2: Cargo</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top:35px">
                    <div class="rocketlevel3-wrapper">
                        <div class="input-field col s4 m4 l4">
                            <label>
                                <input type="checkbox" class="filled-in" id="rocketlevel3-capable"/>
                                <span>Rocket L3</span>
                            </label>
                        </div>
                        <div class="input-field col s4 m4 l4">
                            <label>
                                <input type="checkbox" class="filled-in" id="rocketlevel3-hatch" style="display: none;"/>
                                <span style="display: none;">Rocket L3: Hatch</span>
                            </label>
                        </div>
                        <div class="input-field col s4 m4 l4">
                            <label>
                                <input type="checkbox" class="filled-in" id="rocketlevel3-cargo" style="display: none;"//>
                                <span style="display: none;">Rocket L3: Cargo</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- FORMSET 3 END -->
            <h1 class="flow-text">Endgame</h1>
            <!-- FORMSET 4 BEGIN: ENDGAME -->
            <div class="row">
                <div class="input-field col s12 m12 l12">
                    <select id="endgame-level-selector" class="browser-default">
                        <option value="0">None (No Endgame Level)</option>
                        <option value="1">Endgame Level 1</option>
                        <option value="2">Endgame Level 2</option>
                        <option value="3">Endgame Level 3</option>
                    </select>
                </div>
            </div>
            <div class="row" id="endgame-lra" style="margin-top: 0;">
                <div class="input-field col s4 m4 l4">
                    <label>
                        <input type="checkbox" class="filled-in" id="endgame-left"/>
                        <span>Left</span>
                    </label>
                </div>
                <div class="input-field col s4 m4 l4">
                    <label>
                        <input type="checkbox" class="filled-in" id="endgame-right"/>
                        <span>Right</span>
                    </label>
                </div>
                <div class="input-field col s4 m4 l4" style="text-align:right;">
                    <label>
                        <input type="checkbox" class="filled-in" id="endgame-assist" />
                        <span>Assist</span>
                    </label>
                </div>
            </div>
            <div class="row" id="endgame-assist-additional" style="margin-top: 0;">
                <div class="input-field col s4 m2 l2 right" style="text-align:right;">
                    <label>
                        <input type="checkbox" class="filled-in" id="endgame-assist-left" />
                        <span style="display: none;">Left</span>
                    </label>
                </div>
                <div class="input-field col s4 m2 l2 right" style="text-align:right;">
                    <label>
                        <input type="checkbox" class="filled-in" id="endgame-assist-right" />
                        <span style="display: none;">Right</span>
                    </label>
                </div>
                <div class="input-field col s4 m2 l2 right" style="text-align:right;">
                    <label>
                        <input type="checkbox" class="filled-in" id="endgame-assist-simultaneous" />
                        <span style="display: none;">Both</span>
                    </label>
                </div>
            </div>
            <!-- FORMSET 4 END-->
            <h1 class="flow-text">Additional Notes</h1>
            <!-- FORMSET 5 BEGIN: NOTES -->
            <div class="row no-bottom-margin">
                <form class="col s12 m12 l12">
                    <div class="row">
                        <div class="input-field">
                            <textarea id="notes-field" class="materialize-textarea"></textarea>
                            <label for="notes-field">Notes</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col s12 m12 l12">
                    <a class="btn btn-override-rainbow" href="#!" id="form-submit">Save</a>
                </div>
            </div>
            <div id="modal1" class="modal">
                <div class="modal-content" id="progress-content-wrapper">
                    <h4 id="progress-modal-header">Saving your changes...</h4>
                    <p id="progress-modal-desc">Submitting to Pangaea Fusion server...</p>
                    <div class="progress prog">
                        <div class="indeterminate"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
    <!-- FOOTER BEGIN -->
        <?php UIFooter::render(); ?>
    <!-- FOOTER END -->
</body>
</html>