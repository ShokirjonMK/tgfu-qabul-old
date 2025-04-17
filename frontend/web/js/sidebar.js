$(".display_show").click(function() {
    this.classList.toggle("show_active");
    var a = $(".display_show").hasClass("show_active");
    if (!a) {
        $(".root_left").css("left", "-120%");
        $(".root_left").removeClass("ik_start_menu");
    } else {
        $(".root_left").css("left", "0px");
        $(".root_left").addClass("ik_start_menu");
    }
});

$(".close_button").click(function() {
    $(".root_left").css("left", "-120%");
    $(".display_show").removeClass("show_active");
    $(".root_left").removeClass("ik_start_menu");
});