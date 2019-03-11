<?php
    $INCLUDE_ROOT = $_SERVER['DOCUMENT_ROOT'] . '/includes/';
    require_once($INCLUDE_ROOT . "Navbar.php");
    require_once($INCLUDE_ROOT . "Session.php");
?>
<?php
    session_start();

    $logout = false;

    if (isset($_GET['_']))
    {
        session_destroy(); // log-out code
        $logout = true;
    }

    if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true && !loggedOut)
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
    <script src="/assets/izitoast/izitoast.min.js"></script>
    <link rel="stylesheet" type="text/css" href="/assets/loading-btn/loading.css" />
    <link rel="stylesheet" type="text/css" href="/assets/loading-btn/loading-btn.css" />
    <link rel="stylesheet" type="text/css" href="/assets/fonts.css" />
    <link rel="stylesheet" type="text/css" href="/assets/fontawesome/css/all.css" />
    <link rel="stylesheet" type="text/css" href="/assets/izitoast/izitoast.min.css" />
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
            background: #36D1DC;  /* fallback for old browsers */
            background-image: linear-gradient(120deg, #84fab0 0%, #8fd3f4 100%);
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
            $(document).on('keypress', (e) => {
                if(e.which == 13) {
                    if ($("#username-ctrl").is(":focus") || $("#passwd-ctrl").is(":focus"))
                    {
                        loginRedirect();
                    }
                }
            });

            let loginRedirect = () => {
                let username = $("#username-ctrl").val();
                let password = $("#passwd-ctrl").val();

                if (username == "" || password == "")
                    return false;

                $("#btn-login").html('Logging in...<div class="ld ld-ring ld-spin"></div>');
                $("#btn-login").addClass("running").prop("disabled", true);

                $.ajax({
                    "method": "POST",
                    "url": "api/login.php",
                    "data": {
                        username: username,
                        password: password
                    }
                }).done((data) => {
                    try
                    {
                        let decoded = JSON.parse(data);

                        console.log(decoded, data);

                        if (decoded.success) {
                            iziToast.show({
                                theme: 'dark',
                                icon: "fa fa-user",
                                title: "Welcome!",
                                message: decoded.message,
                                position: 'topRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                                progressBarColor: 'rgb(0, 255, 184)',
                                buttons: [
                                    ["<button>Continue</button>", () => {location.replace("/app/interface/")}]
                                ],
                                timeout: 2500
                            });

                            setTimeout(() => {
                                location.replace("/app/interface/");
                            }, 3500);
                        } else {
                            $("#btn-login").html('Login');
                            $("#btn-login").removeClass("running").prop("disabled", false);
                            iziToast.error({
                                message: decoded.message,
                                icon: "fa fa-times",
                                timeout: 9999999
                            });
                        }
                    }
                    catch (e)
                    {
                        iziToast.error({
                            title: "Fatal error",
                            message: toString(e),
                            icon: "fa fa-times",
                            timeout: 9999999
                        });
                        $("#btn-login").html('Login');
                        $("#btn-login").removeClass("running").prop("disabled", false);
                    }


                }).fail((err) => {
                    console.error("API fetch failed", err);
                });
            };

            $("#btn-login").on("click", loginRedirect);
            $("#wr-forgot").on("click", () => {alert("Contact FUSION maintainer — Joseph — to reset your password");});

            // Server-generated:
            <?= ($logout ? 'iziToast.show({theme: "dark", icon: "fa fa-user", title: "Logged out"});' : ''); ?>
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
                            <input class="form-control" type="text" name='username' placeholder="Username" id="username-ctrl"/>
                        </div>
                        <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fas fa-key"></i></div>
                            </div>
                            <input class="form-control" type="password" name='password' placeholder="Password" id="passwd-ctrl"/>
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
</body>

</html>