<?php
$INCLUDE_ROOT = $_SERVER['DOCUMENT_ROOT'] . '/includes/';
require_once($INCLUDE_ROOT . "Navbar.php");
require_once($INCLUDE_ROOT . "Session.php");
require_once($INCLUDE_ROOT . "Footer.php");
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
    <script src="/assets/materialize/js/materialize.js"></script>
    <link href="/assets/materialize/css/materialize.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="/assets/loading-btn/loading.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/loading-btn/loading-btn.css"/>
    <link rel="stylesheet" href="/assets/fonts.css"/>
    <link rel="stylesheet" href="/assets/materialize_whitetheme.css"/>
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
    $Navbar->bindParam("{{P_MODE}}", "Creating " . $_GET['id']);
    $Navbar->render();
    ?>
    <!-- NAV END -->
</header>
<main>
    <div class="container">
        <h1 class="flow-text">Creating team manifest</h1>
    </div>
</main>
<?php UIFooter::render(); ?>
</body>
</html>