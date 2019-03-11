/*
 * Pit Scouting script
 * Joseph Azrak @ PANGAEA
 */

/**
 * Intake.
 * {
 *     type: INTAKE_*,
 *     hatches: bool,
 *     cargo: bool
 * }
 */
const INTAKE_GROUND   = "ground";
const INTAKE_EXCHANGE = "exchange";
const INTAKE_NONE     = "none";

/**
 * Drive-off.
 * {
 *     level: DRIVEOFF_LEVEL*,
 *     assist: {
 *         left: bool,
 *         right: bool,
 *         simultaneous: bool
 *     }
 * }
 */
const DRIVEOFF_LEVEL1 = 1;
const DRIVEOFF_LEVEL2 = 2;

/**
 * Piece ability.
 * {
 *     PIECE_CARGOSHIP: {capable: bool, hatch: bool, cargo: bool},
 *     PIECE_ROCKETLEVEL1: {capable: bool, hatch: bool, cargo: bool},
 *     PIECE_ROCKETLEVEL2: {capable: bool, hatch: bool, cargo: bool},
 *     PIECE_ROCKETLEVEL3: {capable: bool, hatch: bool, cargo: bool}
 * }
 */
const PIECE_CARGOSHIP    = "cargoship";
const PIECE_ROCKETLEVEL1 = "rocketl1";
const PIECE_ROCKETLEVEL2 = "rocketl2";
const PIECE_ROCKETLEVEL3 = "rocketl3";

/**
 * Endgame.
 * {
 *     level: ENDGAME_LEVEL*,
 *     left: bool,
 *     right: bool,
 *     assist: {
 *         capable: bool,
 *         one: bool,
 *         two: bool,
 *         simultaneous: bool
 *     }
 * }
 */
const ENDGAME_LEVEL1 = 1;
const ENDGAME_LEVEL2 = 2;
const ENDGAME_LEVEL3 = 3;
const ENDGAME_NONE   = 0;

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

    INTAKE.SELECTOR.change(() => {
        if (INTAKE.SELECTOR.val() !== "none") {
            $("#group-hatchescargo").show();
        } else {
            $("#group-hatchescargo").hide();
        }
    });

    prefillData();
};

let prefillData = () => {
    if (!window.lastInfo)
        return false;

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

}

$(init);