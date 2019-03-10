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

    $TERM = $_GET['term'];

    if (!isset($_GET['term'])) {
        $request -> fail(["Found" => false, "Additional" => null]) -> terminate();
    }

    $searchResults = FusionTeamQuery::searchByStringOrID($TERM, $database);
    $buffer = [];
    $foundAny = false;

    foreach ($searchResults as $result) {
        $buffer[] = [
            'internalId' => $result["fusionTeamID"],
            'niceName' => $result["frcTeamName"],
            'frcId' => $result["frcTeamID"]
        ];
        $foundAny = true;
    }

    $request -> message(["Found" => $foundAny, "Additional" => $buffer]) -> terminate();