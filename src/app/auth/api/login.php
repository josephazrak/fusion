<?php
session_start();

$INCLUDE_ROOT = $_SERVER['DOCUMENT_ROOT'] . '/includes/';
require_once($INCLUDE_ROOT . "Database.php");
require_once($INCLUDE_ROOT . "User.php");
require_once($INCLUDE_ROOT . "GenericRequest.php");

$request = new APIRequest();

$database = new FusionDBInterface();
$database->connect();

$username = $_POST['username'];
$password = $_POST['password'];

$gate = new FusionUser($database);

if (!$gate->doesLoginWork($username, $password))
{
    $request -> fail("Username or password incorrect.") -> terminate();
}

$_SESSION["loggedIn"] = true;
$_SESSION["auth"] = [
    "authenticatedAs" => $username
];

$request -> message("Logged in as " . $username) -> terminate();