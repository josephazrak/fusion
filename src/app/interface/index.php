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
    <title>FUSION Dashboard</title>
    <script>
        let status = "Enter a team number or team name to access data:";

        let fetchTeamInfoByKeyword = (teamID) => {
            $.ajax({
                "method": "GET",
                "url": "api/teaminfo_search",
                "data": {
                    "term": teamID
                }
            }).done((data) => {
                try {
                    let data2 = (typeof data === "object" ? data : JSON.parse(data));
                    console.log("[api/teaminfo_search] resp: ", data2);

                    $(".prog").hide();

                    if (!data2.success) {
                        alert("The request failed for an unknown reason.");
                        location.reload();
                        return;
                    }

                    let $header = $("#selection-modal-header");
                    let $info = $("#selection-modal-desc");
                    let $button = $("#selection-modal-cta");

                    if (!data2.message.Found) {
                        $header.html("We don't have any info on that team!");
                        $info.html("Would you like to create it?");
                        $button.html("Create team").css("opacity", 1).on("click", () => {
                            makeById(teamID);
                        });
                        return;
                    }

                    $header.html("We found "+ data2.message.Additional.length +" match(es)!");
                    $info.html("Pick the team to scout.");

                    let $collection = $("<div class='collection' id='selection-select'></div>");

                    data2.message.Additional.forEach((suggestion) => {
                        let $collectionItem = $("<a href='#!' class='collection-item'></a>");

                        $collectionItem.html("Team " + suggestion.frcId + " — " + suggestion.niceName);
                        $collectionItem.on("click", () => {
                           editRedirect(suggestion.internalId);
                        });
                        $collectionItem.appendTo($collection);
                    });

                    $collection.appendTo($("#selection-content-wrapper"));
                } catch (e) {
                    console.error("[api/teaminfo_search] err: ", e);
                }
            });
        };

        $(function() {
            $("#welcome-text").html("Welcome to Pangaea Fusion! It is " + (new Date()).toLocaleDateString("en-US", { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) + ".");
            $("#team-id-control").on("input", (e) => {
                let $field = $("#team-id-control");
                let val = $field.val();

                if (val === "" || val === " ") {
                    status = "Enter a team number or team name to access data:";
                    $("#status-text").html(status);
                    return 0;
                }

                status = "Edit or add team: " + val;
                $("#status-text").html(status);
            });


            let dynamicResizeCenter = () => {
                // Get height of <main>
                let mainHeight = $("main").height();
                let contHeight = $(".entry-div").height();

                let newMargin = (mainHeight - contHeight) / 2;

                $(".entry-div").css("margin-top", newMargin);
            };

            $(window).resize(dynamicResizeCenter);

            dynamicResizeCenter();

            $(document).on('keypress',function(e) {
                if(e.which == 13) {
                    $val = $("#team-id-control").val();

                    $("#selection-modal-header").html("Please wait...");
                    $("#selection-select").remove();
                    $("#selection-modal-desc").html("Querying team status...");
                    $("#selection-modal-cta").css("opacity", 0);
                    $(".prog").show();

                    M.Modal.init(document.querySelectorAll('.modal'), {})[0].open();

                    fetchTeamInfoByKeyword($val);
                }
            });
        });

        window.editRedirect = (id) => {
            location.replace("/app/interface/frc/?t=" + id)
        };

        window.makeById = (id) => {
            location.replace("/app/interface/create/?id=" + id);
        };
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
        <div class="entry-div">
            <h1 class="flow-text center-align" id="welcome-text">Welcome to Pangaea Fusion!</h1>
            <p class="center-align" id="status-text">Enter a team number or team name to access data:</p>
            <div class="center-align">
                <input type="text" id="team-id-control" placeholder='6813 or "Team Pangaea" or "Pangaea"...' class="autocomplete"></input>
<!--                <div style="margin-top: 15px">-->
<!--                    <a class="btn waves-light btn-override-rainbow">Scout</a>-->
<!--                </div>-->
            </div>
        </div>
    </div>
    <div id="modal1" class="modal">
        <div class="modal-content" id="selection-content-wrapper">
            <h4 id="selection-modal-header">Please wait...</h4>
            <p id="selection-modal-desc">Querying team status...</p>
            <div class="progress prog">
                <div class="indeterminate"></div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat" id="selection-modal-cta" style="opacity: 0;" data-for-frcid="">create it</a>
        </div>
    </div>
</main>
<?php UIFooter::render(); ?>
</body>
</html>