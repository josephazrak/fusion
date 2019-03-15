/**
 * Joseph Azrak @ TEAM PANGAEA
 */

let registerMenuBindingsDetails = (menu, binds) => {
    $(menu).change(() => {
        binds.forEach((bind) => {
            if ($(menu).val() == bind.value) {
               binds.forEach((e) => { $(e.selector).hide(); });
               $(bind.selector).fadeIn();
            } else if ($(menu).val() == "none") {
                binds.forEach((e) => { $(e.selector).hide(); });
            }
        });
    });
};

let gval_select = (select) => {
    return $(select).val();
};

let gval_text = (text) => {
    return $(text).val();
};

let int = (x) => {
    return parseInt(x);
};

let bool = (x) => {
    if (x === "true")
    {
        return true;
    } else if (x === "false") {
        return false;
    }
};

let exportData = (matchId, teamId) => {
    let data = {
        metadata: {thisMatch: matchId, thisTeam: teamId},
        sandstorm: {
            preloaded: gval_select("#preloaded-piece"),
            startpos: int(gval_select("#starting-position")),
            driveoff: {
                status: bool(gval_select("#driveoff-success")),
                successType: gval_select("#driveoff-solo-or-assisted"),
                failureNotes: gval_text("#driveoff-failure-notes-text")
            },
            score: {
                cargo: {
                    successful: {
                        cargoship: int(gval_text("#cargo-success-cargoship-sandstorm")),
                        rocket1: int(gval_text("#cargo-success-rocketship1-sandstorm")),
                        rocket2: int(gval_text("#cargo-success-rocketship2-sandstorm")),
                        rocket3: int(gval_text("#cargo-success-rocketship3-sandstorm"))
                    },
                    unsuccessful: int(gval_text("#cargo-fails-sandstorm"))
                },
                hatches: {
                    successful: {
                        cargoship: int(gval_text("#hatches-success-cargoship-sandstorm")),
                        rocket1: int(gval_text("#hatches-success-rocketship1-sandstorm")),
                        rocket2: int(gval_text("#hatches-success-rocketship2-sandstorm")),
                        rocket3: int(gval_text("#hatches-success-rocketship3-sandstorm"))
                    },
                    unsuccessful: int(gval_text("#hatches-fails-sandstorm"))
                }
            }
        },
        teleop: {
            score: {
                cargo: {
                    successful: {
                        cargoship: int(gval_text("#cargo-success-cargoship-teleop")),
                        rocket1: int(gval_text("#cargo-success-rocketship1-teleop")),
                        rocket2: int(gval_text("#cargo-success-rocketship2-teleop")),
                        rocket3: int(gval_text("#cargo-success-rocketship3-teleop"))
                    },
                    unsuccessful: int(gval_text("#cargo-fails-teleop"))
                },
                hatches: {
                    successful: {
                        cargoship: int(gval_text("#hatches-success-cargoship-teleop")),
                        rocket1: int(gval_text("#hatches-success-rocketship1-teleop")),
                        rocket2: int(gval_text("#hatches-success-rocketship2-teleop")),
                        rocket3: int(gval_text("#hatches-success-rocketship3-teleop"))
                    },
                    unsuccessful: int(gval_text("#hatches-fails-teleop"))
                }
            }
        },
        endgame: {
            robotClimbStatus: gval_select("#did-robot-climb"),
            endingState: gval_select("#ending-state"),
            remarks: gval_text("#final-remarks")
        }
    };

    console.log(data);

    M.Modal.init(document.querySelectorAll('.modal'), {})[0].open();

    $.ajax({
        "url": "/app/interface/api/matchscout_submit/",
        "method": "POST",
        "data": {
            "matchId": window.matchId,
            "teamId": window.internalId,
            "data": JSON.stringify(data)
        }
    }).done((resp) => {
        resp = (typeof resp === "object")? resp: JSON.parse(resp);
        $(".prog").fadeOut(50);

        if (resp.success) {
            $("#progress-modal-header").html("Success!");
            $("#progress-modal-desc").html("Saved that match data. <a href='/app/interface/'>Back home?</a>");
        } else {
            $("#progress-modal-header").html("Something's wrong.");
            $("#progress-modal-desc").html(resp.message);
        }
    });
};

let init = () => {
    registerMenuBindingsDetails($("#driveoff-success"), [
        {value: "true", selector: "#driveoff-success-notes"},
        {value: "false", selector: "#driveoff-failure-notes"}
    ]);

};

$(init);