import './bootstrap';
import '../css/bootstrap.min.css';
import "@fortawesome/fontawesome-free/css/all.css";
import $, { error } from 'jquery';
window.$ = $;


$(document).ready(function () {
  $('.addon').on('click', function () {
    let text = $(this).closest("div").find("input").val();
    let sampleTextarea = document.createElement("textarea");

    document.body.appendChild(sampleTextarea);
    sampleTextarea.value = text; 
    sampleTextarea.select(); 
    document.execCommand("copy");
    document.body.removeChild(sampleTextarea);
  })
});
