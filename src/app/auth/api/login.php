<?php
    session_start();

    $INCLUDE_ROOT = $_SERVER['DOCUMENT_ROOT'] . '/includes/';
    require_once($INCLUDE_ROOT . "Database.php");
    require_once($INCLUDE_ROOT . "User.php");
    require_once($INCLUDE_ROOT . "GenericRequest.php");
    require_once($INCLUDE_ROOT . "Session.php");
    require_once($INCLUDE_ROOT . "Logging.php");

    $request = new APIRequest();

    $database = new FusionDBInterface();
    $database->connect();
    $logger = new Logger($database);

    $username = $_POST['username'];
    $password = $_POST['password'];

    $gate = new FusionUser($database);

    if (!$gate->doesLoginWork($username, $password))
    {
        $logger->addLogEntry("SECURITY", "WARN", "Login failed for " . $username . " from " . $_SERVER["REMOTE_ADDR"]);
        $request -> fail("Username or password incorrect.") -> terminate();
    }

    $niceName = $gate->getNiceName($username);

    FusionSessionInterface::setIsLoggedIn(true);
    FusionSessionInterface::setLoggedInUser($username, $niceName);

    $logger->addLogEntry("SECURITY", "INFO", "Login succeeded for " . $username . " from " . $_SERVER["REMOTE_ADDR"]);

    $request -> message("Logged in as " . $niceName) -> terminate();