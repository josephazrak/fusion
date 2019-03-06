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
        <script>
            $(function() {
                $("#welcome-text").html("Welcome to Pangaea Fusion! It is " + (new Date()).toLocaleDateString("en-US", { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) + ".")
            });
        </script>
    </head>
    <body>
        <header>
        <!-- NAV BEGIN -->
        <?php
            $Navbar = new Navbar();
            $Navbar->setAuthProvider(FusionSessionInterface::class);
            $Navbar->setNavbarFramework("materialize");
            $Navbar->setNavbarType("loggedIn");
            $Navbar->bindParam("{{P_MODE}}", "Scouting");
            $Navbar->render();
        ?>
        <!-- NAV END -->
        </header>
        <main>
        <div class="container">
                <h1 class="flow-text center-align" id="welcome-text">Welcome to Pangaea Fusion!</h1>
                <p class="center-align" id="status-text">Enter a team number or team name to access data:</p>
                <div class="center-align">
                    <input type="text" placeholder='6813 or "Team Pangaea"...'></input>
                    <div style="margin-top: 15px">
                        <a class="btn waves-light btn-override-rainbow">Scout</a>
                    </div>
                </div>
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