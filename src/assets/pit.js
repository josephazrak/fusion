/*
 * Pit Scouting script
 * Joseph Azrak @ PANGAEA
 */

let isChecked = (elem) => {
    return (elem.prop("checked"));
};

let getSelectionValFinal = (selection) => {
    return selection.val();
}

let hideCheckmark = (checkmark) => {
    checkmark.parent().find("span").fadeOut("fast");
};

let showCheckmark = (checkmark) => {
    checkmark.parent().find("span").fadeIn("fast");
};

let init = () => {
    window.INTAKE = {
        SELECTOR: $("#intake-selector"),
        HATCHES: $("#intake-hatches"),
        CARGO: $("#intake-cargo")
    };

    window.DRIVEOFF = {
        SELECTOR: $("#driveoff-selector"),
        LEFT: $("#assist-left"),
        RIGHT: $("#assist-right"),
        SIMUL: $("#assist-simul")
    };

    window.PIECES = {
        CARGOSHIP: {
            capable: $("#cargoship-capable"),
            hatch: $("#cargoship-hatch"),
            cargo: $("#cargoship-cargo")
        },
        ROCKETLEVEL1: {
            capable: $("#rocketlevel1-capable"),
            hatch: $("#rocketlevel1-hatch"),
            cargo: $("#rocketlevel1-cargo")
        },
        ROCKETLEVEL2: {
            capable: $("#rocketlevel2-capable"),
            hatch: $("#rocketlevel2-hatch"),
            cargo: $("#rocketlevel2-cargo")
        },
        ROCKETLEVEL3: {
            capable: $("#rocketlevel3-capable"),
            hatch: $("#rocketlevel3-hatch"),
            cargo: $("#rocketlevel3-cargo")
        }
    };

    window.ENDGAME = {
        LEVEL: $("#endgame-level-selector"),
        LEFT: $("#endgame-left"),
        RIGHT: $("#endgame-right"),
        ASSIST: {
            CAPABLE: $("#endgame-assist"),
            LEFT: $("#endgame-assist-left"),
            RIGHT: $("#endgame-assist-right"),
            SIMULTAENOUS: $("#endgame-assist-simultaneous")
        }
    };

    INTAKE.SELECTOR.change(() => {
        if (INTAKE.SELECTOR.val() !== "none") {
            $("#group-hatchescargo").show();
        } else {
            $("#group-hatchescargo").hide();
        }
    });

    PIECES.CARGOSHIP.capable.change(() => {
        if (isChecked(PIECES.CARGOSHIP.capable))
        {
            PIECES.CARGOSHIP.hatch.parent().find("span").fadeIn("fast");
            PIECES.CARGOSHIP.cargo.parent().find("span").fadeIn("fast");
        } else {
            PIECES.CARGOSHIP.hatch.parent().find("span").fadeOut("fast");
            PIECES.CARGOSHIP.cargo.parent().find("span").fadeOut("fast");
        }
    });

    PIECES.ROCKETLEVEL1.capable.change(() => {
        if (isChecked(PIECES.ROCKETLEVEL1.capable))
        {
            PIECES.ROCKETLEVEL1.hatch.parent().find("span").fadeIn("fast");
            PIECES.ROCKETLEVEL1.cargo.parent().find("span").fadeIn("fast");
        } else {
            PIECES.ROCKETLEVEL1.hatch.parent().find("span").fadeOut("fast");
            PIECES.ROCKETLEVEL1.cargo.parent().find("span").fadeOut("fast");
        }
    });

    PIECES.ROCKETLEVEL2.capable.change(() => {
        if (isChecked(PIECES.ROCKETLEVEL2.capable))
        {
            PIECES.ROCKETLEVEL2.hatch.parent().find("span").fadeIn("fast");
            PIECES.ROCKETLEVEL2.cargo.parent().find("span").fadeIn("fast");
        } else {
            PIECES.ROCKETLEVEL2.hatch.parent().find("span").fadeOut("fast");
            PIECES.ROCKETLEVEL2.cargo.parent().find("span").fadeOut("fast");
        }
    });

    PIECES.ROCKETLEVEL3.capable.change(() => {
        if (isChecked(PIECES.ROCKETLEVEL3.capable))
        {
            PIECES.ROCKETLEVEL3.hatch.parent().find("span").fadeIn("fast");
            PIECES.ROCKETLEVEL3.cargo.parent().find("span").fadeIn("fast");
        } else {
            PIECES.ROCKETLEVEL3.hatch.parent().find("span").fadeOut("fast");
            PIECES.ROCKETLEVEL3.cargo.parent().find("span").fadeOut("fast");
        }
    });

    ENDGAME.LEVEL.change(() => {
        if (ENDGAME.LEVEL.val() !== "0")
        {
            showCheckmark(ENDGAME.LEFT);
            showCheckmark(ENDGAME.RIGHT);
            showCheckmark(ENDGAME.ASSIST.CAPABLE);
            ENDGAME.ASSIST.CAPABLE.change();
        } else {
            hideCheckmark(ENDGAME.LEFT);
            hideCheckmark(ENDGAME.RIGHT);
            hideCheckmark(ENDGAME.ASSIST.CAPABLE);
            hideCheckmark(ENDGAME.ASSIST.LEFT);
            hideCheckmark(ENDGAME.ASSIST.RIGHT);
            hideCheckmark(ENDGAME.ASSIST.SIMULTAENOUS);
        }
    });

    ENDGAME.ASSIST.CAPABLE.change(() => {
        if (isChecked(ENDGAME.ASSIST.CAPABLE))
        {
            showCheckmark(ENDGAME.ASSIST.LEFT);
            showCheckmark(ENDGAME.ASSIST.RIGHT);
            showCheckmark(ENDGAME.ASSIST.SIMULTAENOUS);
        } else {
            hideCheckmark(ENDGAME.ASSIST.LEFT);
            hideCheckmark(ENDGAME.ASSIST.RIGHT);
            hideCheckmark(ENDGAME.ASSIST.SIMULTAENOUS);
        }
    });
    prefillData();

    $("#form-submit").on("click", exportData);
};

