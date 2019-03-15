let mem = {
    matchNumber: 0
};

let pc = 0;
let done = false;

let init = () => {
    window.OBJ = {
        matchIdInput: $("#match-id"),
        confirmButtonStep1: $("#step-1-confirm"),
        step1Wrapper: $(".step-1-wrapper"),
        step2Wrapper: $(".step-2-wrapper"),
        step2Confirm: $("#step-2-confirmation")
    };

    let steps = [
        // 0
        () => {
            if (done) return 0;

            let l = OBJ.matchIdInput.val();

            if (isNaN(l))
                return;

            mem.matchNumber = l;

            OBJ.step2Wrapper.fadeIn();
            OBJ.step2Confirm.html(OBJ.step2Confirm.html() + l + ". Is this correct?");

            done = true;
        },
    ];

    $("#step-1-confirm").click(steps[0]);
    $("#yes-btn").click(() => {
        location.replace("/app/interface/frc/match/withid/?id=" + mem.matchNumber + "&t=" + window.internalId);
    });
};

$(init);