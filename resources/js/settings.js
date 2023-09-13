import $, { error } from 'jquery';
window.$ = $;

$('.navi').on("click", function () {
    let id = $(this).attr('id');
  
    $('.' + id).removeClass("off");
    $(".block:not(." + id + ")").addClass("off");

    $('#' + id).addClass("text-primary");
    $('#' + id).removeClass("text-secondary");
    $(".navi:not(#" + id + ")").addClass("text-secondary");
    $(".navi:not(#" + id + ")").removeClass("text-primary");
  });