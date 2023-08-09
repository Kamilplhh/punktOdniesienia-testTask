import './bootstrap';
import "@fortawesome/fontawesome-free/css/all.css";
import $ from 'jquery';
window.$ = $;

//Page onload functions
$(document).ready(function () {
  itemsPrice();
  getMonth(0);
  exceeded()
})

//Navbar show buttons
$(".dots").on("click", function () {
  $(".dotsBar").toggle();
});

function getMonth(x) {
  const m = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

  let date = new Date();
  let d = subtractMonths(date, x);
  let month = m[d.getMonth()];
  let year = d.getFullYear();

  $('.month').text(month);
  $('.year').text(year);
}

function subtractMonths(date, months) {
  date.setMonth(date.getMonth() - months);
  return date;
}

//Function to switch actual month
$('.arrow').on("click", function () {
  let id = $(this).attr('id');
  let val = parseInt($(this).attr('value'));

  if (id == "back") {
    let newVal = val + 1;
    getMonth(val);

    $(this).attr("value", newVal);
    $('#next').attr("value", val);
  } else {
    let newVal = val - 1;
    getMonth(newVal);

    $(this).attr("value", newVal);
    $('#back').attr("value", val);
  }

  if ($('#next').attr('value') > 0) {
    $('#next').removeClass("disabled");
  } else {
    $('#next').addClass("disabled");
  }

});

function itemsPrice() {
  let x = 0;

  $('.price').each(function () {
    if($(this).closest('.dataBlock').attr('class') != "dataBlock off") 
    x = x + parseInt($(this).text());
  })

  $('.cost').text(x + ' PLN');
}

//Check if there is no payment date exceed
function exceeded() {
  let date = new Date();

  $('span').filter('.unpaid').each(function() {
    let block = $(this).next();
    let textDate = new Date(block.text());

    let difference = date - textDate;
    if(difference > 0) {
      difference = Math.round(Math.abs(difference / (1000 * 3600 * 24))-1);
      if (difference > 1) {
        block.append('<h6 class="late">exceeded ' + difference + ' days</h6>')
      }else
      block.append('<h6 class="late">exceeded ' + difference + ' day</h6>')
    }
  })
}

//Whole panel navi system
$('.homeNavi').on("click", function () {
  let id = $(this).attr('id');

  if (id == "incoming") {
    showIncoming();
  } else if (id == "paid") {
    showPaid();
  } else {
    showAll();
  }

  $('#' + id).addClass("selected");
  $(".homeNavi:not(#" + id + ")").removeClass("selected");
  itemsPrice();
})

function showIncoming() {
  $('span').filter('.btn').each(function () {
    if ($(this).text() == "Paid") {
      $(this).closest('.dataBlock').addClass("off");
    } else {
      $(this).closest('.dataBlock').removeClass("off");
    }
  })
  $('.operations').children().each(function (){
    if($(this).hasClass("incoming")) {
      $(this).removeClass("off");
    }else {
      $(this).addClass("off");
    }
  })
}

function showPaid() {
  $('span').filter('.btn').each(function () {
    if ($(this).text() == "Unpaid") {
      $(this).closest('.dataBlock').addClass("off");
    } else {
      $(this).closest('.dataBlock').removeClass("off");
    }
  })
  $('.operations').children().each(function (){
    if($(this).hasClass("paid")) {
      $(this).removeClass("off");
    }else {
      $(this).addClass("off");
    }
  })
}

function showAll() {
  $('span').filter('.btn').each(function () {
    $(this).closest('.dataBlock').removeClass("off");
  })
  $('.operations').children().each(function (){
    if($(this).hasClass("all")) {
      $(this).removeClass("off");
    }else {
      $(this).addClass("off");
    }
  })
}