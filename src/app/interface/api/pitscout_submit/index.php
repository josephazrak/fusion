<?php
$INCLUDE_ROOT = $_SERVER['DOCUMENT_ROOT'] . '/includes/';
require_once($INCLUDE_ROOT . "Database.php");
require_once($INCLUDE_ROOT . "User.php");
require_once($INCLUDE_ROOT . "GenericRequest.php");
require_once($INCLUDE_ROOT . "Session.php");
require_once($INCLUDE_ROOT . "PitScoutingInterface.php");
require_once($INCLUDE_ROOT . "FusionTeamQuery.php");
require_once($INCLUDE_ROOT . "Logging.php");

$request = new APIRequest();
$database = new FusionDBInterface();
$database->connect();
$logger = new Logger($database);

$data = json_decode($_POST['data'], true);

if (!$data)
    $request -> fail("Invalid data") -> terminate();

$internalId = $_POST['internalId'];

$overwriteMode = false;
$overwriteBy = NULL;

//try {
//    assert($data["intake"]);
//    assert($data["intake"]["type"]);
//    assert($data["intake"]["hatches"]);
//    assert($data["intake"]["cargo"]);
//
//    assert($data["driveoff"]);
//    assert($data["driveoff"]["level"]);
//    assert($data["driveoff"]["assist"]);
//    assert($data["driveoff"]["assist"]["left"]);
//    assert($data["driveoff"]["assist"]["right"]);
//    assert($data["driveoff"]["assist"]["simultaneous"]);
//
//    assert($data["pieceability"]);
//    assert($data["pieceability"]["cargoship"]);
//    assert($data["pieceability"]["cargoship"]["capable"]);
//    assert($data["pieceability"]["cargoship"]["hatch"]);
//    assert($data["pieceability"]["cargoship"]["cargo"]);
//    assert($data["pieceability"]["rocketl1"]);
//    assert($data["pieceability"]["rocketl1"]["capable"]);
//    assert($data["pieceability"]["rocketl1"]["hatch"]);
//    assert($data["pieceability"]["rocketl1"]["cargo"]);
//    assert($data["pieceability"]["rocketl2"]);
//    assert($data["pieceability"]["rocketl2"]["capable"]);
//    assert($data["pieceability"]["rocketl2"]["hatch"]);
//    assert($data["pieceability"]["rocketl2"]["cargo"]);
//    assert($data["pieceability"]["rocketl3"]);
//    assert($data["pieceability"]["rocketl3"]["capable"]);
//    assert($data["pieceability"]["rocketl3"]["hatch"]);
//    assert($data["pieceability"]["rocketl3"]["cargo"]);
//
//    assert($data["endgame"]);
//    assert($data["endgame"]["level"]);
//    assert($data["endgame"]["left"]);
//    assert($data["endgame"]["right"]);
//    assert($data["endgame"]["assist"]);
//    assert($data["endgame"]["assist"]["capable"]);
//    assert($data["endgame"]["assist"]["left"]);
//    assert($data["endgame"]["assist"]["right"]);
//    assert($data["endgame"]["assist"]["simultaneous"]);
//} catch (Exception $exception) {
//    var_dump($e);
//    die;
//}

if (empty($internalId) || !FusionTeamQuery::teamExistsByInternalId($internalId, $database)) {
    $request -> fail("Team does not exist") -> terminate();
}

$teamInfo = FusionTeamQuery::getTeamInfoByInternalId($internalId, $database);
$frcID = $teamInfo[0]["frcTeamID"];

if (PitScoutingInterface::doesTeamHaveData($internalId, $database)) {
    $overwriteMode = true;
}

$currentUser = FusionSessionInterface::getLoggedInUsername();

if (!$overwriteMode) {
    // Create new PIT entry because we are not in overwrite mode
    PitScoutingInterface::createPitEntry($internalId, $frcID, $data, $currentUser, $database);
} else {
    // Overwrite existing PIT entry because we determined such an entry exists
    PitScoutingInterface::overwritePitEntry($internalId, $data, $currentUser, $database);
}

// Either way, we now have PIT information on this team, snapshot it.
$revisionId = PitScoutingInterface::registerSnapshotByInternalId($internalId, $currentUser, $database);

// Log
if ($overwriteMode) {
    $logger->addLogEntry("PIT DATA", "INFO", "PIT FOR fusion:" . $internalId . " (frc:" . $frcID . ") OVERWRITTEN BY " . $currentUser . " (revision-id: " . $revisionId . ")");
} else {
    $logger->addLogEntry("PIT DATA", "INFO", "PIT FOR fusion:" . $internalId . " (frc:" . $frcID . ") CREATED BY " . $currentUser . " (revision-id: " . $revisionId . ")");
}


$request -> message("Successfully " . ($overwriteMode? "overwritten pit entry.": "created pit entry.")) -> terminate();