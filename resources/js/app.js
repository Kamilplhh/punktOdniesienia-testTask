import './bootstrap';
import "@fortawesome/fontawesome-free/css/all.css";
import $, { error } from 'jquery';
window.$ = $;

//Live preview for settings and register page
$(document).ready(function () {
  $('#company').on("input", function () {
    let text = $(this).val().replace(/\s/g,'');
    $('#labelEmail').text(text + "@domain.com");
  });
});

//Navbar show buttons
$(".dots").on("click", function () {
  $(".dotsBar").toggle();
});
