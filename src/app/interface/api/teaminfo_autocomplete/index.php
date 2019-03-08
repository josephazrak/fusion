<?php
    $INCLUDE_ROOT = $_SERVER['DOCUMENT_ROOT'] . '/includes/';
    require_once($INCLUDE_ROOT . "Database.php");
    require_once($INCLUDE_ROOT . "User.php");
    require_once($INCLUDE_ROOT . "GenericRequest.php");
    require_once($INCLUDE_ROOT . "Session.php");
    require_once($INCLUDE_ROOT . "FusionTeamQuery.php");

    $request = new APIRequest();
    $database = new FusionDBInterface();
    $database->connect();

    $teams = FusionTeamQuery::getTeamAutocompleteInfoArray($database);
    $buffer = [];

    foreach ($teams as $value) {
        $buffer[$value["frcTeamId"] . " —— " . $value["frcTeamName"]] = "";
    }

    $request -> message($buffer) -> terminate();