let prefillDefaults = () => {
    console.log("[prefill]", "prefilling defaults as no pit scouting data");
    INTAKE.SELECTOR.val("none").change();

    DRIVEOFF.SELECTOR.val("1").change();
    DRIVEOFF.LEFT.prop("checked", false);
    DRIVEOFF.RIGHT.prop("checked", false);
    DRIVEOFF.SIMUL.prop("checked", false);

    PIECES.CARGOSHIP.capable.prop("checked", false).change();
    PIECES.ROCKETLEVEL1.capable.prop("checked", false).change();
    PIECES.ROCKETLEVEL2.capable.prop("checked", false).change();
    PIECES.ROCKETLEVEL3.capable.prop("checked", false).change();

    ENDGAME.LEVEL.val("0").change();
    ENDGAME.LEFT.prop("checked", false);
    ENDGAME.RIGHT.prop("checked", false);
    ENDGAME.ASSIST.CAPABLE.prop("checked", false).change();
}

let prefillData = () => {
    if (!("lastInfo" in window)) {
        prefillDefaults();
        return false;
    }

    // Pre-fill intake
    INTAKE.SELECTOR.val(window.lastInfo.intake.type).change();
    INTAKE.HATCHES.prop("checked", window.lastInfo.intake.hatches);
    INTAKE.CARGO.prop("checked", window.lastInfo.intake.cargo);

    // Pre-fill driveoff
    DRIVEOFF.SELECTOR.val(window.lastInfo.driveoff.level);
    DRIVEOFF.LEFT.prop("checked", window.lastInfo.driveoff.assist.left);
    DRIVEOFF.RIGHT.prop("checked", window.lastInfo.driveoff.assist.right);
    DRIVEOFF.SIMUL.prop("checked", window.lastInfo.driveoff.assist.simultaneous);

    // Pre-fill parts
    PIECES.CARGOSHIP.capable.prop("checked", window.lastInfo.pieceability.cargoship.capable).change();
    PIECES.CARGOSHIP.cargo.prop("checked", window.lastInfo.pieceability.cargoship.cargo);
    PIECES.CARGOSHIP.hatch.prop("checked", window.lastInfo.pieceability.cargoship.hatch);

    PIECES.ROCKETLEVEL1.capable.prop("checked", window.lastInfo.pieceability.rocketl1.capable).change();
    PIECES.ROCKETLEVEL1.cargo.prop("checked", window.lastInfo.pieceability.rocketl1.cargo);
    PIECES.ROCKETLEVEL1.hatch.prop("checked", window.lastInfo.pieceability.rocketl1.hatch);

    PIECES.ROCKETLEVEL2.capable.prop("checked", window.lastInfo.pieceability.rocketl2.capable).change();
    PIECES.ROCKETLEVEL2.cargo.prop("checked", window.lastInfo.pieceability.rocketl2.cargo);
    PIECES.ROCKETLEVEL2.hatch.prop("checked", window.lastInfo.pieceability.rocketl2.hatch);

    PIECES.ROCKETLEVEL3.capable.prop("checked", window.lastInfo.pieceability.rocketl3.capable).change();
    PIECES.ROCKETLEVEL3.cargo.prop("checked", window.lastInfo.pieceability.rocketl3.cargo);
    PIECES.ROCKETLEVEL3.hatch.prop("checked", window.lastInfo.pieceability.rocketl3.hatch);

    // Pre-fill endgame
    ENDGAME.LEVEL.val(window.lastInfo.endgame.level).change();
    ENDGAME.LEFT.prop("checked", window.lastInfo.endgame.left);
    ENDGAME.RIGHT.prop("checked", window.lastInfo.endgame.right);
    ENDGAME.ASSIST.CAPABLE.prop("checked", window.lastInfo.endgame.assist.capable).change();

    ENDGAME.ASSIST.LEFT.prop("checked", window.lastInfo.endgame.assist.left);
    ENDGAME.ASSIST.RIGHT.prop("checked", window.lastInfo.endgame.assist.right);
    ENDGAME.ASSIST.SIMULTAENOUS.prop("checked", window.lastInfo.endgame.assist.simultaneous);

    // Pre-fill notes
    $("#notes-field").val(window.lastInfo.notes).focus();
    M.textareaAutoResize($("#notes-field").get(0)); // resize notes area

    console.log("[prefill]", "done prefilling");
};

