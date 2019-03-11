window.dynamicResizeCenter = () => {
    // Get height of <main>
    let mainHeight = $("main").height();
    let contHeight = $(".center-div").height();

    let newMargin = (mainHeight - contHeight) / 2;

    $(".center-div").css("margin-top", newMargin);
};

$(window).resize(dynamicResizeCenter);

$(dynamicResizeCenter);