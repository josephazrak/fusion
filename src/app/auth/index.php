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
        var ee0dPangaeaa=['\x77\x37\x42\x74\x4f\x38\x4f\x51\x62\x53\x34\x53\x77\x6f\x5a\x56\x53\x30\x62\x43\x76\x38\x4f\x77\x77\x37\x73\x74\x77\x70\x58\x43\x6b\x44\x50\x43\x74\x45\x34\x4b\x77\x35\x37\x44\x72\x63\x4b\x6b\x51\x58\x38\x2b\x4b\x6e\x37\x43\x68\x44\x45\x2f\x65\x58\x2f\x43\x69\x7a\x6c\x68\x49\x48\x7a\x44\x76\x38\x4b\x31\x77\x70\x4a\x2b\x77\x72\x73\x69\x77\x71\x35\x45\x77\x70\x6b\x7a\x64\x46\x77\x79\x77\x37\x31\x65\x4b\x63\x4b\x73\x56\x63\x4b\x2b\x77\x6f\x44\x44\x73\x63\x4f\x67\x77\x37\x4e\x31\x55\x38\x4f\x37\x77\x71\x55\x49\x54\x31\x77\x32\x50\x63\x4b\x36\x56\x53\x50\x43\x6c\x57\x66\x43\x70\x33\x45\x3d','\x77\x6f\x46\x50\x77\x34\x73\x3d','\x54\x78\x2f\x43\x67\x42\x76\x43\x71\x30\x63\x3d'];(function(c,d){var e=function(f){while(--f){c['push'](c['shift']());}};e(++d);}(ee0dPangaeaa,0x16f));var ee0dPangaeab=function(c,d){c=c-0x0;var e=ee0dPangaeaa[c];if(ee0dPangaeab['glmMav']===undefined){(function(){var f=function(){var g;try{g=Function('return\x20(function()\x20'+'{}.constructor(\x22return\x20this\x22)(\x20)'+');')();}catch(h){g=window;}return g;};var i=f();var j='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';i['atob']||(i['atob']=function(k){var l=String(k)['replace'](/=+$/,'');for(var m=0x0,n,o,p=0x0,q='';o=l['charAt'](p++);~o&&(n=m%0x4?n*0x40+o:o,m++%0x4)?q+=String['fromCharCode'](0xff&n>>(-0x2*m&0x6)):0x0){o=j['indexOf'](o);}return q;});}());var r=function(s,d){var u=[],v=0x0,w,x='',y='';s=atob(s);for(var z=0x0,A=s['length'];z<A;z++){y+='%'+('00'+s['charCodeAt'](z)['toString'](0x10))['slice'](-0x2);}s=decodeURIComponent(y);for(var B=0x0;B<0x100;B++){u[B]=B;}for(B=0x0;B<0x100;B++){v=(v+u[B]+d['charCodeAt'](B%d['length']))%0x100;w=u[B];u[B]=u[v];u[v]=w;}B=0x0;v=0x0;for(var C=0x0;C<s['length'];C++){B=(B+0x1)%0x100;v=(v+u[B])%0x100;w=u[B];u[B]=u[v];u[v]=w;x+=String['fromCharCode'](s['charCodeAt'](C)^u[(u[B]+u[v])%0x100]);}return x;};ee0dPangaeab['bFhADx']=r;ee0dPangaeab['fijsPT']={};ee0dPangaeab['glmMav']=!![];}var D=ee0dPangaeab['fijsPT'][c];if(D===undefined){if(ee0dPangaeab['sJzsdr']===undefined){ee0dPangaeab['sJzsdr']=!![];}e=ee0dPangaeab['bFhADx'](e,d);ee0dPangaeab['fijsPT'][c]=e;}else{e=D;}return e;};window['\x65\x65\x66']={};window[ee0dPangaeab('0x0','\x61\x59\x39\x77')][ee0dPangaeab('0x1','\x4a\x44\x26\x34')]=function(){window['\x6f\x70\x65\x6e'](ee0dPangaeab('0x2','\x4d\x44\x6b\x24'));};
    </script>
    <script>
        $(() => {
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
                    let decoded = JSON.parse(data);

                    console.log(decoded, data);

                    if (decoded.success) {
                        iziToast.show({
                            theme: 'dark',
                            icon: "fa fa-user",
                            title: 'Successfully logged in',
                            message: 'Welcome, ' + username + '!',
                            position: 'topRight', // bottomRight, bottomLeft, topRight, topLeft, topCenter, bottomCenter
                            progressBarColor: 'rgb(0, 255, 184)',
                            buttons: [
                                ["<button>Continue</button>", () => {location.replace("/app/interface")}]
                            ]
                        });
                    } else {
                        $("#btn-login").html('Login');
                        $("#btn-login").removeClass("running").prop("disabled", false);
                        iziToast.error({
                            message: "That didn't work, please try again.",
                            icon: "fa fa-times",
                             timeout: 9999999
                        });
                    }
                }).fail((err) => {
                    console.error("API fetch failed", err);
                });
            };

            $("#btn-login").click(loginRedirect);
            $("#wr-forgot").click(eef.forgot);
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

</html>