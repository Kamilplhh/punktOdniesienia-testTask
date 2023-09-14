import '../css/admin.css';
import $, { error } from 'jquery';
window.$ = $;

$('.submit').on("click", function () {
    let value = parseInt($('.back').attr('value')) + 1;
    $('.back').val(value);
    backButton();
})

$('.back').on("click", function () {
    let value = parseInt($('.back').attr('value')) - 1;
    $('.back').val(value);
    backButton();
})


function backButton() {
    let button = $('.back').attr('value');

    if (button == 2) {
        $('.submit').attr("type", "submit");
        $('#skip').removeClass("off");
    } else if (button == -1) {
        window.location.href = '/login';
    } else {
        $('.submit').attr("type", "button");
        $('#skip').addClass("off");
    }

    $('#' + button).removeClass("off");
    $(".block:not(#" + button + ")").addClass("off");
}