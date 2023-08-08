import './bootstrap';
import "@fortawesome/fontawesome-free/css/all.css";
import $ from 'jquery';
window.$ = $;

$(".dots").on("click", function () {
  $(".dotsBar").toggle();
});

$(document).ready(function () {
  itemsPrice();
  getMonth(0);

})

function subtractMonths(date, months) {
  date.setMonth(date.getMonth() - months);
  return date;
}

function getMonth(x) {
  const m = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

  let date = new Date();
  let d = subtractMonths(date, x);
  let month = m[d.getMonth()];
  let year = d.getFullYear();

  $('.month').text(month);
  $('.year').text(year);
}

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
}

function showPaid() {
  $('span').filter('.btn').each(function () {
    if ($(this).text() == "Unpaid") {
      $(this).closest('.dataBlock').addClass("off");
    } else {
      $(this).closest('.dataBlock').removeClass("off");
    }
  })
}

function showAll() {
  $('span').filter('.btn').each(function () {
    $(this).closest('.dataBlock').removeClass("off");
  })
}