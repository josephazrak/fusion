<?php
$INCLUDE_ROOT = $_SERVER['DOCUMENT_ROOT'] . '/includes/';
require_once($INCLUDE_ROOT . "Navbar.php");
require_once($INCLUDE_ROOT . "Session.php");
?>
<?php
session_start();

if (!FusionSessionInterface::isLoggedIn())
{
    header("Location: /app/auth/");
    die("Unauthorized. If you don't get redirected, click <a href='/app/auth/'>here</a>");
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/assets/bootstrap/bootstrap.min.css" rel="stylesheet" />
    <script src="/assets/bootstrap/jquery-3.3.1.slim.min.js"></script>
    <script src="/assets/bootstrap/popper.min.js"></script>
    <script src="/assets/bootstrap/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/loading-btn/loading.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/loading-btn/loading-btn.css"/>
    <link rel="stylesheet" href="/assets/fonts.css">
    <title>FUSION Dashboard</title>
    <style>
        .modern {
            font-family: "Josefin Sans";
        }
        html {
            position: relative;
            min-height: 100%;
        }
        body {
            /* Margin bottom by footer height */
            margin-bottom: 60px;
        }
        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            /* Set the fixed height of the footer here */
            height: 60px;
            background-color: #f5f5f5;
        }
    </style>
</head>

<body>
<?php
$nav = new Navbar();
$nav -> setAuthProvider(FusionSessionInterface::class);
$nav -> setNavbarType("loggedIn");
$nav -> render();
?>
<div class="container" style='margin-top: 15px'>
    <h1 class='display-4 modern'> pangaea fusion </h1>
    <p class='lead modern'> As Pangea's in-house data platform, Fusion enables our members to effectively and quickly catalog scouting, project, and to-do data. </p>
    <button type="button" class="btn btn-primary ld-ext-right" id="btn-login">Log in<div class="ld ld-ring ld-spin"></div></button>
</div>
<footer class="footer" style='margin-top: 5px;'>
    <div class="container" style='margin-top:16px'>
        <span class="text-muted align-middle">(c) 2019 Team Pangaea - Fusion 1.0.0</span>
    </div>
</footer>
</html>