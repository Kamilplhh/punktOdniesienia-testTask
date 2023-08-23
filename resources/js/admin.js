import '../css/admin.css';
import $, { error } from 'jquery';
window.$ = $;

$('.adminNavi').on("click", function () {
    let id = $(this).attr('id');

    if (id == "adminPanel") {
        $('.sPanel').addClass('off');
        $('.aPanel').removeClass('off');
    }else{
        $('.aPanel').addClass('off');
        $('.sPanel').removeClass('off');
    }

    $('#' + id).addClass("selected");
    $(".adminNavi:not(#" + id + ")").removeClass("selected");
});