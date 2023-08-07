import './bootstrap';
import "@fortawesome/fontawesome-free/css/all.css";
import $ from 'jquery';
window.$ = $;

$( ".dots" ).on( "click", function() {
    $(".dotsBar").toggle();
  } );