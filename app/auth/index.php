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
        header("Location: /app/interface/");
        die("If you don't get redirected, click <a href='/app/interface/'>here</a>");
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
    <link rel="stylesheet" type="text/css" href="/assets/loading-btn/loading.css" />
    <link rel="stylesheet" type="text/css" href="/assets/loading-btn/loading-btn.css" />
    <link rel="stylesheet" type="text/css" href="/assets/fonts.css">
    <link rel="stylesheet" type="text/css" href="/assets/fontawesome/css/all.css">
    <title>Log In | Fusion</title>
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
            background: #8360c3;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #008741, #54d1ea);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #008741, #54d1ea); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

        }
        .Absolute-Center {
  margin: auto;
  position: absolute;
  top: 0; left: 0; bottom: 0; right: 0;
}

.Absolute-Center.is-Responsive {
  width: 50%; 
  height: 50%;
  min-width: 300px;
  max-width: 500px;
  padding: 50px;
}
    </style>
    <script>
        $(() => {
            let loginRedirect = () => {
                $("#btn-login").html('Logging in...<div class="ld ld-ring ld-spin"></div>');
                $("#btn-login").addClass("running").attr("disabled", "1");
            };

            $("#btn-login").click(loginRedirect);
            $("#wr-forgot").click(() => {
                
            });
        });

    </script>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="Absolute-Center is-Responsive">
                <div id="logo-container"></div>
                <div class="col-sm-12 col-md-10 col-md-offset-1" style="background: #ffffff; border-radius: 20px;">
                    <form action="" id="loginForm">
                        <div class="text-center"> <img src="/assets/img/logo-black.png" style='max-width: 70%; margin-top: 15px; margin-bottom: 15px; ' class="text-center"></div>
                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-user"></i></div>
                            </div>
                            <input class="form-control" type="text" name='username' placeholder="Username" />
                        </div>
                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-key"></i></div>
                            </div>
                            <input class="form-control" type="password" name='password' placeholder="Password" />
                        </div>
                        <div class="form-group text-center">
                            <button type="button" id="btn-login" class="btn btn-primary ld-ext-right">Login<div class="ld ld-ring ld-spin"></div></button>
                        </div>
                        <div class="form-group text-center">
                            <a href="#" id="wr-forgot">Forgot?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</html>