let exportData = () => {
    console.log("[export]", "preparing for export...");

    let pit = {
        intake: {type: "", hatches: false, cargo: false},
        driveoff: {level: 0, assist: {left: false, right: false, simultaneous: false}},
        pieceability: {"cargoship": {"capable": true, "hatch": true, "cargo": true}, "rocketl1": {"capable": true, "hatch": true, "cargo": false}, "rocketl2":  {"capable": false, "hatch": true, "cargo": false}, "rocketl3":  {"capable": true, "hatch": true, "cargo": false}},
        endgame: {level: 0, left: false, right: false, assist: {capable: false, left: false, right: false, simultaneous: false}},
        notes: ""
    };

    console.log("[export] initial, ", window.lastInfo);

    // INTAKE Export
    pit.intake.type    = INTAKE.SELECTOR.val();
    pit.intake.hatches = isChecked(INTAKE.HATCHES);
    pit.intake.cargo   = isChecked(INTAKE.CARGO);

    // DRIVEOFF Export
    pit.driveoff.level               = parseInt(DRIVEOFF.SELECTOR.val());
    pit.driveoff.assist.left         = isChecked(DRIVEOFF.LEFT);
    pit.driveoff.assist.right        = isChecked(DRIVEOFF.RIGHT);
    pit.driveoff.assist.simultaneous = isChecked(DRIVEOFF.SIMUL);

    // PIECEABILITY Export
    pit.pieceability.cargoship.capable = isChecked(PIECES.CARGOSHIP.capable);
    pit.pieceability.cargoship.hatch   = isChecked(PIECES.CARGOSHIP.hatch);
    pit.pieceability.cargoship.cargo   = isChecked(PIECES.CARGOSHIP.cargo);
    pit.pieceability.rocketl1.capable  = isChecked(PIECES.ROCKETLEVEL1.capable);
    pit.pieceability.rocketl1.hatch    = isChecked(PIECES.ROCKETLEVEL1.hatch);
    pit.pieceability.rocketl1.cargo    = isChecked(PIECES.ROCKETLEVEL1.cargo);
    pit.pieceability.rocketl2.capable  = isChecked(PIECES.ROCKETLEVEL2.capable);
    pit.pieceability.rocketl2.hatch    = isChecked(PIECES.ROCKETLEVEL2.hatch);
    pit.pieceability.rocketl2.cargo    = isChecked(PIECES.ROCKETLEVEL2.cargo);
    pit.pieceability.rocketl3.capable  = isChecked(PIECES.ROCKETLEVEL3.capable);
    pit.pieceability.rocketl3.hatch    = isChecked(PIECES.ROCKETLEVEL3.hatch);
    pit.pieceability.rocketl3.cargo    = isChecked(PIECES.ROCKETLEVEL3.cargo);

    // ENDGAME Export
    pit.endgame.level = parseInt(ENDGAME.LEVEL.val());
    pit.endgame.left = isChecked(ENDGAME.LEFT);
    pit.endgame.right = isChecked(ENDGAME.RIGHT);
    pit.endgame.assist.capable = isChecked(ENDGAME.ASSIST.CAPABLE);
    pit.endgame.assist.left = isChecked(ENDGAME.ASSIST.LEFT);
    pit.endgame.assist.right = isChecked(ENDGAME.ASSIST.RIGHT);
    pit.endgame.assist.simultaneous = isChecked(ENDGAME.ASSIST.SIMULTAENOUS);

    // NOTES Export
    pit.notes = $("#notes-field").val();

    console.log("[export] to save: ", pit);
    M.Modal.init(document.querySelectorAll('.modal'), {})[0].open();

    $.ajax({
        "url": "/app/interface/api/pitscout_submit/",
        "method": "POST",
        "data": {
            "internalId": window.internalId,
            "data": JSON.stringify(pit)
        }
    }).done((resp) => {
        resp = (typeof resp === "object")? resp: JSON.parse(resp);
        $(".prog").fadeOut(50);
        let timeleft = 8;
        if (resp.success) {
            let temp = "FUSION server said: " + resp.message + " Redirecting in ";

            iziToast.show({message: resp.message, theme: "dark"});

            $("#progress-modal-header").html("Success!");
            $("#progress-modal-desc").html(temp + timeleft.toString());

            setInterval(() => {
                if (timeleft <= 0) {
                    location.replace("/app/interface/");
                    return;
                }
                timeleft--;
                $("#progress-modal-desc").html(temp + timeleft.toString());
            }, 1000);

        } else {
            iziToast.show({message: "ERROR! Failed! Check console for more details."});
            console.error("The pit record update failed! API Response: ", resp);
            $("#progress-modal-header").html("The server returned an error.");
            $("#progress-modal-desc").html("Please keep this page open and tell Joseph about this issue — show the following info:");
            $("#progress-modal-desc").parent().append($("<pre></pre>").html(
                "SERVER: " + JSON.stringify(resp) + "<br>" +
                "CLIENT: POST " + JSON.stringify({"internalId": window.internalId, "data": JSON.stringify(pit)})
            ));
        }
    });
};

$(init);