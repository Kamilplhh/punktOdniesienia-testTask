import $, { error } from 'jquery';
window.$ = $;

$('.next').on("click", function () {
    $(this).addClass('off');
    $('.aPanel').addClass('off');
    $('.back').removeClass('off');
    $('.dPanel').removeClass('off');
});

$('.back').on("click", function () {
    $(this).addClass('off');
    $('.dPanel').addClass('off');
    $('.next').removeClass('off');
    $('.aPanel').removeClass('off');
});