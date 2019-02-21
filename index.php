<?php
    $INCLUDE_ROOT = $_SERVER['DOCUMENT_ROOT'] . '/includes/';
    require_once($INCLUDE_ROOT . "Navbar.php");
?>
<?php
    session_start();

    if (isset($_GET['_']))
    {
        session_destroy(); // log-out code
    }

    if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) 
    {
        header("Location: app/interface/");
        die("If you don't get redirected, click <a href='app/interface/'>here</a>");
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
    <link rel="stylesheet" href="assets/fonts.css">
    <title>Welcome | Fusion</title>
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
    <script>
        $(() => {
            let loginRedirect = () => {
                $("#btn-login").html('Redirecting...<div class="ld ld-ring ld-spin"></div>');
                $("#btn-login").addClass("running").attr("disabled", "1");
                setTimeout(() => {location.replace("app/auth/"); }, 1200);
            };

            $("#btn-login").click(loginRedirect);
        });
    </script>
</head>

<body>
    <?php
        $nav = new Navbar();
        $nav -> setNavbarType("loggedOut");
        $nav -> render();
        ?>
    <div class="container" style='margin-top: 15px'>
        <div class="alert alert-warning" role="alert">
            You are not logged in.
        </div>
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