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
        <title>FUSION Dashboard</title>
        <style>
        </style>
    </head>
    <body>
        <header>
        <!-- NAV BEGIN -->
        <?php
            $Navbar = new Navbar();
            $Navbar->setAuthProvider(FusionSessionInterface::class);
            $Navbar->setNavbarFramework("materialize");
            $Navbar->setNavbarType("loggedIn");
            $Navbar->bindParam("{{P_MODE}}", "Main Menu");
            $Navbar->render();
        ?>
        <!-- NAV END -->
        </header>
        <main>
        <div class="container">
            Hello!
        </div>
        </main>
        <footer class="page-footer">
            <div class="container">
                <div class="row">
                    <div class="col l6 s12">
                        <h5 class="white-text">pangaea fusion</h5>
                        <p class="grey-text text-lighten-4">A fast, lightweight scouting infosystem for Team Pangaea.</p>
                    </div>
<!--                    <div class="col l4 offset-l2 s12">-->
<!--                        <h5 class="white-text">Links</h5>-->
<!--                        <ul>-->
<!--                            <li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>-->
<!--                            <li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>-->
<!--                            <li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li>-->
<!--                            <li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li>-->
<!--                        </ul>-->
<!--                    </div>-->
                </div>
            </div>
            <div class="footer-copyright">
                <div class="container">
                    © 2019 Joseph Azrak @ Team Pangaea
                    <a class="grey-text text-lighten-4 right" href="/app/auth/?_">Log Out...</a>
                </div>
            </div>
        </footer>
    </body>
</html>