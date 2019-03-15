<?php
$INCLUDE_ROOT = $_SERVER['DOCUMENT_ROOT'] . '/includes/';
require_once($INCLUDE_ROOT . "Database.php");
require_once($INCLUDE_ROOT . "User.php");
require_once($INCLUDE_ROOT . "GenericRequest.php");
require_once($INCLUDE_ROOT . "Session.php");
require_once($INCLUDE_ROOT . "MatchAgent.php");
require_once($INCLUDE_ROOT . "FusionTeamQuery.php");
require_once($INCLUDE_ROOT . "Logging.php");

$request = new APIRequest();
$database = new FusionDBInterface();
$database->connect();
$logger = new Logger($database);

$data = json_decode($_POST['data'], true);

if (!$data)
    $request -> fail("Invalid data — maybe not JSON-encoded, or `false`") -> terminate();

$internalId = $_POST['teamId'];
$matchId = $_POST['matchId'];

$overwriteMode = FusionMatchAgent::doesTeamHaveMatchRecord($internalId, $matchId, $database);

FusionMatchAgent::registerMatch($internalId, $matchId, $data, $database);

$request->message("Sucessfully written data")->terminate();